import type { Metadata } from "next";
import { Suspense } from "react";
import { connection } from "next/server";
import { SplitMedia } from "@/components/SplitMedia";
import { PlanSafari } from "@/components/PlanSafari";
import { departuresForTour, seatsLeft } from "@/lib/bookings";
import { formatDate, formatMoney } from "@/lib/format";
import { media } from "@/lib/media";
import { tours } from "@/lib/tours";

export const metadata: Metadata = {
  title: "Plan a safari",
  description: "Choose a safari, a departure, and a party size. The desk confirms the reservation.",
};

export default function PlanPage() {
  return (
    <Suspense fallback={<p className="mx-auto max-w-6xl px-5 py-16 text-mist">Opening the planner…</p>}>
      <PlanFlow />
    </Suspense>
  );
}

async function PlanFlow() {
  await connection();
  const choices = await Promise.all(
    tours.map(async (tour) => {
      const live = await departuresForTour(tour.slug);
      return {
        slug: tour.slug,
        title: tour.title,
        region: tour.region,
        country: tour.country,
        departures: live
          .slice()
          .sort((a, b) => a.startDate.localeCompare(b.startDate))
          .map((departure) => ({
            id: departure.id,
            label: `${formatDate(departure.startDate)} – ${formatDate(departure.endDate)}`,
            priceLabel: `${formatMoney(departure.pricePerPerson)} per person`,
            seatsLeft: seatsLeft(departure),
          })),
      };
    }),
  );

  return (
    <SplitMedia item={media.lunch} tone="khaki">
      <p className="text-xs font-light tracking-[0.22em]">A reservation request</p>
      <h1 className="display mt-3 text-4xl sm:text-5xl">Plan a safari</h1>
      <p className="mt-4 max-w-2xl font-light leading-7 tracking-wide">
        Choose the route, the departure, and who is traveling. You will leave a name and contact
        on the next page. Nothing is charged.
      </p>
      <div className="mt-8">
        <PlanSafari tours={choices} />
      </div>
    </SplitMedia>
  );
}
