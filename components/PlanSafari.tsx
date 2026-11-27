"use client";

import { useState } from "react";
import { DeparturePicker, type DepartureChoice } from "@/components/DeparturePicker";

export type PlanTour = {
  slug: string;
  title: string;
  region: string;
  country: string;
  departures: DepartureChoice[];
};

export function PlanSafari({ tours }: { tours: PlanTour[] }) {
  const [slug, setSlug] = useState(tours[0]?.slug ?? "");
  const tour = tours.find((item) => item.slug === slug) ?? tours[0];

  if (!tour) {
    return <p className="text-sm text-ink">No safaris are open to plan yet.</p>;
  }

  return (
    <div className="mt-8 grid items-start gap-8 lg:grid-cols-[0.9fr_1.1fr]">
      <fieldset className="space-y-3">
        <legend className="display text-sm text-ink">Choose a safari</legend>
        {tours.map((item) => (
          <label
            key={item.slug}
            className="flex cursor-pointer items-start gap-3 rounded-2xl border border-ink/20 bg-khaki px-3 py-3 has-[:checked]:border-ink"
          >
            <input
              type="radio"
              name="safari"
              value={item.slug}
              checked={tour.slug === item.slug}
              onChange={() => setSlug(item.slug)}
              className="mt-1"
            />
            <span>
              <span className="display block text-sm text-ink">{item.title}</span>
              <span className="mt-1 block text-sm text-ink/70">
                {item.region} · {item.country}
              </span>
            </span>
          </label>
        ))}
      </fieldset>
      <DeparturePicker key={tour.slug} tourSlug={tour.slug} departures={tour.departures} />
    </div>
  );
}
