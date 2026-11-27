@extends('layouts.site')

@section('content')
    <div class="mx-auto max-w-3xl px-5 py-16">
        <p class="text-xs font-light tracking-[0.22em] text-pale">Requested, not yet confirmed</p>
        <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">Your place is held as a request</h1>
        <p class="mt-4 font-light leading-7 tracking-wide text-mist">The desk will write to {{ $booking->email }} to confirm. Nothing has been charged.</p>
        <p class="display mt-8 text-3xl text-gold">{{ $booking->reference }}</p>
        <dl class="mt-6 space-y-2 text-sm leading-6">
            <div>
                <dt class="text-mist">Safari</dt>
                <dd>{{ $booking->tour->title ?? $booking->tour_id }}</dd>
            </div>
            @if($booking->departure)
                <div>
                    <dt class="text-mist">Dates</dt>
                    <dd>{{ \App\Support\Format::date($booking->departure->start_date) }} – {{ \App\Support\Format::date($booking->departure->end_date) }}</dd>
                </div>
            @endif
            <div>
                <dt class="text-mist">Travelers</dt>
                <dd>
                    {{ $booking->lead_name }} · {{ $booking->adults }} {{ $booking->adults === 1 ? 'adult' : 'adults' }}
                    @if($booking->children > 0), {{ $booking->children }} {{ $booking->children === 1 ? 'child' : 'children' }}@endif
                </dd>
            </div>
            <div>
                <dt class="text-mist">Status</dt>
                <dd class="capitalize">{{ $booking->status }}</dd>
            </div>
        </dl>
        <a href="{{ route('safaris') }}" class="mt-8 inline-flex text-sm text-gold hover:underline">Back to popular safari</a>
    </div>
@endsection
