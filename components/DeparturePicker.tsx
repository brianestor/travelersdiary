"use client";

import Link from "next/link";
import { useState } from "react";

export type DepartureChoice = {
  id: string;
  label: string;
  priceLabel: string;
  seatsLeft: number;
};

export function DeparturePicker({
  tourSlug,
  departures,
}: {
  tourSlug: string;
  departures: DepartureChoice[];
}) {
  const open = departures.find((departure) => departure.seatsLeft > 0);
  const [departureId, setDepartureId] = useState(open?.id ?? "");
  const [adults, setAdults] = useState(2);
  const [children, setChildren] = useState(0);
  const selected = departures.find((departure) => departure.id === departureId);
  const party = adults + children;
  const blocked = !selected || party > selected.seatsLeft || party < 1;

  return (
    <form className="rounded-3xl border border-line bg-night p-5 text-pale">
      <h2 className="display text-xl text-gold">Reserve a departure</h2>
      <p className="mt-2 text-sm font-light leading-6 tracking-wide text-mist">
        Choose a date and a party size. You will add a name and contact on the next page. Nothing
        is charged.
      </p>
      <fieldset className="mt-5 space-y-3">
        <legend className="text-sm font-medium tracking-wide">Departures</legend>
        {departures.map((departure) => (
          <label
            key={departure.id}
            className="flex cursor-pointer items-start gap-3 rounded-2xl border border-line px-3 py-3 has-[:checked]:border-gold"
          >
            <input
              type="radio"
              name="departure"
              value={departure.id}
              checked={departureId === departure.id}
              disabled={departure.seatsLeft === 0}
              onChange={() => setDepartureId(departure.id)}
              className="mt-1"
            />
            <span>
              <span className="block text-sm">{departure.label}</span>
              <span className="block text-sm text-mist">
                {departure.priceLabel}
                {departure.seatsLeft === 0
                  ? " · full"
                  : ` · ${departure.seatsLeft} seat${departure.seatsLeft === 1 ? "" : "s"} left`}
              </span>
            </span>
          </label>
        ))}
      </fieldset>
      <div className="mt-4 grid grid-cols-2 gap-3">
        <label className="text-sm">
          Adults
          <input
            type="number"
            min={1}
            max={8}
            value={adults}
            onChange={(event) => setAdults(Number(event.target.value))}
            className="field"
          />
        </label>
        <label className="text-sm">
          Children
          <input
            type="number"
            min={0}
            max={6}
            value={children}
            onChange={(event) => setChildren(Number(event.target.value))}
            className="field"
          />
        </label>
      </div>
      {blocked ? (
        <p className="mt-4 text-sm text-gold">
          {selected && party > selected.seatsLeft
            ? "That party is larger than the seats left on this departure."
            : "Every listed departure is full."}
        </p>
      ) : null}
      {blocked ? (
        <span className="mt-4 inline-flex rounded-full bg-line px-4 py-2 text-sm text-mist">Continue</span>
      ) : (
        <Link
          href={`/book?tour=${tourSlug}&departure=${departureId}&adults=${adults}&children=${children}`}
          className="mt-4 inline-flex rounded-full bg-gold px-4 py-2 text-sm text-night hover:bg-pale"
        >
          Continue
        </Link>
      )}
    </form>
  );
}
