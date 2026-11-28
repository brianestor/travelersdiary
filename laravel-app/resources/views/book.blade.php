@extends('layouts.site')

@section('content')
    @if(!$ready)
        <div class="mx-auto max-w-3xl px-5 py-16">
            <h1 class="display text-3xl text-gold">{{ __('Choose a departure first') }}</h1>
            <p class="mt-4 font-light leading-7 tracking-wide text-mist">{{ __('A reservation starts on Plan a safari, where you can see the dates and the seats left.') }}</p>
            <a href="{{ route('plan') }}" class="mt-6 inline-flex text-gold hover:underline">{{ __('Plan a safari') }}</a>
        </div>
    @else
        @php
            $party = $adults + $children;
            $left = $departure->seatsLeft();
            $total = $party * $departure->price_per_person;
        @endphp
        <div class="mx-auto grid max-w-6xl gap-10 px-5 py-12 lg:grid-cols-2">
            <div>
                <p class="text-xs font-light tracking-[0.22em] text-pale">{{ __('Reservation request') }}</p>
                <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">{{ $tour->title }}</h1>
                <dl class="mt-6 space-y-3 text-sm leading-6">
                    <div>
                        <dt class="text-mist">{{ __('Dates') }}</dt>
                        <dd>{{ \App\Support\Format::date($departure->start_date) }} – {{ \App\Support\Format::date($departure->end_date) }}</dd>
                    </div>
                    <div>
                        <dt class="text-mist">{{ __('Party') }}</dt>
                        <dd>
                            {{ trans_choice('{1} :count adult|[2,*] :count adults', $adults, ['count' => $adults]) }}
                            @if($children > 0), {{ trans_choice('{1} :count child|[2,*] :count children', $children, ['count' => $children]) }}@endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-mist">{{ __('Seats still open') }}</dt>
                        <dd>{{ $left }}</dd>
                    </div>
                    <div>
                        <dt class="text-mist">{{ __('Estimate') }}</dt>
                        <dd>{{ \App\Support\Format::money($total) }} · {{ __(':price per person, children included at the same rate', ['price' => \App\Support\Format::money($departure->price_per_person)]) }}</dd>
                    </div>
                </dl>
                @if($party > $left)
                    <p class="mt-6 text-sm text-gold">{{ __('Those seats were taken. Go back and choose another departure.') }}</p>
                @else
                    <p class="mt-6 text-sm font-light leading-6 tracking-wide text-mist">{{ __('The estimate is for the desk to confirm. This page does not take a payment.') }}</p>
                @endif
                <a href="{{ route('safari', $tour->slug) }}" class="mt-4 inline-flex text-sm text-gold hover:underline">{{ __('Change the departure') }}</a>
            </div>
            <div class="rounded-3xl border border-line p-6">
                @if($party <= $left)
                    <form method="post" action="{{ route('book.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="tour" value="{{ $tour->slug }}">
                        <input type="hidden" name="departure" value="{{ $departure->id }}">
                        <input type="hidden" name="adults" value="{{ $adults }}">
                        <input type="hidden" name="children" value="{{ $children }}">
                        <label class="block text-sm">
                            {{ __('Lead traveler') }}
                            <input name="leadName" required autocomplete="name" value="{{ old('leadName') }}" class="field">
                        </label>
                        <label class="block text-sm">
                            {{ __('Email') }}
                            <input name="email" type="email" required autocomplete="email" value="{{ old('email') }}" class="field">
                        </label>
                        <label class="block text-sm">
                            {{ __('Phone') }}
                            <input name="phone" type="tel" required autocomplete="tel" value="{{ old('phone') }}" class="field">
                        </label>
                        <label class="block text-sm">
                            {{ __('Notes for the desk') }}
                            <textarea name="notes" rows="4" class="field" placeholder="{{ __('Room arrangements, celebrations, mobility.') }}">{{ old('notes') }}</textarea>
                        </label>
                        @if(session('form_error'))
                            <p class="rounded-2xl border border-gold px-3 py-2 text-sm text-gold" role="alert">{{ session('form_error') }}</p>
                        @endif
                        <button type="submit" class="rounded-full bg-gold px-5 py-2.5 text-night hover:bg-pale">{{ __('Request this reservation') }}</button>
                        <p class="text-sm font-light leading-6 tracking-wide text-mist">{{ __('This saves a request. The desk confirms it with you. Nothing is charged on this site.') }}</p>
                    </form>
                @endif
            </div>
        </div>
    @endif
@endsection
