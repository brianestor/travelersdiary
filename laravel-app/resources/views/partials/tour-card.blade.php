@php
    $opening = $tour->departures->sortBy('start_date')->first();
    $still = \App\Support\Media::still($tour->slug);
@endphp
<article class="split-card">
    <div class="split-card-visual">
        @include('partials.frame', ['item' => $still])
    </div>
    <div class="split-card-copy">
        <p class="text-xs font-light tracking-[0.16em] text-gold">{{ $tour->country }} · {{ trans_choice('{1} :count day|[2,*] :count days', $tour->duration_days, ['count' => $tour->duration_days]) }}</p>
        <h2 class="display mt-3 text-2xl text-pale">{{ $tour->title }}</h2>
        <p class="mt-3 font-light leading-7 tracking-wide text-mist">{{ $tour->summary }}</p>
        <p class="mt-4 text-sm text-pale">
            {{ __('From :price per person', ['price' => \App\Support\Format::money($tour->priceFrom())]) }}
            @if($opening) · {{ __('next departure') }} {{ \App\Support\Format::date($opening->start_date) }} @endif
        </p>
        <a href="{{ route('safari', $tour->slug) }}" class="mt-5 inline-flex w-fit rounded-full bg-gold px-4 py-2 text-sm text-night hover:bg-pale focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">{{ __('View the route') }}</a>
    </div>
</article>
