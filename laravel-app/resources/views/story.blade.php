@extends('layouts.site')

@section('content')
    @php
        $circuits = [
            [
                'icon' => 'mountain',
                'title' => __('Kilimanjaro'),
                'image' => 'kilimanjaro.png',
                'names' => ['Arusha', 'Kilimanjaro'],
            ],
            [
                'icon' => 'north',
                'title' => __('Northern circuit'),
                'image' => 'northern.png',
                'names' => ['Arusha', 'Tarangire', 'Manyara', 'Ngorongoro', 'Serengeti'],
            ],
            [
                'icon' => 'south',
                'title' => __('Southern circuit'),
                'image' => 'southern.png',
                'names' => ['Mikumi', 'Ruaha', 'Nyerere'],
            ],
            [
                'icon' => 'center',
                'title' => __('Middle circuit'),
                'image' => 'middle.png',
                'names' => ['Babati', 'Kondoa', 'Dodoma'],
            ],
        ];
        $stats = [
            ['icon' => 'travelers', 'label' => __('Travelers served')],
            ['icon' => 'safari', 'label' => __('Safaris run')],
            ['icon' => 'nights', 'label' => __('Nights on the road')],
        ];
    @endphp
    <div class="mx-auto max-w-3xl px-5 py-12">
        <p class="text-xs font-light tracking-[0.22em] text-pale">{{ __('Written by nature, lived by you') }}</p>
        <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">{{ __('Our story') }}</h1>
        <p class="mt-5 max-w-2xl font-light leading-8 tracking-wide text-mist">
            {{ __('Travelers Diary is based only in Tanzania. Safaris run only here, including Zanzibar, from Kilimanjaro to the northern, southern, and middle circuits. Each reservation is confirmed by the desk. Nothing on this site is charged.') }}
        </p>

        <div class="mt-12 grid gap-8 sm:grid-cols-2">
            @foreach ($circuits as $circuit)
                <section>
                    <h2 class="display flex items-center gap-2 text-xl text-gold">
                        <span class="text-pale">@include('partials.icons.'.$circuit['icon'])</span>
                        {{ $circuit['title'] }}
                    </h2>
                    <div class="mt-4 text-pale">
                        @include('partials.circuit-map', ['title' => $circuit['title'], 'image' => $circuit['image'], 'names' => $circuit['names']])
                    </div>
                </section>
            @endforeach
        </div>

        <section class="mt-14">
            <h2 class="display text-2xl text-gold">{{ __('Performance') }}</h2>
            <ul class="mt-5 grid gap-4 sm:grid-cols-3">
                @foreach ($stats as $stat)
                    <li class="rounded-3xl border border-line px-4 py-5">
                        <span class="text-gold">@include('partials.icons.'.$stat['icon'])</span>
                        <p class="mt-3 text-3xl text-pale">—</p>
                        <p class="mt-1 text-sm font-light tracking-wide text-mist">{{ $stat['label'] }}</p>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="mt-14">
            <h2 class="display flex items-center gap-2 text-2xl text-gold">
                <span class="text-pale">@include('partials.icons.medal')</span>
                {{ __('Awards') }}
            </h2>
            <p class="mt-4 font-light leading-7 tracking-wide text-mist">{{ __('Awards and citations will be listed here when Travelers Diary chooses to publish them.') }}</p>
        </section>

        <section class="mt-14">
            <h2 class="display flex items-center gap-2 text-2xl text-gold">
                <span class="text-pale">@include('partials.icons.partners')</span>
                {{ __('Partnerships') }}
            </h2>
            <p class="mt-4 font-light leading-7 tracking-wide text-mist">{{ __('Camps, guides, and conservation partners will be named here when those relationships are ready to be shown.') }}</p>
        </section>
    </div>
@endsection
