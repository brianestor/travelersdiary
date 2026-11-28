@php $openId = $departures->first(fn ($row) => $row->seatsLeft() > 0)?->id; @endphp
<form method="get" action="{{ route('book') }}" class="rounded-3xl border border-line bg-night p-5 text-pale">
    <input type="hidden" name="tour" value="{{ $tour->slug }}">
    <h2 class="display text-xl text-gold">{{ __('Reserve a departure') }}</h2>
    <p class="mt-2 text-sm font-light leading-6 tracking-wide text-mist">
        {{ __('Choose a date and a party size. You will add a name and contact on the next page. Nothing is charged.') }}
    </p>
    <fieldset class="mt-5 space-y-3">
        <legend class="text-sm font-medium tracking-wide">{{ __('Departures') }}</legend>
        @foreach($departures as $departure)
            <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-line px-3 py-3 has-[:checked]:border-gold">
                <input type="radio" name="departure" value="{{ $departure->id }}" class="mt-1" @disabled($departure->seatsLeft() === 0) @checked($departure->id === $openId)>
                <span>
                    <span class="block text-sm">{{ \App\Support\Format::date($departure->start_date) }} – {{ \App\Support\Format::date($departure->end_date) }}</span>
                    <span class="block text-sm text-mist">
                        {{ __(':price per person', ['price' => \App\Support\Format::money($departure->price_per_person)]) }}
                        @if($departure->seatsLeft() === 0)
                            · {{ __('full') }}
                        @else
                            · {{ trans_choice('{1} :count seat left|[2,*] :count seats left', $departure->seatsLeft(), ['count' => $departure->seatsLeft()]) }}
                        @endif
                    </span>
                </span>
            </label>
        @endforeach
    </fieldset>
    <div class="mt-4 grid grid-cols-2 gap-3">
        <label class="text-sm">
            {{ __('Adults') }}
            <input type="number" name="adults" min="1" max="8" value="2" class="field">
        </label>
        <label class="text-sm">
            {{ __('Children') }}
            <input type="number" name="children" min="0" max="6" value="0" class="field">
        </label>
    </div>
    <button type="submit" class="mt-4 inline-flex rounded-full bg-gold px-4 py-2 text-sm text-night hover:bg-pale">{{ __('Continue') }}</button>
</form>
