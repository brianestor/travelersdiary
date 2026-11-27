import type { Metadata } from "next";
import Link from "next/link";
import { notFound } from "next/navigation";
import { Suspense } from "react";
import { connection } from "next/server";
import { DeparturePicker } from "@/components/DeparturePicker";
import { SplitMedia } from "@/components/SplitMedia";
import { entriesForTour } from "@/lib/diary";
import { departuresForTour, seatsLeft } from "@/lib/bookings";
import { formatDate, formatMoney } from "@/lib/format";
import { stillForTour } from "@/lib/media";
import { getTour, priceFrom, tours } from "@/lib/tours";

export function generateStaticParams() {
  return tours.map((tour) => ({ slug: tour.slug }));
}

export async function generateMetadata({
  params,
}: {
  params: Promise<{ slug: string }>;
}): Promise<Metadata> {
  const { slug } = await params;
  const tour = getTour(slug);
  if (!tour) return { title: "Safari" };
  return {
    title: tour.title,
    description: tour.summary,
  };
}

export default async function SafariPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = await params;
  const tour = getTour(slug);
  if (!tour) notFound();
  const notes = entriesForTour(tour.slug);

  return (
    <div className="mx-auto max-w-6xl px-5 py-12">
      <p className="text-sm text-mist">
        <Link href="/safaris" className="hover:text-gold">
          Popular safari
        </Link>{" "}
        / {tour.country}
      </p>
      <SplitMedia item={stillForTour(tour.slug)}>
        <p className="text-sm font-light tracking-[0.16em] text-pale">
          {tour.region} · {tour.durationDays} days · from {formatMoney(priceFrom(tour))}
        </p>
        <h1 className="display mt-3 text-4xl text-gold sm:text-5xl">{tour.title}</h1>
        <p className="mt-4 max-w-2xl text-lg font-light leading-8 tracking-wide text-mist">{tour.summary}</p>
      </SplitMedia>

      <div className="mt-10 grid items-start gap-10 lg:grid-cols-[1.2fr_0.8fr]">
        <div>
          <h2 className="display text-2xl text-gold">The days</h2>
          <ol className="mt-5 space-y-5">
            {tour.itinerary.map((day) => (
              <li key={day.day} className="border-l border-gold pl-4">
                <p className="text-sm tracking-[0.14em] text-gold">Day {day.day}</p>
                <h3 className="display mt-1 text-xl text-pale">{day.title}</h3>
                <p className="mt-1 font-light leading-7 tracking-wide text-mist">{day.body}</p>
              </li>
            ))}
          </ol>
          <div className="mt-10 grid gap-8 sm:grid-cols-2">
            <div>
              <h2 className="display text-xl text-gold">Included</h2>
              <ul className="mt-3 list-disc space-y-2 pl-5 text-sm font-light leading-6 tracking-wide text-mist">
                {tour.inclusions.map((item) => (
                  <li key={item}>{item}</li>
                ))}
              </ul>
            </div>
            <div>
              <h2 className="display text-xl text-gold">Not included</h2>
              <ul className="mt-3 list-disc space-y-2 pl-5 text-sm font-light leading-6 tracking-wide text-mist">
                {tour.exclusions.map((item) => (
                  <li key={item}>{item}</li>
                ))}
              </ul>
            </div>
          </div>
          <p className="mt-8 max-w-xl text-lg font-light leading-8 tracking-wide text-pale">{tour.fieldNote}</p>
          {notes.length > 0 ? (
            <p className="mt-4 text-sm">
              <Link href="/diary" className="text-gold hover:underline">
                Read the diary pages from this route
              </Link>
            </p>
          ) : null}
        </div>
        <Suspense fallback={<p className="text-sm text-mist">Checking seats…</p>}>
          <SeatPanel slug={tour.slug} />
        </Suspense>
      </div>
    </div>
  );
}

async function SeatPanel({ slug }: { slug: string }) {
  await connection();
  const tour = getTour(slug);
  if (!tour) return null;
  const live = await departuresForTour(slug);
  const departures = live
    .slice()
    .sort((a, b) => a.startDate.localeCompare(b.startDate))
    .map((departure) => ({
      id: departure.id,
      label: `${formatDate(departure.startDate)} – ${formatDate(departure.endDate)}`,
      priceLabel: `${formatMoney(departure.pricePerPerson)} per person`,
      seatsLeft: seatsLeft(departure),
    }));

  return <DeparturePicker tourSlug={tour.slug} departures={departures} />;
}
