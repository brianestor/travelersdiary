@extends('layouts.site')

@section('content')
    <div class="mx-auto max-w-3xl px-5 py-16">
        <p class="text-xs font-light tracking-[0.22em] text-pale">Requested, not yet confirmed</p>
        <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">The desk has your plan</h1>
        <p class="mt-4 font-light leading-7 tracking-wide text-mist">
            @if($plan->contact_method === 'whatsapp')
                The desk will reply on WhatsApp at {{ $plan->country_code }} {{ $plan->phone }}. Nothing has been charged.
            @else
                The desk will write to {{ $plan->email }}. Nothing has been charged.
            @endif
        </p>
        <p class="display mt-8 text-3xl text-gold">{{ $plan->reference }}</p>
        <dl class="mt-6 space-y-2 text-sm leading-6">
            <div>
                <dt class="text-mist">Trip</dt>
                <dd>{{ $plan->safariLabel() }} · {{ $plan->duration_days }} {{ $plan->duration_days === 1 ? 'day' : 'days' }}</dd>
            </div>
            <div>
                <dt class="text-mist">Starts</dt>
                <dd>{{ \App\Support\Format::date($plan->start_date) }}</dd>
            </div>
            <div>
                <dt class="text-mist">Travelers</dt>
                <dd>
                    {{ $plan->first_name }} {{ $plan->last_name }} · {{ $plan->adults }} {{ $plan->adults === 1 ? 'adult' : 'adults' }}
                    @if($plan->children > 0)
                        , {{ $plan->children }} {{ $plan->children === 1 ? 'child' : 'children' }}
                        ({{ collect($plan->child_ages)->map(fn ($age) => $age.' years')->join(', ') }})
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-mist">Budget</dt>
                <dd>{{ \App\Support\Format::money($plan->budget) }} per person · {{ $plan->stayLabel() }}</dd>
            </div>
            <div>
                <dt class="text-mist">Status</dt>
                <dd class="capitalize">{{ $plan->status }}</dd>
            </div>
        </dl>
        <a href="{{ route('safaris') }}" class="mt-8 inline-flex text-sm text-gold hover:underline">Back to popular safari</a>
    </div>
@endsection
