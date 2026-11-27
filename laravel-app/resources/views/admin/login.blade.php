@extends('layouts.site')

@section('content')
    @php
        $error = request('error') === 'password'
            ? 'That password does not open the desk.'
            : (request('error') === 'config' ? 'Set ADMIN_PASSWORD in .env, then try again.' : null);
    @endphp
    <div class="mx-auto max-w-md px-5 py-16">
        <h1 class="display text-3xl text-gold">Staff desk</h1>
        <p class="mt-3 text-sm font-light leading-6 tracking-wide text-mist">Reservations and remaining seats. This page is for the team.</p>
        @unless($configured)
            <p class="mt-4 text-sm text-gold">ADMIN_PASSWORD is not set.</p>
        @endunless
        <form method="post" action="{{ route('admin.login') }}" class="mt-6 space-y-4">
            @csrf
            <label class="block text-sm">
                Password
                <input type="password" name="password" required class="field">
            </label>
            @if($error)
                <p class="text-sm text-gold">{{ $error }}</p>
            @endif
            <button type="submit" class="rounded-full bg-gold px-5 py-2.5 text-night">Open the desk</button>
        </form>
    </div>
@endsection
