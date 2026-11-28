@extends('layouts.site')

@section('content')
    @php
        $today = now()->toDateString();
        $kinds = [
            'safari' => 'Normal safari',
            'kilimanjaro' => 'Mount Kilimanjaro',
            'zanzibar' => 'Zanzibar',
        ];
        $stays = [
            'explorer' => 'Explorer',
            'signature' => 'Signature',
            'premium' => 'Premium',
        ];
        $codes = [
            '+255' => 'Tanzania +255',
            '+254' => 'Kenya +254',
            '+256' => 'Uganda +256',
            '+1' => 'United States +1',
            '+44' => 'United Kingdom +44',
        ];
    @endphp
    <x-split :item="\App\Support\Media::all()['lunch']" tone="khaki">
        <p class="text-xs font-light tracking-[0.22em]">A reservation request</p>
        <h1 class="display mt-3 text-4xl sm:text-5xl">Plan a safari</h1>
        <p id="step-label" class="mt-4 text-sm tracking-[0.14em]">Step 1 of 8</p>
        @if(session('form_error'))
            <p class="mt-4 text-sm" role="alert">{{ session('form_error') }}</p>
        @endif
        <p id="step-error" class="mt-4 hidden text-sm" role="alert"></p>

        <form id="planner" method="post" action="{{ route('plan.store') }}" class="mt-6 max-w-xl">
            @csrf

            <section class="wizard-step" data-step="1">
                <h2 class="display text-2xl">When do you want to go?</h2>
                <label class="mt-5 block text-sm">
                    Start day
                    <input type="date" name="start_date" min="{{ $today }}" value="{{ old('start_date') }}" class="field">
                </label>
            </section>

            <section class="wizard-step" data-step="2" hidden>
                <h2 class="display text-2xl">How many days?</h2>
                <p class="mt-2 text-sm font-light">From 1 day to 21 days.</p>
                <p class="mt-5 text-3xl" id="duration-read">7 days</p>
                <input class="wizard-range mt-4" type="range" name="duration_days" id="duration" min="1" max="21" value="{{ old('duration_days', 7) }}">
                <div class="mt-4 flex gap-3">
                    <button type="button" class="rounded-full border border-ink px-4 py-2" data-nudge="duration" data-dir="-1">Minus</button>
                    <button type="button" class="rounded-full border border-ink px-4 py-2" data-nudge="duration" data-dir="1">Plus</button>
                </div>
            </section>

            <section class="wizard-step" data-step="3" hidden>
                <h2 class="display text-2xl">What kind of trip?</h2>
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
                <h2 class="display text-2xl">Who is traveling?</h2>
                <div class="mt-5 flex items-center justify-between gap-4">
                    <span>Adults</span>
                    <span class="flex items-center gap-3">
                        <button type="button" class="rounded-full border border-ink px-3 py-1" data-count="adults" data-dir="-1" aria-label="Fewer adults">−</button>
                        <input id="adults" name="adults" type="number" min="1" max="12" value="{{ old('adults', 1) }}" class="w-14 border-0 bg-transparent text-center text-xl">
                        <button type="button" class="rounded-full border border-ink px-3 py-1" data-count="adults" data-dir="1" aria-label="More adults">+</button>
                    </span>
                </div>
                <div class="mt-4 flex items-center justify-between gap-4">
                    <span>Children</span>
                    <span class="flex items-center gap-3">
                        <button type="button" class="rounded-full border border-ink px-3 py-1" data-count="children" data-dir="-1" aria-label="Fewer children">−</button>
                        <input id="children" name="children" type="number" min="0" max="8" value="{{ old('children', 0) }}" class="w-14 border-0 bg-transparent text-center text-xl">
                        <button type="button" class="rounded-full border border-ink px-3 py-1" data-count="children" data-dir="1" aria-label="More children">+</button>
                    </span>
                </div>
                <div id="ages" class="mt-5 space-y-3"></div>
            </section>

            <section class="wizard-step" data-step="5" hidden>
                <h2 class="display text-2xl">Budget per person</h2>
                <p class="mt-2 text-sm font-light">From $150 to $5,000. This is a guide for the desk, not a charge.</p>
                <p class="mt-5 text-3xl" id="budget-read">$1,500</p>
                <input class="wizard-range mt-4" type="range" name="budget" id="budget" min="150" max="5000" step="50" value="{{ old('budget', 1500) }}">
                <div class="mt-4 flex gap-3">
                    <button type="button" class="rounded-full border border-ink px-4 py-2" data-nudge="budget" data-dir="-1">Minus</button>
                    <button type="button" class="rounded-full border border-ink px-4 py-2" data-nudge="budget" data-dir="1">Plus</button>
                </div>
            </section>

            <section class="wizard-step" data-step="6" hidden>
                <h2 class="display text-2xl">Where you sleep</h2>
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
                <h2 class="display text-2xl">How can the desk reach you?</h2>
                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm">
                        First name
                        <input name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" class="field">
                    </label>
                    <label class="block text-sm">
                        Last name
                        <input name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" class="field">
                    </label>
                </div>
                <label class="mt-4 block text-sm">
                    Email
                    <input name="email" type="email" value="{{ old('email') }}" autocomplete="email" class="field">
                </label>
                <div class="mt-4 grid gap-4 sm:grid-cols-[12rem_1fr]">
                    <label class="block text-sm">
                        Country code
                        <select name="country_code" class="field">
                            @foreach($codes as $value => $label)
                                <option value="{{ $value }}" @selected(old('country_code', '+255') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block text-sm">
                        Phone
                        <input name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel-national" class="field">
                    </label>
                </div>
            </section>

            <section class="wizard-step" data-step="8" hidden>
                <h2 class="display text-2xl">How should we reply?</h2>
                <p class="mt-2 text-sm font-light">Nothing is charged. The desk confirms the plan with you.</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <button type="submit" name="contact_method" value="email" class="rounded-full bg-night px-5 py-2.5 text-pale">Email</button>
                    <button type="submit" name="contact_method" value="whatsapp" class="rounded-full border border-ink px-5 py-2.5">WhatsApp</button>
                </div>
            </section>

            <div class="mt-8 flex gap-3">
                <button type="button" id="back" class="rounded-full border border-ink px-5 py-2.5" hidden>Back</button>
                <button type="button" id="next" class="rounded-full bg-night px-5 py-2.5 text-pale">Next</button>
            </div>
        </form>
    </x-split>
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
            let index = 0;

            function money(amount) {
                return '$' + Number(amount).toLocaleString('en-US');
            }

            function readDuration() {
                const input = form.duration_days;
                document.getElementById('duration-read').textContent = input.value + (input.value === '1' ? ' day' : ' days');
            }

            function readBudget() {
                document.getElementById('budget-read').textContent = money(form.budget.value);
            }

            function show(nextIndex) {
                index = nextIndex;
                steps.forEach((step, stepIndex) => { step.hidden = stepIndex !== index; });
                label.textContent = 'Step ' + (index + 1) + ' of 8';
                back.hidden = index === 0;
                next.hidden = index === steps.length - 1;
                error.classList.add('hidden');
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
                    row.innerHTML = '<span>Child ' + number + ' age</span><span class="flex items-center gap-3"><button type="button" class="rounded-full border border-ink px-3 py-1" data-age="-1" aria-label="Younger">−</button><input type="number" name="child_ages[]" min="0" max="17" value="8" class="w-14 border-0 bg-transparent text-center text-xl"><button type="button" class="rounded-full border border-ink px-3 py-1" data-age="1" aria-label="Older">+</button></span>';
                    ages.appendChild(row);
                }
                while (ages.children.length > count) ages.lastElementChild.remove();
                [...ages.querySelectorAll('span')].forEach((span, spanIndex) => {
                    if (span.firstChild && span.firstChild.nodeType === Node.TEXT_NODE) return;
                });
                [...ages.children].forEach((row, rowIndex) => {
                    row.querySelector('span').textContent = 'Child ' + (rowIndex + 1) + ' age';
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
                if (step === 0 && !form.start_date.value) return 'Choose the day the trip starts.';
                if (step === 0 && form.start_date.value < form.start_date.min) return 'Choose a start day that has not already passed.';
                if (step === 2 && !chosen('safari_type')) return 'Choose a normal safari, Mount Kilimanjaro, or Zanzibar.';
                if (step === 3) {
                    clamp(form.adults);
                    clamp(form.children);
                    if (Number(form.adults.value) < 1) return 'Include at least one adult.';
                    const ageInputs = [...ages.querySelectorAll('input')];
                    if (ageInputs.length !== Number(form.children.value)) return 'Add an age for each child.';
                    if (ageInputs.some((input) => input.value === '' || Number(input.value) < 0 || Number(input.value) > 17)) {
                        return 'Each child\'s age must be between 0 and 17.';
                    }
                }
                if (step === 5 && !chosen('accommodation')) return 'Choose Explorer, Signature, or Premium.';
                if (step === 6) {
                    if ((form.first_name.value || '').trim().length < 2) return 'Add a first name.';
                    if ((form.last_name.value || '').trim().length < 2) return 'Add a last name.';
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email.value || '')) return 'Add an email the desk can reply to.';
                    const digits = (form.phone.value || '').replace(/\D/g, '');
                    if (digits.length < 7 || digits.length > 15) return 'Add a phone number with at least seven digits.';
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
