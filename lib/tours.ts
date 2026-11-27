export type ItineraryDay = {
  day: number;
  title: string;
  body: string;
};

export type Departure = {
  id: string;
  startDate: string;
  endDate: string;
  capacity: number;
  pricePerPerson: number;
};

export type Tour = {
  slug: string;
  title: string;
  region: string;
  country: string;
  durationDays: number;
  summary: string;
  fieldNote: string;
  itinerary: ItineraryDay[];
  inclusions: string[];
  exclusions: string[];
  departures: Departure[];
};

export const tours: Tour[] = [
  {
    slug: "serengeti-migration",
    title: "Serengeti Migration",
    region: "Serengeti",
    country: "Tanzania",
    durationDays: 7,
    summary:
      "Seven days on the short-grass plains, following the herds from a mobile camp that moves with the season.",
    fieldNote:
      "The diary entry for this route is usually written at dawn, when the wildebeest are still just a dark line on the horizon.",
    itinerary: [
      {
        day: 1,
        title: "Arusha to the Ndutu plains",
        body: "Meet your guide, fly to the southern Serengeti, and reach camp while the light is still long.",
      },
      {
        day: 2,
        title: "Calving grounds",
        body: "A full day on the plains. The vehicle stays with one herd rather than chasing a checklist of species.",
      },
      {
        day: 3,
        title: "Woodland and water",
        body: "Morning among acacia, afternoon at a soda lake where flamingo and jackal share the shore.",
      },
      {
        day: 4,
        title: "Walk with the camp naturalist",
        body: "A slow foot safari near camp, then a long picnic under a shade tree you choose yourselves.",
      },
      {
        day: 5,
        title: "North with the grass",
        body: "The camp shifts toward the central Serengeti. Game drive on the way, no rushed transit lunch.",
      },
      {
        day: 6,
        title: "Kopjes at last light",
        body: "Lion country among the granite kopjes. Sundowners are poured where the rock holds the heat.",
      },
      {
        day: 7,
        title: "One more morning, then out",
        body: "A final drive at first light and a flight back to Arusha before noon.",
      },
    ],
    inclusions: [
      "Park fees and flying in and out of the Serengeti",
      "Mobile camp, all meals, and drinking water",
      "Private guide and four-wheel vehicle",
      "One guided walk",
    ],
    exclusions: [
      "International flights",
      "Travel insurance",
      "Visas and tips",
      "Drinks from the camp bar",
    ],
    departures: [
      {
        id: "serengeti-2027-02-14",
        startDate: "2027-02-14",
        endDate: "2027-02-20",
        capacity: 8,
        pricePerPerson: 4650,
      },
      {
        id: "serengeti-2027-06-20",
        startDate: "2027-06-20",
        endDate: "2027-06-26",
        capacity: 8,
        pricePerPerson: 4850,
      },
      {
        id: "serengeti-2027-08-08",
        startDate: "2027-08-08",
        endDate: "2027-08-14",
        capacity: 6,
        pricePerPerson: 5250,
      },
    ],
  },
  {
    slug: "ngorongoro-tarangire",
    title: "Ngorongoro & Tarangire",
    region: "Ngorongoro",
    country: "Tanzania",
    durationDays: 5,
    summary:
      "Five days between baobab country and the crater floor. A shorter route for a first safari that still feels unhurried.",
    fieldNote:
      "People write about the elephants in Tarangire and then, the next evening, about how quiet the crater is after the rim.",
    itinerary: [
      {
        day: 1,
        title: "Into Tarangire",
        body: "Drive from Arusha into the baobabs. Elephants are usually at the river by late afternoon.",
      },
      {
        day: 2,
        title: "A full day in the park",
        body: "Dawn drive, a long lunch back at camp, and a second loop only if you want it.",
      },
      {
        day: 3,
        title: "The crater rim",
        body: "Travel to a lodge on the Ngorongoro rim. The afternoon is for the view, not another road.",
      },
      {
        day: 4,
        title: "Down onto the floor",
        body: "A day inside the crater: black rhino country, soda lake, and a picnic the guides know by heart.",
      },
      {
        day: 5,
        title: "Back to Arusha",
        body: "A slow morning on the rim and a return to town after lunch.",
      },
    ],
    inclusions: [
      "Park and crater fees",
      "Lodge and camp stays, meals, and water",
      "Private guide and vehicle",
      "Crater picnic",
    ],
    exclusions: [
      "International flights",
      "Travel insurance",
      "Visas, tips, and laundry",
      "Optional Maasai village visit",
    ],
    departures: [
      {
        id: "ngorongoro-2027-03-07",
        startDate: "2027-03-07",
        endDate: "2027-03-11",
        capacity: 8,
        pricePerPerson: 3120,
      },
      {
        id: "ngorongoro-2027-07-11",
        startDate: "2027-07-11",
        endDate: "2027-07-15",
        capacity: 8,
        pricePerPerson: 3380,
      },
      {
        id: "ngorongoro-2027-09-19",
        startDate: "2027-09-19",
        endDate: "2027-09-23",
        capacity: 8,
        pricePerPerson: 3240,
      },
    ],
  },
  {
    slug: "mara-classic",
    title: "Masai Mara Classic",
    region: "Masai Mara",
    country: "Kenya",
    durationDays: 6,
    summary:
      "Six days in a private conservancy beside the reserve, with river time kept for the weeks the crossing is actually on.",
    fieldNote:
      "The page that gets filled in is rarely the crossing itself. It is the hour before, when the herd will not decide.",
    itinerary: [
      {
        day: 1,
        title: "Nairobi to the conservancy",
        body: "A short flight and a game drive from the airstrip to camp. Tents face the open grass.",
      },
      {
        day: 2,
        title: "Conservancy at walking pace",
        body: "Morning drive, optional walk with a guide, and the afternoon left open on purpose.",
      },
      {
        day: 3,
        title: "Into the reserve",
        body: "A day among the Mara River bends. We stay only as long as the wildlife asks.",
      },
      {
        day: 4,
        title: "Another river morning",
        body: "Return for cats, crossing herds, or nothing much. An empty morning is still a morning out.",
      },
      {
        day: 5,
        title: "Off the main tracks",
        body: "The conservancy again, with a sundowner on a rise the camp uses when the wind is kind.",
      },
      {
        day: 6,
        title: "Fly out after breakfast",
        body: "One last look from the vehicle on the way to the strip.",
      },
    ],
    inclusions: [
      "Conservancy and reserve fees",
      "Flights between Nairobi and the Mara",
      "Camp, meals, and house drinks with dinner",
      "Private guide and vehicle",
    ],
    exclusions: [
      "International flights into Nairobi",
      "Travel insurance and visas",
      "Tips",
      "Premium cellar wines",
    ],
    departures: [
      {
        id: "mara-2027-07-18",
        startDate: "2027-07-18",
        endDate: "2027-07-23",
        capacity: 8,
        pricePerPerson: 4380,
      },
      {
        id: "mara-2027-08-22",
        startDate: "2027-08-22",
        endDate: "2027-08-27",
        capacity: 6,
        pricePerPerson: 4680,
      },
      {
        id: "mara-2027-10-03",
        startDate: "2027-10-03",
        endDate: "2027-10-08",
        capacity: 8,
        pricePerPerson: 3980,
      },
    ],
  },
  {
    slug: "amboseli-tsavo",
    title: "Amboseli & Tsavo",
    region: "Amboseli",
    country: "Kenya",
    durationDays: 8,
    summary:
      "Eight days from Kilimanjaro's elephants to the red dust of Tsavo. A longer route, with two nights in each rhythm.",
    fieldNote:
      "The sketch everyone attempts is the mountain. The sentence everyone keeps is about a bull elephant blocking the track.",
    itinerary: [
      {
        day: 1,
        title: "To Amboseli",
        body: "Road transfer from Nairobi. If the mountain is clear, you see it before you see camp.",
      },
      {
        day: 2,
        title: "The swamp edge",
        body: "Elephants in the wetlands, with Kilimanjaro behind them when the cloud lifts.",
      },
      {
        day: 3,
        title: "A quiet Amboseli day",
        body: "Dawn drive, then time at camp. The observation deck is part of the itinerary.",
      },
      {
        day: 4,
        title: "Across to Tsavo West",
        body: "A travel day through open country, arriving in time for an evening drive.",
      },
      {
        day: 5,
        title: "Mzima and the red roads",
        body: "Springs, lava, and long sightlines. Picnic where the shade is.",
      },
      {
        day: 6,
        title: "Toward Tsavo East",
        body: "Shift camps. The east is drier, paler, and full of dust devils in the heat.",
      },
      {
        day: 7,
        title: "Aruba and the Yatta",
        body: "A full day along the water and the plateau. Night drive back if the gate allows.",
      },
      {
        day: 8,
        title: "Nairobi by afternoon",
        body: "Morning drive to the airstrip or road, and the city in time for an evening flight.",
      },
    ],
    inclusions: [
      "Park fees for Amboseli and both Tsavos",
      "Lodges, meals, and drinking water",
      "Private guide and vehicle throughout",
      "Road transfers from and to Nairobi",
    ],
    exclusions: [
      "International flights",
      "Travel insurance and visas",
      "Tips and laundry",
      "Hot-air balloon, if one is flying",
    ],
    departures: [
      {
        id: "amboseli-2027-01-16",
        startDate: "2027-01-16",
        endDate: "2027-01-23",
        capacity: 8,
        pricePerPerson: 4420,
      },
      {
        id: "amboseli-2027-05-09",
        startDate: "2027-05-09",
        endDate: "2027-05-16",
        capacity: 8,
        pricePerPerson: 4560,
      },
      {
        id: "amboseli-2027-09-05",
        startDate: "2027-09-05",
        endDate: "2027-09-12",
        capacity: 6,
        pricePerPerson: 4780,
      },
    ],
  },
];

export function getTour(slug: string) {
  return tours.find((tour) => tour.slug === slug);
}

export function priceFrom(tour: Tour) {
  return Math.min(...tour.departures.map((departure) => departure.pricePerPerson));
}

export function nextDeparture(tour: Tour) {
  return [...tour.departures].sort((a, b) => a.startDate.localeCompare(b.startDate))[0];
}
