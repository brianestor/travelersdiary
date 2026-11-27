import Link from "next/link";
import { MediaFrame } from "@/components/MediaFrame";
import { SplitMedia } from "@/components/SplitMedia";
import { media } from "@/lib/media";

const columns = [
  { href: "/safaris", label: "Popular safari", body: "The routes travelers ask for first.", item: media.elephant },
  { href: "/diary", label: "Diary", body: "Pages from the road, each tied to a safari.", item: media.lion },
  { href: "/plan", label: "Plan a safari", body: "Choose a departure and request the seats.", item: media.lunch },
];

export default function Home() {
  return (
    <div>
      <SplitMedia item={media.plains} hero>
        <p className="text-sm font-light tracking-[0.22em] text-pale">Written by nature, lived by you</p>
        <h1 className="display mt-4 text-4xl text-gold sm:text-5xl">Travelers Diary</h1>
        <p className="mt-5 max-w-xl text-lg font-light leading-8 tracking-wide text-mist">
          Experience life-changing safaris in Tanzania wildlife, starting from the wild variety of
          creatures from the highland to the rivers. You live the days and keep the page.
        </p>
      </SplitMedia>

      <div className="home-grid">
        {columns.map((column) => (
          <Link
            key={column.href}
            href={column.href}
            className="block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold"
          >
            <SplitMedia item={column.item}>
              <h2 className="display text-2xl text-gold">{column.label}</h2>
              <p className="mt-2 max-w-md text-sm font-light leading-6 tracking-wide text-mist">{column.body}</p>
            </SplitMedia>
          </Link>
        ))}

        <SplitMedia item={media.cheetah}>
          <p className="text-xs font-light tracking-[0.22em] text-pale">From the grass</p>
          <h2 className="display mt-3 text-3xl text-gold">A mother and her cubs</h2>
          <p className="mt-4 max-w-md font-light leading-7 tracking-wide text-mist">
            The Serengeti page is often this quiet: the family in the grass, and the vehicle left
            where it stopped.
          </p>
          <Link href="/safaris/serengeti-migration" className="mt-5 inline-flex text-sm text-gold hover:underline">
            The Serengeti route
          </Link>
        </SplitMedia>
      </div>

      <div className="flex justify-center">
        <MediaFrame item={media.drive} />
      </div>
    </div>
  );
}
