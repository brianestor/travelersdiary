@php
    $opening = $tour->departures->sortBy('start_date')->first();
    $still = \App\Support\Media::still($tour->slug);
@endphp
<article class="split-card">
    <div class="split-card-visual">
        @include('partials.frame', ['item' => $still])
    </div>
    <div class="split-card-copy">
        <p class="text-xs font-light tracking-[0.16em] text-gold">{{ $tour->country }} · {{ $tour->duration_days }} days</p>
        <h2 class="display mt-3 text-2xl text-pale">{{ $tour->title }}</h2>
        <p class="mt-3 font-light leading-7 tracking-wide text-mist">{{ $tour->summary }}</p>
        <p class="mt-4 text-sm text-pale">
            From {{ \App\Support\Format::money($tour->priceFrom()) }} per person
            @if($opening) · next departure {{ \App\Support\Format::date($opening->start_date) }} @endif
        </p>
        <a href="{{ route('safari', $tour->slug) }}" class="mt-5 inline-flex w-fit rounded-full bg-gold px-4 py-2 text-sm text-night hover:bg-pale focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">View the route</a>
    </div>
</article>
