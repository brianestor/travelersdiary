@extends('layouts.site')

@section('content')
    <div class="mx-auto max-w-6xl px-5 py-12">
        <p class="text-xs font-light tracking-[0.22em] text-pale">The routes</p>
        <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">Popular safari</h1>
        <p class="mt-4 max-w-2xl font-light leading-7 tracking-wide text-mist">
            Four journeys, each with its own departures. Open a route, choose a date, and send the desk a reservation request.
        </p>
        @foreach(['Tanzania', 'Kenya'] as $country)
            <section class="mt-12">
                <h2 class="display text-2xl text-gold">{{ $country }}</h2>
                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    @foreach($tours->where('country', $country) as $tour)
                        @include('partials.tour-card', ['tour' => $tour])
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
@endsection
