@extends('layouts.site')

@section('content')
    <div class="mx-auto max-w-3xl px-5 py-16">
        <p class="text-xs font-light tracking-[0.22em] text-pale">{{ __('Requested, not yet confirmed') }}</p>
        <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">{{ __('The desk has your plan') }}</h1>
        <p class="mt-4 font-light leading-7 tracking-wide text-mist">
            @if($plan->contact_method === 'whatsapp')
                {{ __('The desk will reply on WhatsApp at :phone. Nothing has been charged.', ['phone' => $plan->country_code.' '.$plan->phone]) }}
            @else
                {{ __('The desk will write to :email. Nothing has been charged.', ['email' => $plan->email]) }}
            @endif
        </p>
        <p class="display mt-8 text-3xl text-gold">{{ $plan->reference }}</p>
        <dl class="mt-6 space-y-2 text-sm leading-6">
            <div>
                <dt class="text-mist">{{ __('Trip') }}</dt>
                <dd>{{ $plan->safariLabel() }} · {{ trans_choice('{1} :count day|[2,*] :count days', $plan->duration_days, ['count' => $plan->duration_days]) }}</dd>
            </div>
            <div>
                <dt class="text-mist">{{ __('Starts') }}</dt>
                <dd>{{ \App\Support\Format::date($plan->start_date) }}</dd>
            </div>
            <div>
                <dt class="text-mist">{{ __('Travelers') }}</dt>
                <dd>
                    {{ $plan->first_name }} {{ $plan->last_name }} · {{ trans_choice('{1} :count adult|[2,*] :count adults', $plan->adults, ['count' => $plan->adults]) }}
                    @if($plan->children > 0)
                        , {{ trans_choice('{1} :count child|[2,*] :count children', $plan->children, ['count' => $plan->children]) }}
                        ({{ collect($plan->child_ages)->map(fn ($age) => trans_choice('{0} :count years|{1} :count year|[2,*] :count years', (int) $age, ['count' => (int) $age]))->join(', ') }})
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-mist">{{ __('Budget') }}</dt>
                <dd>{{ __(':price per person', ['price' => \App\Support\Format::money($plan->budget)]) }} · {{ $plan->stayLabel() }}</dd>
            </div>
            <div>
                <dt class="text-mist">{{ __('Status') }}</dt>
                <dd class="capitalize">{{ __('requested') }}</dd>
            </div>
        </dl>
        <a href="{{ route('safaris') }}" class="mt-8 inline-flex text-sm text-gold hover:underline">{{ __('Back to popular safari') }}</a>
    </div>
@endsection
