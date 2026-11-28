<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Departure;
use App\Models\DiaryEntry;
use App\Models\PlanRequest;
use App\Models\Tour;
use App\Services\ReservationException;
use App\Services\Reservations;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        return view('home', [
            'description' => 'Safari journeys written by nature and lived by you. Choose a departure, send your details, and the desk confirms the reservation.',
        ]);
    }

    public function safaris()
    {
        $tours = Tour::with(['departures', 'days'])->orderBy('id')->get();

        return view('safaris.index', [
            'title' => 'Popular safari',
            'description' => 'Fixed-date safaris in Tanzania and Kenya, with seats held when you request a reservation.',
            'tours' => $tours,
        ]);
    }

    public function safari(string $slug)
    {
        $tour = Tour::with(['days', 'lines', 'departures', 'diaryEntries'])->where('slug', $slug)->firstOrFail();

        return view('safaris.show', [
            'title' => $tour->title,
            'description' => $tour->summary,
            'tour' => $tour,
        ]);
    }

    public function diary()
    {
        $entries = DiaryEntry::with('tour')->orderBy('id')->get();

        return view('diary', [
            'title' => 'Diary',
            'description' => 'Field notes from Travelers Diary safaris, each one tied to a route you can reserve.',
            'entries' => $entries,
        ]);
    }

    public function plan()
    {
        return view('plan', [
            'title' => 'Plan a safari',
            'description' => 'Plan a safari one step at a time. The desk confirms the request. Nothing is charged.',
        ]);
    }

    public function storePlan(Request $request, Reservations $reservations)
    {
        try {
            $plan = $reservations->plan($request->all());
        } catch (ReservationException $error) {
            return back()->withInput()->with('form_error', $error->getMessage());
        }

        return redirect()->route('plan.confirmation', $plan->reference);
    }

    public function planConfirmation(string $ref)
    {
        $plan = PlanRequest::where('reference', $ref)->firstOrFail();

        return view('plan-confirmation', [
            'title' => 'Safari plan requested',
            'plan' => $plan,
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Contacts',
            'description' => 'Write to the Travelers Diary desk. Questions live here; reservations start on Plan a safari.',
        ]);
    }

    public function storeMessage(Request $request, Reservations $reservations)
    {
        try {
            $reservations->message($request->only(['name', 'email', 'message']));
        } catch (ReservationException $error) {
            return back()->withInput()->with('form_error', $error->getMessage());
        }

        return back()->with('sent', true);
    }

    public function book(Request $request)
    {
        $tour = Tour::where('slug', (string) $request->query('tour'))->first();
        $departure = $tour
            ? Departure::where('id', (string) $request->query('departure'))->where('tour_id', $tour->id)->first()
            : null;
        $adults = $request->query('adults');
        $children = $request->query('children');
        $adultsOk = is_string($adults) && preg_match('/^\d+$/', $adults);
        $childrenOk = is_string($children) && preg_match('/^\d+$/', $children);
        $adults = $adultsOk ? (int) $adults : -1;
        $children = $childrenOk ? (int) $children : -1;
        $partyReady = $adults >= 1 && $children >= 0 && $adults + $children <= 8 && $adults <= 8 && $children <= 6;

        return view('book', [
            'title' => 'Request a reservation',
            'tour' => $tour,
            'departure' => $departure,
            'adults' => $adults,
            'children' => $children,
            'ready' => $tour && $departure && $partyReady,
        ]);
    }

    public function storeBooking(Request $request, Reservations $reservations)
    {
        try {
            $booking = $reservations->book($request->only([
                'tour', 'departure', 'adults', 'children', 'leadName', 'email', 'phone', 'notes',
            ]));
        } catch (ReservationException $error) {
            return back()->withInput()->with('form_error', $error->getMessage());
        }

        return redirect()->route('confirmation', $booking->reference);
    }

    public function confirmation(string $ref)
    {
        $booking = Booking::with(['tour', 'departure'])->where('reference', $ref)->firstOrFail();

        return view('confirmation', [
            'title' => 'Reservation requested',
            'booking' => $booking,
        ]);
    }

    public function admin(Request $request)
    {
        if (! $request->session()->get('staff')) {
            return view('admin.login', [
                'title' => 'Desk',
                'robots' => 'noindex, nofollow',
                'configured' => $this->password() !== '',
            ]);
        }

        $bookings = Booking::with(['tour', 'departure'])->latest()->get();
        $plans = PlanRequest::latest()->get();
        $departures = Departure::with('tour')->orderBy('start_date')->get();

        return view('admin.desk', [
            'title' => 'Desk',
            'robots' => 'noindex, nofollow',
            'bookings' => $bookings,
            'plans' => $plans,
            'departures' => $departures,
        ]);
    }

    public function login(Request $request)
    {
        $password = $this->password();
        if ($password === '') {
            return redirect()->route('admin', ['error' => 'config']);
        }
        $given = (string) $request->input('password');
        if (! hash_equals($password, $given)) {
            return redirect()->route('admin', ['error' => 'password']);
        }
        $request->session()->regenerate();
        $request->session()->put('staff', true);

        return redirect()->route('admin');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('staff');
        $request->session()->regenerate();

        return redirect()->route('admin');
    }

    private function password(): string
    {
        return (string) config('desk.password');
    }
}
