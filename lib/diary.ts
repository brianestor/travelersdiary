export type DiaryEntry = {
  slug: string;
  title: string;
  place: string;
  date: string;
  tourSlug: string;
  paragraphs: string[];
};

export const diaryEntries: DiaryEntry[] = [
  {
    slug: "dawn-line",
    title: "A dark line at dawn",
    place: "Ndutu, Serengeti",
    date: "2026-02-18",
    tourSlug: "serengeti-migration",
    paragraphs: [
      "The herd was not a sighting. It was a change in the colour of the ground, a kilometre out, still deciding whether to move.",
      "We switched the engine off. The guide passed the binoculars without talking. In the book that night I wrote only the time, and the fact that the grass was wet enough to darken our boots.",
      "That is the Serengeti page. The animals come into it later, once you have sat still.",
    ],
  },
  {
    slug: "after-the-rim",
    title: "After the rim",
    place: "Ngorongoro",
    date: "2026-03-09",
    tourSlug: "ngorongoro-tarangire",
    paragraphs: [
      "Tarangire had been all bark and dust and elephants shouldering through it. The crater the next day was a bowl of short green, and much quieter than its reputation.",
      "A black rhino stayed on the far side of a soda flat for the whole picnic. Nobody asked to drive closer. The note in the margin is just the distance, guessed, and then crossed out.",
      "Five days is enough if the days are not filled for you.",
    ],
  },
  {
    slug: "the-herd-waits",
    title: "The herd waits",
    place: "Mara River",
    date: "2026-08-24",
    tourSlug: "mara-classic",
    paragraphs: [
      "They came to the bank twice and turned around. The third time a calf slipped, the whole line followed, and the noise was hooves on stone rather than the splash people expect.",
      "We had been there since first light. The page is mostly times: 6:40, 8:15, 11:05. The crossing gets one sentence.",
      "Camp that evening faced the other way, onto empty conservancy grass. That felt like the right ending.",
    ],
  },
  {
    slug: "the-bull-and-the-track",
    title: "The bull and the track",
    place: "Amboseli",
    date: "2026-01-18",
    tourSlug: "amboseli-tsavo",
    paragraphs: [
      "Kilimanjaro was out, which is the photograph. The diary is about the bull who stood in the track and would not move, ears half open, for twenty minutes.",
      "The driver cut the engine and we watched oxpeckers work along his spine. When he stepped off, he did it as if the road had been his idea.",
      "Tsavo later in the week was redder and stranger. I still open the book at Amboseli.",
    ],
  },
];

export function entriesForTour(tourSlug: string) {
  return diaryEntries.filter((entry) => entry.tourSlug === tourSlug);
}
