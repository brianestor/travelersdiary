import type { Metadata } from "next";
import Link from "next/link";
import { Suspense } from "react";
import { connection } from "next/server";
import { BookingForm } from "@/components/BookingForm";
import { departuresForTour, seatsLeft } from "@/lib/bookings";
import { formatDate, formatMoney } from "@/lib/format";
import { getTour } from "@/lib/tours";

export const metadata: Metadata = {
  title: "Request a reservation",
};

export default function BookPage({
  searchParams,
}: {
  searchParams: Promise<{ tour?: string; departure?: string; adults?: string; children?: string }>;
}) {
  return (
    <Suspense fallback={<p className="mx-auto max-w-3xl px-5 py-16">Opening the reservation…</p>}>
      <BookFlow searchParams={searchParams} />
    </Suspense>
  );
}

async function BookFlow({
  searchParams,
}: {
  searchParams: Promise<{ tour?: string; departure?: string; adults?: string; children?: string }>;
}) {
  await connection();
  const query = await searchParams;
  const tour = query.tour ? getTour(query.tour) : undefined;
  const adults = Number(query.adults);
  const children = Number(query.children);
  const rows = tour ? await departuresForTour(tour.slug) : [];
  const departure = rows.find((row) => row.id === query.departure);
  const partyReady =
    Number.isInteger(adults) &&
    Number.isInteger(children) &&
    adults >= 1 &&
    children >= 0 &&
    adults + children <= 8;

  if (!tour || !departure || !partyReady) {
    return (
      <div className="mx-auto max-w-3xl px-5 py-16">
        <h1 className="display text-3xl text-gold">Choose a departure first</h1>
        <p className="mt-4 font-light leading-7 tracking-wide text-mist">
          A reservation starts on Plan a safari, where you can see the dates and the seats left.
        </p>
        <Link href="/plan" className="mt-6 inline-flex text-gold hover:underline">
          Plan a safari
        </Link>
      </div>
    );
  }

  const party = adults + children;
  const left = seatsLeft(departure);
  const total = party * departure.pricePerPerson;

  return (
    <div className="mx-auto grid max-w-6xl gap-10 px-5 py-12 lg:grid-cols-2">
      <div>
        <p className="text-xs font-light tracking-[0.22em] text-pale">Reservation request</p>
        <h1 className="display mt-3 text-4xl text-gold sm:text-5xl">{tour.title}</h1>
        <dl className="mt-6 space-y-3 text-sm leading-6">
          <div>
            <dt className="text-mist">Dates</dt>
            <dd>
              {formatDate(departure.startDate)} – {formatDate(departure.endDate)}
            </dd>
          </div>
          <div>
            <dt className="text-mist">Party</dt>
            <dd>
              {adults} adult{adults === 1 ? "" : "s"}
              {children > 0 ? `, ${children} child${children === 1 ? "" : "ren"}` : ""}
            </dd>
          </div>
          <div>
            <dt className="text-mist">Seats still open</dt>
            <dd>{left}</dd>
          </div>
          <div>
            <dt className="text-mist">Estimate</dt>
            <dd>
              {formatMoney(total)} · {formatMoney(departure.pricePerPerson)} per person, children
              included at the same rate
            </dd>
          </div>
        </dl>
        {party > left ? (
          <p className="mt-6 text-sm text-gold">
            Those seats were taken. Go back and choose another departure.
          </p>
        ) : (
          <p className="mt-6 text-sm font-light leading-6 tracking-wide text-mist">
            The estimate is for the desk to confirm. This page does not take a payment.
          </p>
        )}
        <Link href={`/safaris/${tour.slug}`} className="mt-4 inline-flex text-sm text-gold hover:underline">
          Change the departure
        </Link>
      </div>
      <div className="rounded-3xl border border-line p-6">
        {party > left ? null : (
          <BookingForm
            tourSlug={tour.slug}
            departureId={departure.id}
            adults={adults}
            childCount={children}
          />
        )}
      </div>
    </div>
  );
}
