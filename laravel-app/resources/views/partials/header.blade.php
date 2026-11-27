<header class="border-b border-line bg-night/95">
    <div class="mx-auto flex max-w-6xl items-center justify-center gap-3 px-4 py-4 sm:px-5">
        <a href="{{ route('home') }}" aria-label="Home" class="shrink-0 text-pale hover:text-gold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">
            @include('partials.icons.home')
        </a>
        <a href="{{ route('home') }}" class="rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">
            @include('partials.brand')
        </a>
    </div>
</header>
