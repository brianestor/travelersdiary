<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Departure;
use App\Models\Message;
use App\Models\Tour;
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
