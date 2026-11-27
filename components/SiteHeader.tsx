import Link from "next/link";
import { BrandMark } from "./BrandMark";

export function SiteHeader() {
  return (
    <header className="border-b border-line bg-night/95">
      <div className="mx-auto flex max-w-6xl items-center justify-center px-5 py-4">
        <Link
          href="/"
          className="rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold"
        >
          <BrandMark />
        </Link>
      </div>
    </header>
  );
}
