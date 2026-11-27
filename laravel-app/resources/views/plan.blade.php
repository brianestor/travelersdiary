@extends('layouts.site')

@section('content')
    <x-split :item="\App\Support\Media::all()['lunch']" tone="khaki">
        <p class="text-xs font-light tracking-[0.22em]">A reservation request</p>
        <h1 class="display mt-3 text-4xl sm:text-5xl">Plan a safari</h1>
        <p class="mt-4 max-w-2xl font-light leading-7 tracking-wide">
            Choose the route, the departure, and who is traveling. You will leave a name and contact on the next page. Nothing is charged.
        </p>
        <div class="mt-8 grid items-start gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <form method="get" action="{{ route('plan') }}">
                <fieldset class="space-y-3">
                    <legend class="display text-sm text-ink">Choose a safari</legend>
                    @foreach($tours as $tour)
                        <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-ink/20 bg-khaki px-3 py-3 has-[:checked]:border-ink">
                            <input type="radio" name="safari" value="{{ $tour->slug }}" class="mt-1" onchange="this.form.submit()" @checked($selected && $selected->slug === $tour->slug)>
                            <span>
                                <span class="display block text-sm text-ink">{{ $tour->title }}</span>
                                <span class="mt-1 block text-sm text-ink/70">{{ $tour->region }} · {{ $tour->country }}</span>
                            </span>
                        </label>
                    @endforeach
                </fieldset>
            </form>
            @if($selected)
                @include('partials.departure-picker', ['tour' => $selected, 'departures' => $selected->departures])
            @else
                <p class="text-sm text-ink">No safaris are open to plan yet.</p>
            @endif
        </div>
    </x-split>
@endsection
