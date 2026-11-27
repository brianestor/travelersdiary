import { BrandMark } from "./BrandMark";

export function SiteFooter() {
  return (
    <footer className="mt-16 border-t border-line">
      <div className="mx-auto max-w-6xl px-5 py-10">
        <BrandMark compact />
        <p className="mt-4 max-w-sm text-sm font-light leading-6 tracking-wide text-mist">
          Written by nature, lived by you. Small-camp safaris in Tanzania and Kenya. A
          reservation is a request — the desk confirms it, and nothing is charged on this site.
        </p>
      </div>
    </footer>
  );
}
