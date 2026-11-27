import type { Metadata } from "next";
import { TourCard } from "@/components/TourCard";
import { tours } from "@/lib/tours";

export const metadata: Metadata = {
  title: "Popular safari",
  description: "Fixed-date safaris in Tanzania and Kenya, with seats held when you request a reservation.",
};

export default function SafarisPage() {
  const countries = ["Tanzania", "Kenya"];

  return (
    <div className="mx-auto max-w-6xl px-5 py-12">
      <p className="text-xs font-light tracking-[0.22em] text-pale">The routes</p>
      <h1 className="display mt-3 text-4xl text-gold sm:text-5xl">Popular safari</h1>
      <p className="mt-4 max-w-2xl font-light leading-7 tracking-wide text-mist">
        Four journeys, each with its own departures. Open a route, choose a date, and send the
        desk a reservation request.
      </p>
      {countries.map((country) => (
        <section key={country} className="mt-12">
          <h2 className="display text-2xl text-gold">{country}</h2>
          <div className="mt-5 grid gap-5 md:grid-cols-2">
            {tours
              .filter((tour) => tour.country === country)
              .map((tour) => (
                <TourCard key={tour.slug} tour={tour} />
              ))}
          </div>
        </section>
      ))}
    </div>
  );
}
