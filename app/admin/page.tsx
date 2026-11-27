import type { Metadata } from "next";
import { Suspense } from "react";
import { connection } from "next/server";
import { listBookings, listDepartureStates, seatsLeft } from "@/lib/bookings";
import { formatDate, formatMoney, formatWhen } from "@/lib/format";
import { adminConfigured, isStaff } from "@/lib/staff";
import { getTour } from "@/lib/tours";

export const metadata: Metadata = {
  title: "Desk",
  robots: { index: false, follow: false },
};

export default function AdminPage({
  searchParams,
}: {
  searchParams: Promise<{ error?: string }>;
}) {
  return (
    <Suspense fallback={<p className="mx-auto max-w-3xl px-5 py-16">Opening the desk…</p>}>
      <Desk searchParams={searchParams} />
    </Suspense>
  );
}

async function Desk({ searchParams }: { searchParams: Promise<{ error?: string }> }) {
  await connection();
  const query = await searchParams;
  const signedIn = await isStaff();

  if (!signedIn) {
    const error =
      query.error === "password"
        ? "That password does not open the desk."
        : query.error === "config"
          ? "Set ADMIN_PASSWORD in .env.local, then try again."
          : null;
    return (
      <div className="mx-auto max-w-md px-5 py-16">
        <h1 className="display text-3xl text-gold">Staff desk</h1>
        <p className="mt-3 text-sm font-light leading-6 tracking-wide text-mist">
          Reservations and remaining seats. This page is for the team.
        </p>
        {!adminConfigured() ? (
          <p className="mt-4 text-sm text-gold">ADMIN_PASSWORD is not set.</p>
        ) : null}
        <form action="/api/admin/login" method="post" className="mt-6 space-y-4">
          <label className="block text-sm">
            Password
            <input
              type="password"
              name="password"
              required
              className="field"
            />
          </label>
          {error ? <p className="text-sm text-gold">{error}</p> : null}
          <button type="submit" className="rounded-full bg-gold px-5 py-2.5 text-night">
            Open the desk
          </button>
        </form>
      </div>
    );
  }

  const [bookings, departures] = await Promise.all([listBookings(), listDepartureStates()]);

  return (
    <div className="mx-auto max-w-6xl px-5 py-12">
      <div className="flex flex-wrap items-end justify-between gap-4">
        <div>
          <p className="text-xs font-light tracking-[0.22em] text-pale">Staff</p>
          <h1 className="display mt-3 text-4xl text-gold sm:text-5xl">Reservations</h1>
        </div>
        <form action="/api/admin/logout" method="post">
          <button type="submit" className="text-sm text-mist hover:text-gold">
            Lock the desk
          </button>
        </form>
      </div>
      <p className="mt-3 max-w-2xl text-sm font-light leading-6 tracking-wide text-mist">
        Every row is a request. Confirming still happens by writing to the traveler. This list does
        not take payment.
      </p>

      <div className="mt-8 space-y-4">
        {bookings.length === 0 ? (
          <p className="rounded-3xl border border-dashed border-line px-5 py-8 text-sm text-mist">
            No reservations yet.
          </p>
        ) : (
          bookings.map((booking) => {
            const tour = getTour(booking.tourSlug);
            const departure = tour?.departures.find((item) => item.id === booking.departureId);
            return (
              <article key={booking.reference} className="rounded-3xl border border-line p-5">
                <div className="flex flex-wrap items-baseline justify-between gap-2">
                  <h2 className="display text-xl text-gold">{booking.reference}</h2>
                  <p className="text-sm capitalize text-pale">{booking.status}</p>
                </div>
                <p className="mt-1 text-sm text-mist">{formatWhen(booking.createdAt)}</p>
                <dl className="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                  <div>
                    <dt className="text-mist">Safari</dt>
                    <dd>{tour?.title ?? booking.tourSlug}</dd>
                  </div>
                  <div>
                    <dt className="text-mist">Dates</dt>
                    <dd>
                      {departure
                        ? `${formatDate(departure.startDate)} – ${formatDate(departure.endDate)}`
                        : booking.departureId}
                    </dd>
                  </div>
                  <div>
                    <dt className="text-mist">Party</dt>
                    <dd>
                      {booking.leadName} · {booking.adults} adult{booking.adults === 1 ? "" : "s"}
                      {booking.children > 0
                        ? `, ${booking.children} ${booking.children === 1 ? "child" : "children"}`
                        : ""}
                    </dd>
                  </div>
                  <div>
                    <dt className="text-mist">Contact</dt>
                    <dd>
                      {booking.email}
                      <br />
                      {booking.phone}
                    </dd>
                  </div>
                </dl>
                {booking.notes ? <p className="mt-3 text-sm leading-6">{booking.notes}</p> : null}
              </article>
            );
          })
        )}
      </div>

      <h2 className="display mt-12 text-2xl text-gold">Seats</h2>
      <ul className="mt-4 divide-y divide-line rounded-3xl border border-line">
        {departures.map((departure) => {
          const tour = getTour(departure.tourSlug);
          const left = seatsLeft(departure);
          return (
            <li key={departure.id} className="flex flex-wrap items-center justify-between gap-2 px-5 py-3 text-sm">
              <span>
                {tour?.title ?? departure.tourSlug}
                <span className="text-mist"> · {formatDate(departure.startDate)}</span>
              </span>
              <span>
                {left} of {departure.capacity} left · {formatMoney(departure.pricePerPerson)}
              </span>
            </li>
          );
        })}
      </ul>
    </div>
  );
}
