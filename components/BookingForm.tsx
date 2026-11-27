"use client";

import { useRouter } from "next/navigation";
import { useState, type FormEvent } from "react";


export function BookingForm({
  tourSlug,
  departureId,
  adults,
  childCount,
}: {
  tourSlug: string;
  departureId: string;
  adults: number;
  childCount: number;
}) {
  const router = useRouter();
  const [error, setError] = useState<string | null>(null);
  const [pending, setPending] = useState(false);

  async function onSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setPending(true);
    setError(null);
    const form = new FormData(event.currentTarget);
    const response = await fetch("/api/bookings", {
      method: "POST",
      headers: { "content-type": "application/json" },
      body: JSON.stringify({
        tourSlug,
        departureId,
        adults,
        children: childCount,
        leadName: form.get("leadName"),
        email: form.get("email"),
        phone: form.get("phone"),
        notes: form.get("notes"),
      }),
    });
    const data = (await response.json()) as { reference?: string; error?: string };
    if (!response.ok || !data.reference) {
      setError(data.error ?? "The desk could not save this reservation.");
      setPending(false);
      return;
    }
    router.push(`/book/confirmation/${data.reference}`);
  }

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      <label className="block text-sm">
        Lead traveler
        <input name="leadName" required autoComplete="name" className="field" />
      </label>
      <label className="block text-sm">
        Email
        <input name="email" type="email" required autoComplete="email" className="field" />
      </label>
      <label className="block text-sm">
        Phone
        <input name="phone" type="tel" required autoComplete="tel" className="field" />
      </label>
      <label className="block text-sm">
        Notes for the desk
        <textarea name="notes" rows={4} className="field" placeholder="Room arrangements, celebrations, mobility." />
      </label>
      {error ? (
        <p className="rounded-2xl border border-gold px-3 py-2 text-sm text-gold" role="alert">
          {error}
        </p>
      ) : null}
      <button
        type="submit"
        disabled={pending}
        className="rounded-full bg-gold px-5 py-2.5 text-night hover:bg-pale disabled:opacity-60"
      >
        {pending ? "Saving…" : "Request this reservation"}
      </button>
      <p className="text-sm font-light leading-6 tracking-wide text-mist">
        This saves a request. The desk confirms it with you. Nothing is charged on this site.
      </p>
    </form>
  );
}
