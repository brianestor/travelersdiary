import type { Metadata } from "next";
import { ContactForm } from "@/components/ContactForm";
import { SplitMedia } from "@/components/SplitMedia";
import { media } from "@/lib/media";

export const metadata: Metadata = {
  title: "Contacts",
  description: "Write to the Travelers Diary desk. Questions live here; reservations start on Plan a safari.",
};

export default function ContactPage() {
  return (
    <SplitMedia item={media.lion}>
      <p className="text-xs font-light tracking-[0.22em] text-pale">The desk</p>
      <h1 className="display mt-3 text-4xl text-gold sm:text-5xl">Contacts</h1>
      <div className="mt-5 max-w-xl space-y-4 font-light leading-7 tracking-wide text-mist">
        <p>
          Questions come here. A reservation — dates, seats, names — starts on Plan a safari so the
          right departure is held.
        </p>
        <p>
          Notes are saved for the desk on this machine. They are not emailed, and this address is a
          placeholder until the real desk inbox is connected.
        </p>
        <p className="text-pale">hello@travelersdiary.example</p>
      </div>
      <div className="mt-8 max-w-xl">
        <ContactForm />
      </div>
    </SplitMedia>
  );
}
