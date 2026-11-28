@extends('layouts.site')

@section('content')
    @php $media = \App\Support\Media::all(); @endphp
    <div>
        <x-split :item="$media['plains']" hero>
            <p class="text-sm font-light tracking-[0.22em] text-pale">{{ __('Written by nature, lived by you') }}</p>
            <h1 class="display mt-4 text-4xl text-gold sm:text-5xl">Travelers Diary</h1>
            <p class="mt-5 max-w-xl text-lg font-light leading-8 tracking-wide text-mist">
                {{ __('Experience life-changing safaris in Tanzania wildlife, starting from the wild variety of creatures from the highland to the rivers. You live the days and keep the page.') }}
            </p>
            <a href="{{ route('story') }}" class="mt-6 inline-flex w-fit rounded-full bg-gold px-5 py-2.5 text-sm text-night hover:bg-pale focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">{{ __('Our story') }}</a>
        </x-split>

        <div class="home-grid">
            <a href="{{ route('safaris') }}" class="block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">
                <x-split :item="$media['elephant']">
                    <h2 class="display text-2xl text-gold">{{ __('Popular safari') }}</h2>
                    <p class="mt-2 max-w-md text-sm font-light leading-6 tracking-wide text-mist">{{ __('The routes travelers ask for first.') }}</p>
                </x-split>
            </a>
            <a href="{{ route('diary') }}" class="block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">
                <x-split :item="$media['lion']">
                    <h2 class="display text-2xl text-gold">{{ __('Diary') }}</h2>
                    <p class="mt-2 max-w-md text-sm font-light leading-6 tracking-wide text-mist">{{ __('Pages from the road, each tied to a safari.') }}</p>
                </x-split>
            </a>
            <a href="{{ route('plan') }}" class="block focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">
                <x-split :item="$media['lunch']">
                    <h2 class="display text-2xl text-gold">{{ __('Plan a safari') }}</h2>
                    <p class="mt-2 max-w-md text-sm font-light leading-6 tracking-wide text-mist">{{ __('Choose a departure and request the seats.') }}</p>
                </x-split>
            </a>
            <x-split :item="$media['cheetah']">
                <p class="text-xs font-light tracking-[0.22em] text-pale">{{ __('From the grass') }}</p>
                <h2 class="display mt-3 text-3xl text-gold">{{ __('A mother and her cubs') }}</h2>
                <p class="mt-4 max-w-md font-light leading-7 tracking-wide text-mist">
                    {{ __('The Serengeti page is often this quiet: the family in the grass, and the vehicle left where it stopped.') }}
                </p>
                <a href="{{ route('safari', 'serengeti-migration') }}" class="mt-5 inline-flex text-sm text-gold hover:underline">{{ __('The Serengeti route') }}</a>
            </x-split>
        </div>
    </div>
@endsection
