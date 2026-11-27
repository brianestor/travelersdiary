import { randomBytes } from "node:crypto";
import { mkdir, readFile, writeFile } from "node:fs/promises";
import path from "node:path";
import { getTour, tours, type Departure } from "./tours";

export type DepartureState = Departure & {
  tourSlug: string;
  seatsTaken: number;
};

export type Booking = {
  reference: string;
  tourSlug: string;
  departureId: string;
  adults: number;
  children: number;
  leadName: string;
  email: string;
  phone: string;
  notes: string;
  status: "requested";
  createdAt: string;
};

export type ContactMessage = {
  id: string;
  name: string;
  email: string;
  message: string;
  createdAt: string;
};

type DepartureFile = {
  id: string;
  tourSlug: string;
  startDate: string;
  endDate: string;
  capacity: number;
  pricePerPerson: number;
  seatsTaken: number;
};

const dataDir = path.join(process.cwd(), "data");
const departuresPath = path.join(dataDir, "departures.json");
const bookingsPath = path.join(dataDir, "bookings.json");
const messagesPath = path.join(dataDir, "messages.json");

let queue: Promise<unknown> = Promise.resolve();

function locked<T>(task: () => Promise<T>) {
  const run = queue.then(task, task);
  queue = run.then(
    () => undefined,
    () => undefined,
  );
  return run;
}

export class ReservationError extends Error {
  constructor(message: string) {
    super(message);
    this.name = "ReservationError";
  }
}

async function readJson<T>(file: string, fallback: T): Promise<T> {
  try {
    return JSON.parse(await readFile(file, "utf8")) as T;
  } catch (error) {
    if ((error as NodeJS.ErrnoException).code === "ENOENT") return fallback;
    throw error;
  }
}

async function writeJson(file: string, value: unknown) {
  await mkdir(dataDir, { recursive: true });
  await writeFile(file, `${JSON.stringify(value, null, 2)}\n`, "utf8");
}

function catalogRows(): DepartureFile[] {
  return tours.flatMap((tour) =>
    tour.departures.map((departure) => ({
      ...departure,
      tourSlug: tour.slug,
      seatsTaken: 0,
    })),
  );
}

function mergeDepartures(stored: DepartureFile[]): DepartureFile[] {
  const previous = new Map(stored.map((row) => [row.id, row]));
  return catalogRows().map((row) => {
    const saved = previous.get(row.id);
    const seatsTaken = saved?.seatsTaken ?? 0;
    return {
      ...row,
      seatsTaken: Number.isInteger(seatsTaken) && seatsTaken > 0 ? seatsTaken : 0,
    };
  });
}

export function seatsLeft(row: { capacity: number; seatsTaken: number }) {
  return Math.max(0, row.capacity - row.seatsTaken);
}

export async function listDepartureStates() {
  const stored = await readJson<DepartureFile[]>(departuresPath, []);
  return mergeDepartures(stored);
}

export async function departuresForTour(slug: string) {
  const rows = await listDepartureStates();
  return rows.filter((row) => row.tourSlug === slug);
}

function asInt(value: unknown) {
  const number = typeof value === "number" ? value : typeof value === "string" ? Number(value) : NaN;
  return Number.isInteger(number) ? number : NaN;
}

function text(value: unknown, max: number) {
  if (typeof value !== "string") return "";
  return value.trim().slice(0, max);
}

function partyError(adults: number, children: number) {
  if (!Number.isInteger(adults) || adults < 1 || adults > 8) {
    return "Include at least one adult, and no more than eight.";
  }
  if (!Number.isInteger(children) || children < 0 || children > 6) {
    return "Children must be between zero and six.";
  }
  if (adults + children > 8) {
    return "A single reservation can hold up to eight travelers.";
  }
  return null;
}

export async function createBooking(input: unknown) {
  return locked(async () => {
    if (!input || typeof input !== "object") {
      throw new ReservationError("The reservation details were missing.");
    }
    const body = input as Record<string, unknown>;
    const tourSlug = text(body.tourSlug, 80);
    const departureId = text(body.departureId, 80);
    const adults = asInt(body.adults);
    const children = asInt(body.children);
    const leadName = text(body.leadName, 80);
    const email = text(body.email, 120);
    const phone = text(body.phone, 30);
    const notes = text(body.notes, 800);

    const tour = getTour(tourSlug);
    if (!tour) throw new ReservationError("Choose a safari from the list.");

    const party = partyError(adults, children);
    if (party) throw new ReservationError(party);
    if (leadName.length < 2) throw new ReservationError("Add the name of the lead traveler.");
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      throw new ReservationError("Add an email the desk can reply to.");
    }
    const digits = phone.replace(/\D/g, "");
    if (digits.length < 7 || digits.length > 15) {
      throw new ReservationError("Add a phone number with at least seven digits.");
    }

    const stored = await readJson<DepartureFile[]>(departuresPath, []);
    const rows = mergeDepartures(stored);
    const departure = rows.find((row) => row.id === departureId && row.tourSlug === tour.slug);
    if (!departure) throw new ReservationError("That departure is no longer listed.");

    const size = adults + children;
    if (size > seatsLeft(departure)) {
      throw new ReservationError("This departure does not have enough seats left for that party.");
    }

    const bookings = await readJson<Booking[]>(bookingsPath, []);
    const booking: Booking = {
      reference: `TD-${randomBytes(4).toString("hex").toUpperCase()}`,
      tourSlug: tour.slug,
      departureId: departure.id,
      adults,
      children,
      leadName,
      email,
      phone,
      notes,
      status: "requested",
      createdAt: new Date().toISOString(),
    };

    departure.seatsTaken += size;
    await writeJson(departuresPath, rows);
    try {
      await writeJson(bookingsPath, [...bookings, booking]);
    } catch (error) {
      departure.seatsTaken -= size;
      await writeJson(departuresPath, rows);
      throw error;
    }
    return booking;
  });
}

export async function listBookings() {
  const bookings = await readJson<Booking[]>(bookingsPath, []);
  return [...bookings].sort((a, b) => b.createdAt.localeCompare(a.createdAt));
}

export async function getBooking(reference: string) {
  const bookings = await readJson<Booking[]>(bookingsPath, []);
  return bookings.find((booking) => booking.reference === reference) ?? null;
}

export async function saveMessage(input: unknown) {
  return locked(async () => {
    if (!input || typeof input !== "object") {
      throw new ReservationError("The message was empty.");
    }
    const body = input as Record<string, unknown>;
    const name = text(body.name, 80);
    const email = text(body.email, 120);
    const message = text(body.message, 2000);
    if (name.length < 2) throw new ReservationError("Add your name.");
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      throw new ReservationError("Add an email the desk can reply to.");
    }
    if (message.length < 8) throw new ReservationError("Write a short note so the desk knows how to help.");

    const messages = await readJson<ContactMessage[]>(messagesPath, []);
    const saved: ContactMessage = {
      id: randomBytes(4).toString("hex"),
      name,
      email,
      message,
      createdAt: new Date().toISOString(),
    };
    await writeJson(messagesPath, [...messages, saved]);
    return saved;
  });
}
