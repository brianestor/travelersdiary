import type { Metadata } from "next";
import Link from "next/link";

export const metadata: Metadata = {
  title: "Page not found",
};

export default function NotFound() {
  return (
    <div className="mx-auto max-w-3xl px-5 py-20">
      <h1 className="display text-4xl text-gold sm:text-5xl">That page is not in the diary</h1>
      <p className="mt-4 font-light tracking-wide text-mist">The route may have moved, or the reference is not on this desk.</p>
      <Link href="/" className="mt-6 inline-flex text-gold hover:underline">
        Return home
      </Link>
    </div>
  );
}
