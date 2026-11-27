@extends('layouts.site')

@section('content')
    <div class="mx-auto max-w-6xl px-5 py-12">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-light tracking-[0.22em] text-pale">Staff</p>
                <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">Reservations</h1>
            </div>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="text-sm text-mist hover:text-gold">Lock the desk</button>
            </form>
        </div>
        <p class="mt-3 max-w-2xl text-sm font-light leading-6 tracking-wide text-mist">Every row is a request. Confirming still happens by writing to the traveler. This list does not take payment.</p>

        <div class="mt-8 space-y-4">
            @if($bookings->isEmpty())
                <p class="rounded-3xl border border-dashed border-line px-5 py-8 text-sm text-mist">No reservations yet.</p>
            @else
                @foreach($bookings as $booking)
                    <article class="rounded-3xl border border-line p-5">
                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                            <h2 class="display text-xl text-gold">{{ $booking->reference }}</h2>
                            <p class="text-sm capitalize text-pale">{{ $booking->status }}</p>
                        </div>
                        <p class="mt-1 text-sm text-mist">{{ \App\Support\Format::when($booking->created_at) }}</p>
                        <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                            <div>
                                <dt class="text-mist">Safari</dt>
                                <dd>{{ $booking->tour->title ?? 'Safari' }}</dd>
                            </div>
                            <div>
                                <dt class="text-mist">Dates</dt>
                                <dd>
                                    @if($booking->departure)
                                        {{ \App\Support\Format::date($booking->departure->start_date) }} – {{ \App\Support\Format::date($booking->departure->end_date) }}
                                    @else
                                        {{ $booking->departure_id }}
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-mist">Party</dt>
                                <dd>
                                    {{ $booking->lead_name }} · {{ $booking->adults }} {{ $booking->adults === 1 ? 'adult' : 'adults' }}
                                    @if($booking->children > 0), {{ $booking->children }} {{ $booking->children === 1 ? 'child' : 'children' }}@endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-mist">Contact</dt>
                                <dd>{{ $booking->email }}<br>{{ $booking->phone }}</dd>
                            </div>
                        </dl>
                        @if($booking->notes)
                            <p class="mt-3 text-sm leading-6">{{ $booking->notes }}</p>
                        @endif
                    </article>
                @endforeach
            @endif
        </div>

        <h2 class="display mt-12 text-2xl text-gold">Seats</h2>
        <ul class="mt-4 divide-y divide-line rounded-3xl border border-line">
            @foreach($departures as $departure)
                <li class="flex flex-wrap items-center justify-between gap-2 px-5 py-3 text-sm">
                    <span>
                        {{ $departure->tour->title ?? 'Safari' }}
                        <span class="text-mist"> · {{ \App\Support\Format::date($departure->start_date) }}</span>
                    </span>
                    <span>{{ $departure->seatsLeft() }} of {{ $departure->capacity }} left · {{ \App\Support\Format::money($departure->price_per_person) }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
