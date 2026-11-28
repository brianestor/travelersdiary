@extends('layouts.site')

@section('content')
    <div class="mx-auto max-w-6xl px-5 py-12">
        <p class="text-xs font-light tracking-[0.22em] text-pale">{{ __('The routes') }}</p>
        <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">{{ __('Popular safari') }}</h1>
        <p class="mt-4 max-w-2xl font-light leading-7 tracking-wide text-mist">
            {{ __('Two journeys in Tanzania, each with its own departures. Open a route, choose a date, and send the desk a reservation request.') }}
        </p>
        <div class="mt-8 grid gap-5 md:grid-cols-2">
            @foreach($tours as $tour)
                @include('partials.tour-card', ['tour' => $tour])
            @endforeach
        </div>
    </div>
@endsection
