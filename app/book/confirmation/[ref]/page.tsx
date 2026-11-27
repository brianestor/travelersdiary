import type { Metadata } from "next";
import Link from "next/link";
import { notFound } from "next/navigation";
import { Suspense } from "react";
import { connection } from "next/server";
import { getBooking } from "@/lib/bookings";
import { formatDate } from "@/lib/format";
import { getTour } from "@/lib/tours";

export const metadata: Metadata = {
  title: "Reservation requested",
};

export default function ConfirmationPage({ params }: { params: Promise<{ ref: string }> }) {
  return (
    <Suspense fallback={<p className="mx-auto max-w-3xl px-5 py-16">Finding your reference…</p>}>
      <Confirmation params={params} />
    </Suspense>
  );
}

async function Confirmation({ params }: { params: Promise<{ ref: string }> }) {
  await connection();
  const { ref } = await params;
  const booking = await getBooking(ref);
  if (!booking) notFound();
  const tour = getTour(booking.tourSlug);
  const departure = tour?.departures.find((item) => item.id === booking.departureId);

  return (
    <div className="mx-auto max-w-3xl px-5 py-16">
      <p className="text-xs font-light tracking-[0.22em] text-pale">Requested, not yet confirmed</p>
      <h1 className="display mt-3 text-4xl text-gold sm:text-5xl">Your place is held as a request</h1>
      <p className="mt-4 font-light leading-7 tracking-wide text-mist">
        The desk will write to {booking.email} to confirm. Nothing has been charged.
      </p>
      <p className="display mt-8 text-3xl text-gold">{booking.reference}</p>
      <dl className="mt-6 space-y-2 text-sm leading-6">
        <div>
          <dt className="text-mist">Safari</dt>
          <dd>{tour?.title ?? booking.tourSlug}</dd>
        </div>
        {departure ? (
          <div>
            <dt className="text-mist">Dates</dt>
            <dd>
              {formatDate(departure.startDate)} – {formatDate(departure.endDate)}
            </dd>
          </div>
        ) : null}
        <div>
          <dt className="text-mist">Travelers</dt>
          <dd>
            {booking.leadName} · {booking.adults} adult{booking.adults === 1 ? "" : "s"}
            {booking.children > 0
              ? `, ${booking.children} child${booking.children === 1 ? "" : "ren"}`
              : ""}
          </dd>
        </div>
        <div>
          <dt className="text-mist">Status</dt>
          <dd className="capitalize">{booking.status}</dd>
        </div>
      </dl>
      <Link href="/safaris" className="mt-8 inline-flex text-sm text-gold hover:underline">
        Back to popular safari
      </Link>
    </div>
  );
}
