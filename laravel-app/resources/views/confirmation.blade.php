@extends('layouts.site')

@section('content')
    <div class="mx-auto max-w-3xl px-5 py-16">
        <p class="text-xs font-light tracking-[0.22em] text-pale">{{ __('Requested, not yet confirmed') }}</p>
        <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">{{ __('Your place is held as a request') }}</h1>
        <p class="mt-4 font-light leading-7 tracking-wide text-mist">{{ __('The desk will write to :email to confirm. Nothing has been charged.', ['email' => $booking->email]) }}</p>
        <p class="display mt-8 text-3xl text-gold">{{ $booking->reference }}</p>
        <dl class="mt-6 space-y-2 text-sm leading-6">
            <div>
                <dt class="text-mist">{{ __('Safari') }}</dt>
                <dd>{{ $booking->tour->title ?? $booking->tour_id }}</dd>
            </div>
            @if($booking->departure)
                <div>
                    <dt class="text-mist">{{ __('Dates') }}</dt>
                    <dd>{{ \App\Support\Format::date($booking->departure->start_date) }} – {{ \App\Support\Format::date($booking->departure->end_date) }}</dd>
                </div>
            @endif
            <div>
                <dt class="text-mist">{{ __('Travelers') }}</dt>
                <dd>
                    {{ $booking->lead_name }} · {{ trans_choice('{1} :count adult|[2,*] :count adults', $booking->adults, ['count' => $booking->adults]) }}
                    @if($booking->children > 0), {{ trans_choice('{1} :count child|[2,*] :count children', $booking->children, ['count' => $booking->children]) }}@endif
                </dd>
            </div>
            <div>
                <dt class="text-mist">{{ __('Status') }}</dt>
                <dd class="capitalize">{{ __('requested') }}</dd>
            </div>
        </dl>
        <a href="{{ route('safaris') }}" class="mt-8 inline-flex text-sm text-gold hover:underline">{{ __('Back to popular safari') }}</a>
    </div>
@endsection
