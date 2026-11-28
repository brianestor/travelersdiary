<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Departure;
use App\Models\Message;
use App\Models\PlanRequest;
use App\Models\Tour;
use DateTime;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ReservationException extends RuntimeException
{
}

class Reservations
{
    public function book(array $input): Booking
    {
        return DB::transaction(function () use ($input) {
            $tour = Tour::where('slug', $this->text($input['tour'] ?? $input['tourSlug'] ?? null, 80))->first();
            if (! $tour) {
                throw new ReservationException('Choose a safari from the list.');
            }

            $adults = $this->int($input['adults'] ?? null);
            $children = $this->int($input['children'] ?? null);
            $partyError = $this->partyError($adults, $children);
            if ($partyError) {
                throw new ReservationException($partyError);
            }

            $leadName = $this->text($input['leadName'] ?? null, 80);
            $email = $this->text($input['email'] ?? null, 120);
            $phone = $this->text($input['phone'] ?? null, 30);
            $notes = $this->text($input['notes'] ?? null, 800);

            if (strlen($leadName) < 2) {
                throw new ReservationException('Add the name of the lead traveler.');
            }
            if (! preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
                throw new ReservationException('Add an email the desk can reply to.');
            }
            $digits = preg_replace('/\D/', '', $phone);
            if (strlen($digits) < 7 || strlen($digits) > 15) {
                throw new ReservationException('Add a phone number with at least seven digits.');
            }

            $departure = Departure::where('id', $this->text($input['departure'] ?? $input['departureId'] ?? null, 80))
                ->where('tour_id', $tour->id)
                ->lockForUpdate()
                ->first();
            if (! $departure) {
                throw new ReservationException('That departure is no longer listed.');
            }

            $size = $adults + $children;
            if ($size > $departure->seatsLeft()) {
                throw new ReservationException('This departure does not have enough seats left for that party.');
            }

            $departure->seats_taken += $size;
            $departure->save();

            return Booking::create([
                'reference' => 'TD-'.strtoupper(bin2hex(random_bytes(4))),
                'tour_id' => $tour->id,
                'departure_id' => $departure->id,
                'adults' => $adults,
                'children' => $children,
                'lead_name' => $leadName,
                'email' => $email,
                'phone' => $phone,
                'notes' => $notes,
                'status' => 'requested',
            ]);
        });
    }

    public function plan(array $input): PlanRequest
    {
        $start = $this->text($input['start_date'] ?? null, 10);
        $date = DateTime::createFromFormat('Y-m-d', $start);
        $today = new DateTime('today');
        if (! $date || $date->format('Y-m-d') !== $start || $date < $today) {
            throw new ReservationException('Choose a start day that has not already passed.');
        }

        $days = $this->int($input['duration_days'] ?? null);
        if ($days < 1 || $days > 21) {
            throw new ReservationException('Choose a trip from 1 to 21 days.');
        }

        $safari = $this->text($input['safari_type'] ?? null, 40);
        if (! in_array($safari, ['safari', 'kilimanjaro', 'zanzibar'], true)) {
            throw new ReservationException('Choose a normal safari, Mount Kilimanjaro, or Zanzibar.');
        }

        $adults = $this->int($input['adults'] ?? null);
        $children = $this->int($input['children'] ?? null);
        if ($adults < 1 || $adults > 12) {
            throw new ReservationException('Include at least one adult, and no more than twelve.');
        }
        if ($children < 0 || $children > 8) {
            throw new ReservationException('Children must be between zero and eight.');
        }

        $ages = $input['child_ages'] ?? [];
        if (! is_array($ages)) {
            $ages = [];
        }
        $ages = array_values($ages);
        if (count($ages) !== $children) {
            throw new ReservationException('Add an age for each child.');
        }
        $cleanAges = [];
        foreach ($ages as $age) {
            $number = $this->int($age);
            if ($number < 0 || $number > 17) {
                throw new ReservationException('Each child\'s age must be between 0 and 17.');
            }
            $cleanAges[] = $number;
        }

        $budget = $this->int($input['budget'] ?? null);
        if ($budget < 150 || $budget > 5000) {
            throw new ReservationException('Set a budget between $150 and $5,000 per person.');
        }

        $stay = $this->text($input['accommodation'] ?? null, 40);
        if (! in_array($stay, ['explorer', 'signature', 'premium'], true)) {
            throw new ReservationException('Choose Explorer, Signature, or Premium.');
        }

        $first = $this->text($input['first_name'] ?? null, 80);
        $last = $this->text($input['last_name'] ?? null, 80);
        $email = $this->text($input['email'] ?? null, 120);
        $code = $this->text($input['country_code'] ?? null, 8);
        $phone = $this->text($input['phone'] ?? null, 30);
        if (strlen($first) < 2) {
            throw new ReservationException('Add a first name.');
        }
        if (strlen($last) < 2) {
            throw new ReservationException('Add a last name.');
        }
        if (! preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
            throw new ReservationException('Add an email the desk can reply to.');
        }
        if (! in_array($code, ['+255', '+254', '+256', '+1', '+44'], true)) {
            throw new ReservationException('Choose a country code.');
        }
        $digits = preg_replace('/\D/', '', $phone);
        if (strlen($digits) < 7 || strlen($digits) > 15) {
            throw new ReservationException('Add a phone number with at least seven digits.');
        }

        $method = $this->text($input['contact_method'] ?? null, 20);
        if (! in_array($method, ['email', 'whatsapp'], true)) {
            throw new ReservationException('Choose email or WhatsApp.');
        }

        return PlanRequest::create([
            'reference' => 'TD-'.strtoupper(bin2hex(random_bytes(4))),
            'start_date' => $start,
            'duration_days' => $days,
            'safari_type' => $safari,
            'adults' => $adults,
            'children' => $children,
            'child_ages' => $cleanAges,
            'budget' => $budget,
            'accommodation' => $stay,
            'first_name' => $first,
            'last_name' => $last,
            'email' => $email,
            'country_code' => $code,
            'phone' => $phone,
            'contact_method' => $method,
            'status' => 'requested',
        ]);
    }

    public function message(array $input): Message
    {
        $name = $this->text($input['name'] ?? null, 80);
        $email = $this->text($input['email'] ?? null, 120);
        $message = $this->text($input['message'] ?? null, 2000);

        if (strlen($name) < 2) {
            throw new ReservationException('Add your name.');
        }
        if (! preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
            throw new ReservationException('Add an email the desk can reply to.');
        }
        if (strlen($message) < 8) {
            throw new ReservationException('Write a short note so the desk knows how to help.');
        }

        return Message::create([
            'name' => $name,
            'email' => $email,
            'message' => $message,
        ]);
    }

    private function partyError(int $adults, int $children): ?string
    {
        if ($adults < 1 || $adults > 8) {
            return 'Include at least one adult, and no more than eight.';
        }
        if ($children < 0 || $children > 6) {
            return 'Children must be between zero and six.';
        }
        if ($adults + $children > 8) {
            return 'A single reservation can hold up to eight travelers.';
        }

        return null;
    }

    private function int(mixed $value): int
    {
        if (is_int($value)) {
            return $value;
        }
        if (is_string($value) && preg_match('/^-?\d+$/', $value)) {
            return (int) $value;
        }
        if (is_float($value) && (int) $value == $value) {
            return (int) $value;
        }

        return PHP_INT_MIN;
    }

    private function text(mixed $value, int $max): string
    {
        if (! is_string($value)) {
            return '';
        }

        return mb_substr(trim($value), 0, $max);
    }
}
