"use client";

import { useState, type FormEvent } from "react";


export function ContactForm() {
  const [error, setError] = useState<string | null>(null);
  const [sent, setSent] = useState(false);
  const [pending, setPending] = useState(false);

  async function onSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setPending(true);
    setError(null);
    const form = new FormData(event.currentTarget);
    const response = await fetch("/api/contact", {
      method: "POST",
      headers: { "content-type": "application/json" },
      body: JSON.stringify({
        name: form.get("name"),
        email: form.get("email"),
        message: form.get("message"),
      }),
    });
    const data = (await response.json()) as { error?: string };
    if (!response.ok) {
      setError(data.error ?? "The note could not be saved.");
      setPending(false);
      return;
    }
    setSent(true);
    setPending(false);
  }

  if (sent) {
    return (
      <p className="rounded-3xl border border-line p-6 font-light leading-7 tracking-wide">
        The desk has your note. It is saved here, not emailed. If you were asking about a date,
        you can also reserve a departure from the safari page.
      </p>
    );
  }

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      <label className="block text-sm">
        Name
        <input name="name" required autoComplete="name" className="field" />
      </label>
      <label className="block text-sm">
        Email
        <input name="email" type="email" required autoComplete="email" className="field" />
      </label>
      <label className="block text-sm">
        Message
        <textarea name="message" required rows={5} className="field" />
      </label>
      {error ? (
        <p className="text-sm text-gold" role="alert">
          {error}
        </p>
      ) : null}
      <button
        type="submit"
        disabled={pending}
        className="rounded-full bg-gold px-5 py-2.5 text-night hover:bg-pale disabled:opacity-60"
      >
        {pending ? "Saving…" : "Send the note"}
      </button>
    </form>
  );
}
