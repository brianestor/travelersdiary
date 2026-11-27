@extends('layouts.site')

@section('content')
    @php $still = \App\Support\Media::still($tour->slug); @endphp
    <div class="mx-auto max-w-6xl px-5 py-12">
        <p class="text-sm text-mist">
            <a href="{{ route('safaris') }}" class="hover:text-gold">Popular safari</a>
            / {{ $tour->country }}
        </p>
        <x-split :item="$still">
            <p class="text-sm font-light tracking-[0.16em] text-pale">
                {{ $tour->region }} · {{ $tour->duration_days }} days · from {{ \App\Support\Format::money($tour->priceFrom()) }}
            </p>
            <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">{{ $tour->title }}</h1>
            <p class="mt-4 max-w-2xl text-lg font-light leading-8 tracking-wide text-mist">{{ $tour->summary }}</p>
        </x-split>

        <div class="mt-10 grid items-start gap-10 lg:grid-cols-[1.2fr_0.8fr]">
            <div>
                <h2 class="display text-2xl text-gold">The days</h2>
                <ol class="mt-5 space-y-5">
                    @foreach($tour->days as $day)
                        <li class="border-l border-gold pl-4">
                            <p class="text-sm tracking-[0.14em] text-gold">Day {{ $day->day }}</p>
                            <h3 class="display mt-1 text-xl text-pale">{{ $day->title }}</h3>
                            <p class="mt-1 font-light leading-7 tracking-wide text-mist">{{ $day->body }}</p>
                        </li>
                    @endforeach
                </ol>
                <div class="mt-10 grid gap-8 sm:grid-cols-2">
                    <div>
                        <h2 class="display text-xl text-gold">Included</h2>
                        <ul class="mt-3 list-disc space-y-2 pl-5 text-sm font-light leading-6 tracking-wide text-mist">
                            @foreach($tour->lines->where('kind', 'inclusion') as $line)
                                <li>{{ $line->body }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h2 class="display text-xl text-gold">Not included</h2>
                        <ul class="mt-3 list-disc space-y-2 pl-5 text-sm font-light leading-6 tracking-wide text-mist">
                            @foreach($tour->lines->where('kind', 'exclusion') as $line)
                                <li>{{ $line->body }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <p class="mt-8 max-w-xl text-lg font-light leading-8 tracking-wide text-pale">{{ $tour->field_note }}</p>
                @if($tour->diaryEntries->isNotEmpty())
                    <p class="mt-4 text-sm">
                        <a href="{{ route('diary') }}" class="text-gold hover:underline">Read the diary pages from this route</a>
                    </p>
                @endif
            </div>
            @include('partials.departure-picker', ['tour' => $tour, 'departures' => $tour->departures, 'panel' => 'night'])
        </div>
    </div>
@endsection
