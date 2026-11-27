import { brand } from "@/lib/brand";

export function BrandMark({ compact = false }: { compact?: boolean }) {
  return (
    <span className="flex items-center gap-3">
      {/* Black plate disappears on the charcoal bar; the gold feather stays. */}
      {/* eslint-disable-next-line @next/next/no-img-element */}
      <img
        src={brand.mark}
        alt=""
        className={`${compact ? "h-10 w-10" : "h-14 w-14"} object-contain mix-blend-screen`}
      />
      <span className="flex flex-col leading-none">
        <span className={`display text-gold ${compact ? "text-xs" : "text-sm"}`}>Travelers Diary</span>
        {compact ? null : (
          <span className="mt-1 text-[0.7rem] font-light tracking-[0.14em] text-pale">
            Written by nature, lived by you
          </span>
        )}
      </span>
    </span>
  );
}
