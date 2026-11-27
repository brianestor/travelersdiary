import type { Metadata } from "next";
import Link from "next/link";
import { SplitMedia } from "@/components/SplitMedia";
import { diaryEntries } from "@/lib/diary";
import { formatDate } from "@/lib/format";
import { media, type MediaAsset } from "@/lib/media";
import { getTour } from "@/lib/tours";

export const metadata: Metadata = {
  title: "Diary",
  description: "Field notes from Travelers Diary safaris, each one tied to a route you can reserve.",
};

const stills: MediaAsset[] = [media.elephant, media.rhino, media.lion, media.lunch];

export default function DiaryPage() {
  return (
    <div>
      <div className="mx-auto max-w-6xl px-5 py-10">
        <p className="text-xs font-light tracking-[0.22em] text-pale">Written by nature</p>
        <h1 className="display mt-3 text-4xl text-gold sm:text-5xl">The diary</h1>
        <p className="mt-4 max-w-2xl font-light leading-7 tracking-wide text-mist">
          Pages from the road. Each one belongs to a safari you can still join.
        </p>
      </div>
      {diaryEntries.map((entry, index) => {
        const tour = getTour(entry.tourSlug);
        const still = stills[index % stills.length];
        return (
          <SplitMedia key={entry.slug} item={still}>
            <p className="text-sm font-light tracking-wide text-mist">
              {entry.place} · {formatDate(entry.date)}
            </p>
            <h2 className="display mt-3 text-3xl text-gold">{entry.title}</h2>
            <div className="mt-4 max-w-xl space-y-4 font-light leading-8 tracking-wide">
              {entry.paragraphs.map((paragraph) => (
                <p key={paragraph}>{paragraph}</p>
              ))}
            </div>
            {tour ? (
              <Link href={`/safaris/${tour.slug}`} className="mt-5 inline-flex text-sm text-gold hover:underline">
                The route: {tour.title}
              </Link>
            ) : null}
          </SplitMedia>
        );
      })}
    </div>
  );
}
