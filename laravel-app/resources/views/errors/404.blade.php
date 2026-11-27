@extends('layouts.site')

@section('content')
    <div class="mx-auto max-w-3xl px-5 py-20">
        <h1 class="display text-4xl text-gold sm:text-5xl">That page is not in the diary</h1>
        <p class="mt-4 font-light tracking-wide text-mist">The route may have moved, or the reference is not on this desk.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-flex text-gold hover:underline">Return home</a>
    </div>
@endsection
