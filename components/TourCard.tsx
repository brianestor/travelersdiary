import Link from "next/link";
import { MediaFrame } from "@/components/MediaFrame";
import { formatDate, formatMoney } from "@/lib/format";
import { stillForTour } from "@/lib/media";
import { priceFrom, type Tour } from "@/lib/tours";

export function TourCard({ tour }: { tour: Tour }) {
  const opening = [...tour.departures].sort((a, b) => a.startDate.localeCompare(b.startDate))[0];
  const still = stillForTour(tour.slug);

  return (
    <article className="split-card">
      <div className="split-card-visual">
        <MediaFrame item={still} />
      </div>
      <div className="split-card-copy">
        <p className="text-xs font-light tracking-[0.16em] text-gold">
          {tour.country} · {tour.durationDays} days
        </p>
        <h2 className="display mt-3 text-2xl text-pale">{tour.title}</h2>
        <p className="mt-3 font-light leading-7 tracking-wide text-mist">{tour.summary}</p>
        <p className="mt-4 text-sm text-pale">
          From {formatMoney(priceFrom(tour))} per person
          {opening ? ` · next departure ${formatDate(opening.startDate)}` : null}
        </p>
        <Link
          href={`/safaris/${tour.slug}`}
          className="mt-5 inline-flex w-fit rounded-full bg-gold px-4 py-2 text-sm text-night hover:bg-pale focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold"
        >
          View the route
        </Link>
      </div>
    </article>
  );
}
