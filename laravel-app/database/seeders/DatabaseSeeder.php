<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Departure;
use App\Models\DiaryEntry;
use App\Models\ItineraryDay;
use App\Models\Tour;
use App\Models\TourLine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = json_decode(file_get_contents(database_path('seeders/catalog.json')), true);

        foreach ($catalog['tours'] as $row) {
            $tour = Tour::create([
                'slug' => $row['slug'],
                'title' => $row['title'],
                'region' => $row['region'],
                'country' => $row['country'],
                'duration_days' => $row['durationDays'],
                'summary' => $row['summary'],
                'field_note' => $row['fieldNote'],
            ]);

            foreach ($row['itinerary'] as $day) {
                ItineraryDay::create([
                    'tour_id' => $tour->id,
                    'day' => $day['day'],
                    'title' => $day['title'],
                    'body' => $day['body'],
                ]);
            }

            $sort = 0;
            foreach (['inclusion' => 'inclusions', 'exclusion' => 'exclusions'] as $kind => $key) {
                foreach ($row[$key] as $line) {
                    TourLine::create([
                        'tour_id' => $tour->id,
                        'kind' => $kind,
                        'sort' => $sort++,
                        'body' => $line,
                    ]);
                }
            }

            foreach ($row['departures'] as $departure) {
                Departure::create([
                    'id' => $departure['id'],
                    'tour_id' => $tour->id,
                    'start_date' => $departure['startDate'],
                    'end_date' => $departure['endDate'],
                    'capacity' => $departure['capacity'],
                    'seats_taken' => $departure['id'] === 'serengeti-2027-02-14' ? 2 : 0,
                    'price_per_person' => $departure['pricePerPerson'],
                ]);
            }
        }

        foreach ($catalog['diary'] as $entry) {
            $tour = Tour::where('slug', $entry['tourSlug'])->firstOrFail();
            DiaryEntry::create([
                'slug' => $entry['slug'],
                'title' => $entry['title'],
                'place' => $entry['place'],
                'entry_date' => $entry['date'],
                'tour_id' => $tour->id,
                'paragraphs' => $entry['paragraphs'],
            ]);
        }

        $tour = Tour::where('slug', 'serengeti-migration')->firstOrFail();
        Booking::create([
            'reference' => 'TD-5CE8CBB1',
            'tour_id' => $tour->id,
            'departure_id' => 'serengeti-2027-02-14',
            'adults' => 2,
            'children' => 0,
            'lead_name' => 'Amina Hassan',
            'email' => 'amina@example.com',
            'phone' => '+255700000001',
            'notes' => '',
            'status' => 'requested',
            'created_at' => '2026-11-27 11:36:41',
            'updated_at' => '2026-11-27 11:36:41',
        ]);
    }
}
