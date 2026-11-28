@extends('layouts.site')

@section('content')
    @php
        $today = now()->toDateString();
        $kinds = [
            'safari' => __('Normal safari'),
            'kilimanjaro' => __('Mount Kilimanjaro'),
            'zanzibar' => __('Zanzibar'),
        ];
        $stays = [
            'explorer' => __('Explorer'),
            'signature' => __('Signature'),
            'premium' => __('Premium'),
        ];
        $codes = [
            '+255' => __('Tanzania').' +255',
            '+254' => __('Kenya').' +254',
            '+256' => __('Uganda').' +256',
            '+1' => __('United States').' +1',
            '+44' => __('United Kingdom').' +44',
        ];
    @endphp
    <section class="wizard-sheet">
        <p class="text-xs font-light tracking-[0.22em]">{{ __('A reservation request') }}</p>
        <h1 class="display mt-3 text-4xl sm:text-5xl">{{ __('Plan a safari') }}</h1>
        <p id="step-label" class="mt-4 text-sm tracking-[0.14em]">{{ __('Step :current of :total', ['current' => 1, 'total' => 8]) }}</p>
        @if(session('form_error'))
            <p class="mt-4 text-sm" role="alert">{{ session('form_error') }}</p>
        @endif
        <p id="step-error" class="mt-4 hidden text-sm" role="alert"></p>

        <div class="wizard-body">
            <div class="wizard-stage" aria-hidden="true">
                <svg class="wizard-draw" data-scene="date" viewBox="0 0 120 120">
                    <rect x="22" y="28" width="76" height="68" rx="8" fill="none" stroke="currentColor" stroke-width="2" />
                    <path d="M22 46h76M40 22v12M80 22v12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <circle class="wizard-pulse" cx="60" cy="70" r="6" fill="currentColor" />
                </svg>
                <svg class="wizard-draw" data-scene="trail" viewBox="0 0 120 120" hidden>
                    <path class="wizard-trail" d="M18 86c18-8 22-28 40-32s20 18 44-22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <circle cx="18" cy="86" r="3" fill="currentColor" />
                    <circle cx="102" cy="32" r="3" fill="currentColor" />
                </svg>
                <svg class="wizard-draw" data-scene="trip-safari" viewBox="0 0 120 120" hidden>
                    <path class="wizard-bob" d="M24 74h72l-8-18H40L24 74z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    <circle class="wizard-bob" cx="42" cy="80" r="6" fill="none" stroke="currentColor" stroke-width="2" />
                    <circle class="wizard-bob" cx="78" cy="80" r="6" fill="none" stroke="currentColor" stroke-width="2" />
                    <path d="M20 90h80" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <svg class="wizard-draw" data-scene="trip-kilimanjaro" viewBox="0 0 120 120" hidden>
                    <path class="wizard-bob" d="M16 92 L48 36l14 22 10-14 32 48z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    <path d="M48 36l6 8h-10z" fill="currentColor" />
                </svg>
                <svg class="wizard-draw" data-scene="trip-zanzibar" viewBox="0 0 120 120" hidden>
                    <path class="wizard-wave" d="M16 78c10 8 18-8 28 0s18-8 28 0 18-8 28 0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <path d="M34 78V48h28l16 14v16" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    <path d="M48 48V32" stroke="currentColor" stroke-width="2" />
                </svg>
                <svg class="wizard-draw" data-scene="party" viewBox="0 0 120 120" hidden>
                    <circle class="wizard-bob" cx="46" cy="42" r="8" fill="none" stroke="currentColor" stroke-width="2" />
                    <path class="wizard-bob" d="M32 86c2-14 8-20 14-20s12 6 14 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <circle class="wizard-bob" cx="78" cy="48" r="6" fill="none" stroke="currentColor" stroke-width="2" />
                    <path class="wizard-bob" d="M66 86c1-10 6-16 12-16s11 6 12 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <svg class="wizard-draw" data-scene="budget" viewBox="0 0 120 120" hidden>
                    <ellipse class="wizard-coin" cx="60" cy="60" rx="22" ry="22" fill="none" stroke="currentColor" stroke-width="2" />
                    <path class="wizard-coin" d="M60 46v28M52 52h12a6 6 0 0 1 0 12H54a6 6 0 0 0 0 12h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <svg class="wizard-draw" data-scene="stay-explorer" viewBox="0 0 120 120" hidden>
                    <path class="wizard-bob" d="M28 78 L60 42l32 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    <path d="M40 78v16h40V78" fill="none" stroke="currentColor" stroke-width="2" />
                </svg>
                <svg class="wizard-draw" data-scene="stay-signature" viewBox="0 0 120 120" hidden>
                    <path d="M30 92V52h60v40" fill="none" stroke="currentColor" stroke-width="2" />
                    <path class="wizard-bob" d="M24 52h72L60 32z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    <path d="M52 92V70h16v22" fill="none" stroke="currentColor" stroke-width="2" />
                </svg>
                <svg class="wizard-draw" data-scene="stay-premium" viewBox="0 0 120 120" hidden>
                    <path d="M26 92V48h68v44" fill="none" stroke="currentColor" stroke-width="2" />
                    <path class="wizard-bob" d="M18 48h84L60 24z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    <path d="M48 92V66h24v26M36 60h8M76 60h8" fill="none" stroke="currentColor" stroke-width="2" />
                </svg>
                <svg class="wizard-draw" data-scene="letter" viewBox="0 0 120 120" hidden>
                    <rect x="24" y="36" width="72" height="48" rx="4" fill="none" stroke="currentColor" stroke-width="2" />
                    <path class="wizard-pulse" d="M26 40l34 24 34-24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                </svg>
                <svg class="wizard-draw" data-scene="phone" viewBox="0 0 120 120" hidden>
                    <rect x="42" y="24" width="36" height="72" rx="6" fill="none" stroke="currentColor" stroke-width="2" />
                    <path class="wizard-pulse" d="M54 84h12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </div>
            <form id="planner" method="post" action="{{ route('plan.store') }}" class="mt-6 max-w-xl sm:mt-0">
            @csrf

            <section class="wizard-step" data-step="1">
                <h2 class="display text-2xl">{{ __('When do you want to go?') }}</h2>
                <label class="mt-5 block text-sm">
                    {{ __('Start day') }}
                    <input type="date" name="start_date" min="{{ $today }}" value="{{ old('start_date') }}" class="field">
                </label>
            </section>

            <section class="wizard-step" data-step="2" hidden>
                <h2 class="display text-2xl">{{ __('How many days?') }}</h2>
                <p class="mt-2 text-sm font-light">{{ __('From 1 day to 21 days.') }}</p>
                <p class="mt-5 text-3xl" id="duration-read">7 days</p>
                <input class="wizard-range mt-4" type="range" name="duration_days" id="duration" min="1" max="21" value="{{ old('duration_days', 7) }}">
                <div class="mt-4 flex gap-3">
                    <button type="button" class="rounded-full border border-ink px-4 py-2" data-nudge="duration" data-dir="-1">{{ __('Minus') }}</button>
                    <button type="button" class="rounded-full border border-ink px-4 py-2" data-nudge="duration" data-dir="1">{{ __('Plus') }}</button>
                </div>
            </section>

            <section class="wizard-step" data-step="3" hidden>
                <h2 class="display text-2xl">{{ __('What kind of trip?') }}</h2>
                <div class="mt-5 grid gap-3">
                    @foreach($kinds as $value => $label)
                        <label class="wizard-choice cursor-pointer rounded-2xl px-4 py-3">
                            <input class="sr-only" type="radio" name="safari_type" value="{{ $value }}" @checked(old('safari_type') === $value)>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </section>

            <section class="wizard-step" data-step="4" hidden>
                <h2 class="display text-2xl">{{ __('Who is traveling?') }}</h2>
                <div class="mt-5 flex items-center justify-between gap-4">
                    <span>{{ __('Adults') }}</span>
                    <span class="flex items-center gap-3">
                        <button type="button" class="rounded-full border border-ink px-3 py-1" data-count="adults" data-dir="-1" aria-label="{{ __('Fewer adults') }}">−</button>
                        <input id="adults" name="adults" type="number" min="1" max="12" value="{{ old('adults', 1) }}" class="w-14 border-0 bg-transparent text-center text-xl">
                        <button type="button" class="rounded-full border border-ink px-3 py-1" data-count="adults" data-dir="1" aria-label="{{ __('More adults') }}">+</button>
                    </span>
                </div>
                <div class="mt-4 flex items-center justify-between gap-4">
                    <span>{{ __('Children') }}</span>
                    <span class="flex items-center gap-3">
                        <button type="button" class="rounded-full border border-ink px-3 py-1" data-count="children" data-dir="-1" aria-label="{{ __('Fewer children') }}">−</button>
                        <input id="children" name="children" type="number" min="0" max="8" value="{{ old('children', 0) }}" class="w-14 border-0 bg-transparent text-center text-xl">
                        <button type="button" class="rounded-full border border-ink px-3 py-1" data-count="children" data-dir="1" aria-label="{{ __('More children') }}">+</button>
                    </span>
                </div>
                <div id="ages" class="mt-5 space-y-3"></div>
            </section>

            <section class="wizard-step" data-step="5" hidden>
                <h2 class="display text-2xl">{{ __('Budget per person') }}</h2>
                <p class="mt-2 text-sm font-light">{{ __('From $150 to $5,000. This is a guide for the desk, not a charge.') }}</p>
                <p class="mt-5 text-3xl" id="budget-read">$1,500</p>
                <input class="wizard-range mt-4" type="range" name="budget" id="budget" min="150" max="5000" step="50" value="{{ old('budget', 1500) }}">
                <div class="mt-4 flex gap-3">
                    <button type="button" class="rounded-full border border-ink px-4 py-2" data-nudge="budget" data-dir="-1">{{ __('Minus') }}</button>
                    <button type="button" class="rounded-full border border-ink px-4 py-2" data-nudge="budget" data-dir="1">{{ __('Plus') }}</button>
                </div>
            </section>

            <section class="wizard-step" data-step="6" hidden>
                <h2 class="display text-2xl">{{ __('Where you sleep') }}</h2>
                <div class="mt-5 grid gap-3">
                    @foreach($stays as $value => $label)
                        <label class="wizard-choice cursor-pointer rounded-2xl px-4 py-3">
                            <input class="sr-only" type="radio" name="accommodation" value="{{ $value }}" @checked(old('accommodation') === $value)>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </section>

            <section class="wizard-step" data-step="7" hidden>
                <h2 class="display text-2xl">{{ __('How can the desk reach you?') }}</h2>
                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm">
                        {{ __('First name') }}
                        <input name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" class="field">
                    </label>
                    <label class="block text-sm">
                        {{ __('Last name') }}
                        <input name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" class="field">
                    </label>
                </div>
                <label class="mt-4 block text-sm">
                    {{ __('Email') }}
                    <input name="email" type="email" value="{{ old('email') }}" autocomplete="email" class="field">
                </label>
                <div class="mt-4 grid gap-4 sm:grid-cols-[12rem_1fr]">
                    <label class="block text-sm">
                        {{ __('Country code') }}
                        <select name="country_code" class="field">
                            @foreach($codes as $value => $label)
                                <option value="{{ $value }}" @selected(old('country_code', '+255') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block text-sm">
                        {{ __('Phone') }}
                        <input name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel-national" class="field">
                    </label>
                </div>
            </section>

            <section class="wizard-step" data-step="8" hidden>
                <h2 class="display text-2xl">{{ __('How should we reply?') }}</h2>
                <p class="mt-2 text-sm font-light">{{ __('Nothing is charged. The desk confirms the plan with you.') }}</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <button type="submit" name="contact_method" value="email" class="rounded-full bg-night px-5 py-2.5 text-pale">{{ __('Email') }}</button>
                    <button type="submit" name="contact_method" value="whatsapp" class="rounded-full border border-ink px-5 py-2.5">WhatsApp</button>
                </div>
            </section>

            <div class="mt-8 flex gap-3">
                <button type="button" id="back" class="rounded-full border border-ink px-5 py-2.5" hidden>{{ __('Back') }}</button>
                <button type="button" id="next" class="rounded-full bg-night px-5 py-2.5 text-pale">{{ __('Next') }}</button>
            </div>
        </form>
        </div>
    </section>
    <script>
        (function () {
            const form = document.getElementById('planner');
            const steps = [...form.querySelectorAll('.wizard-step')];
            const label = document.getElementById('step-label');
            const error = document.getElementById('step-error');
            const back = document.getElementById('back');
            const next = document.getElementById('next');
            const ages = document.getElementById('ages');
            const oldAges = @json(array_values(old('child_ages', [])));
            const copy = {
                step: @json(__('Step :current of :total')),
                day: @json(__('day')),
                days: @json(__('days')),
                childAge: @json(__('Child :n age')),
                younger: @json(__('Younger')),
                older: @json(__('Older')),
                chooseStart: @json(__('Choose the day the trip starts.')),
                startPassed: @json(__('Choose a start day that has not already passed.')),
                chooseKind: @json(__('Choose a normal safari, Mount Kilimanjaro, or Zanzibar.')),
                oneAdult: @json(__('Include at least one adult.')),
                eachAge: @json(__('Add an age for each child.')),
                ageRange: @json(__('Each child\'s age must be between 0 and 17.')),
                chooseStay: @json(__('Choose Explorer, Signature, or Premium.')),
                firstName: @json(__('Add a first name.')),
                lastName: @json(__('Add a last name.')),
                email: @json(__('Add an email the desk can reply to.')),
                phone: @json(__('Add a phone number with at least seven digits.')),
            };
            let index = 0;

            function money(amount) {
                return '$' + Number(amount).toLocaleString('en-US');
            }

            function readDuration() {
                const input = form.duration_days;
                document.getElementById('duration-read').textContent = input.value + ' ' + (input.value === '1' ? copy.day : copy.days);
            }

            function readBudget() {
                document.getElementById('budget-read').textContent = money(form.budget.value);
            }

            function show(nextIndex) {
                index = nextIndex;
                steps.forEach((step, stepIndex) => { step.hidden = stepIndex !== index; });
                label.textContent = copy.step.replace(':current', index + 1).replace(':total', steps.length);
                back.hidden = index === 0;
                next.hidden = index === steps.length - 1;
                error.classList.add('hidden');
                paint();
            }

            function paint() {
                const names = ['date', 'trail', 'trip', 'party', 'budget', 'stay', 'letter', 'phone'];
                let scene = names[index] || 'date';
                if (scene === 'trip') scene = 'trip-' + (chosen('safari_type') || 'safari');
                if (scene === 'stay') scene = 'stay-' + (chosen('accommodation') || 'explorer');
                document.querySelectorAll('.wizard-draw').forEach(function (drawing) {
                    drawing.hidden = drawing.dataset.scene !== scene;
                });
            }

            function complain(message) {
                error.textContent = message;
                error.classList.remove('hidden');
            }

            function clamp(input) {
                const min = Number(input.min);
                const max = Number(input.max);
                let value = Number(input.value);
                if (Number.isNaN(value)) value = min;
                input.value = Math.min(max, Math.max(min, value));
            }

            function syncAges() {
                const count = Number(form.children.value);
                while (ages.children.length < count) {
                    const number = ages.children.length + 1;
                    const row = document.createElement('div');
                    row.className = 'flex items-center justify-between gap-4';
                    row.innerHTML = '<span>' + copy.childAge.replace(':n', number) + '</span><span class="flex items-center gap-3"><button type="button" class="rounded-full border border-ink px-3 py-1" data-age="-1" aria-label="' + copy.younger + '">−</button><input type="number" name="child_ages[]" min="0" max="17" value="8" class="w-14 border-0 bg-transparent text-center text-xl"><button type="button" class="rounded-full border border-ink px-3 py-1" data-age="1" aria-label="' + copy.older + '">+</button></span>';
                    ages.appendChild(row);
                }
                while (ages.children.length > count) ages.lastElementChild.remove();
                [...ages.querySelectorAll('span')].forEach((span, spanIndex) => {
                    if (span.firstChild && span.firstChild.nodeType === Node.TEXT_NODE) return;
                });
                [...ages.children].forEach((row, rowIndex) => {
                    row.querySelector('span').textContent = copy.childAge.replace(':n', rowIndex + 1);
                });
            }

            function chosen(name) {
                const field = form.elements[name];
                if (!field) return '';
                if (field.value !== undefined && field.type !== 'radio') return String(field.value || '');
                const picked = [...form.querySelectorAll('input[name="' + name + '"]')].find((input) => input.checked);
                return picked ? picked.value : '';
            }

            function validate(step) {
                if (step === 0 && !form.start_date.value) return copy.chooseStart;
                if (step === 0 && form.start_date.value < form.start_date.min) return copy.startPassed;
                if (step === 2 && !chosen('safari_type')) return copy.chooseKind;
                if (step === 3) {
                    clamp(form.adults);
                    clamp(form.children);
                    if (Number(form.adults.value) < 1) return copy.oneAdult;
                    const ageInputs = [...ages.querySelectorAll('input')];
                    if (ageInputs.length !== Number(form.children.value)) return copy.eachAge;
                    if (ageInputs.some((input) => input.value === '' || Number(input.value) < 0 || Number(input.value) > 17)) {
                        return copy.ageRange;
                    }
                }
                if (step === 5 && !chosen('accommodation')) return copy.chooseStay;
                if (step === 6) {
                    if ((form.first_name.value || '').trim().length < 2) return copy.firstName;
                    if ((form.last_name.value || '').trim().length < 2) return copy.lastName;
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email.value || '')) return copy.email;
                    const digits = (form.phone.value || '').replace(/\D/g, '');
                    if (digits.length < 7 || digits.length > 15) return copy.phone;
                }
                return '';
            }

            form.addEventListener('click', function (event) {
                const nudge = event.target.closest('[data-nudge]');
                if (nudge) {
                    const input = form.elements[nudge.dataset.nudge];
                    const step = Number(input.step) || 1;
                    input.value = Number(input.value) + Number(nudge.dataset.dir) * step;
                    clamp(input);
                    readDuration();
                    readBudget();
                }
                const count = event.target.closest('[data-count]');
                if (count) {
                    const input = form.elements[count.dataset.count];
                    input.value = Number(input.value) + Number(count.dataset.dir);
                    clamp(input);
                    syncAges();
                }
                const age = event.target.closest('[data-age]');
                if (age) {
                    const input = age.parentElement.querySelector('input');
                    input.value = Number(input.value) + Number(age.dataset.age);
                    clamp(input);
                }
            });

            form.duration_days.addEventListener('input', readDuration);
            form.budget.addEventListener('input', readBudget);
            form.adults.addEventListener('change', function () { clamp(form.adults); });
            form.children.addEventListener('change', function () { clamp(form.children); syncAges(); });
            form.addEventListener('change', function (event) {
                if (event.target.name === 'safari_type' || event.target.name === 'accommodation') paint();
            });

            next.addEventListener('click', function () {
                const problem = validate(index);
                if (problem) { complain(problem); return; }
                show(index + 1);
            });
            back.addEventListener('click', function () { show(Math.max(0, index - 1)); });
            form.addEventListener('submit', function (event) {
                for (let step = 0; step < 7; step += 1) {
                    const problem = validate(step);
                    if (problem) {
                        event.preventDefault();
                        show(step);
                        complain(problem);
                        return;
                    }
                }
            });

            syncAges();
            [...ages.querySelectorAll('input')].forEach(function (input, inputIndex) {
                if (oldAges[inputIndex] !== undefined) input.value = oldAges[inputIndex];
            });
            readDuration();
            readBudget();
            @if(session('form_error'))
                show(7);
            @else
                show(0);
            @endif
        })();
    </script>
@endsection
