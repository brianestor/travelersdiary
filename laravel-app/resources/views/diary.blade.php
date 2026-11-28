@extends('layouts.site')

@section('content')
    @php
        $stills = [
            \App\Support\Media::all()['elephant'],
            \App\Support\Media::all()['rhino'],
            \App\Support\Media::all()['lion'],
            \App\Support\Media::all()['lunch'],
        ];
    @endphp
    <div>
        <div class="mx-auto max-w-6xl px-5 py-10">
            <p class="text-xs font-light tracking-[0.22em] text-pale">{{ __('Written by nature') }}</p>
            <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">{{ __('The diary') }}</h1>
            <p class="mt-4 max-w-2xl font-light leading-7 tracking-wide text-mist">{{ __('Pages from the road. Each one belongs to a safari you can still join.') }}</p>
        </div>
        @foreach($entries as $entry)
            <x-split :item="$stills[$loop->index % count($stills)]">
                <p class="text-sm font-light tracking-wide text-mist">{{ $entry->place }} · {{ \App\Support\Format::date($entry->entry_date) }}</p>
                <h2 class="display mt-3 text-3xl text-gold">{{ $entry->title }}</h2>
                <div class="mt-4 max-w-xl space-y-4 font-light leading-8 tracking-wide">
                    @foreach($entry->paragraphs as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
                @if($entry->tour)
                    <a href="{{ route('safari', $entry->tour->slug) }}" class="mt-5 inline-flex text-sm text-gold hover:underline">{{ __('The route: :title', ['title' => $entry->tour->title]) }}</a>
                @endif
            </x-split>
        @endforeach
    </div>
@endsection
