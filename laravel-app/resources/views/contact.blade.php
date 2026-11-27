@extends('layouts.site')

@section('content')
    <x-split :item="\App\Support\Media::all()['lion']">
        <p class="text-xs font-light tracking-[0.22em] text-pale">The desk</p>
        <h1 class="display mt-3 text-4xl text-gold sm:text-5xl">Contacts</h1>
        <div class="mt-5 max-w-xl space-y-4 font-light leading-7 tracking-wide text-mist">
            <p>Questions come here. A reservation — dates, seats, names — starts on Plan a safari so the right departure is held.</p>
            <p>Notes are saved for the desk. They are not emailed, and this address is a placeholder until the real desk inbox is connected.</p>
            <p class="text-pale">hello@travelersdiary.example</p>
        </div>
        <div class="mt-8 max-w-xl">
            @if(session('sent'))
                <p class="rounded-3xl border border-line p-6 font-light leading-7 tracking-wide">
                    The desk has your note. It is saved here, not emailed. If you were asking about a date, you can also reserve a departure from the safari page.
                </p>
            @else
                <form method="post" action="{{ route('contact.store') }}" class="space-y-4">
                    @csrf
                    <label class="block text-sm">
                        Name
                        <input name="name" required autocomplete="name" value="{{ old('name') }}" class="field">
                    </label>
                    <label class="block text-sm">
                        Email
                        <input name="email" type="email" required autocomplete="email" value="{{ old('email') }}" class="field">
                    </label>
                    <label class="block text-sm">
                        Message
                        <textarea name="message" required rows="5" class="field">{{ old('message') }}</textarea>
                    </label>
                    @if(session('form_error'))
                        <p class="text-sm text-gold" role="alert">{{ session('form_error') }}</p>
                    @endif
                    <button type="submit" class="rounded-full bg-gold px-5 py-2.5 text-night hover:bg-pale">Send the note</button>
                </form>
            @endif
        </div>
    </x-split>
@endsection
