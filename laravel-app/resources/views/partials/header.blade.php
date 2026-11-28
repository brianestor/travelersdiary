<header class="border-b border-line bg-night/95">
    <div class="site-header">
        <a href="{{ route('home') }}" aria-label="{{ __('Home') }}" class="shrink-0 text-pale hover:text-gold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">
            @include('partials.icons.home')
        </a>
        <a href="{{ route('home') }}" class="site-header-brand rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">
            @include('partials.brand')
        </a>
        <div class="site-header-tools">
            <button type="button" id="theme-toggle" aria-label="{{ __('Theme') }}" class="shrink-0 p-1 text-pale hover:text-gold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">
                <svg class="icon-sun" width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="12" cy="12" r="3.25" stroke="currentColor" stroke-width="1.5" />
                    <path d="M12 3.5v2.2M12 18.3v2.2M4.8 4.8l1.6 1.6M17.6 17.6l1.6 1.6M3.5 12h2.2M18.3 12h2.2M4.8 19.2l1.6-1.6M17.6 6.4l1.6-1.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
                <svg class="icon-moon" width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M15.5 3.8A7.8 7.8 0 1 0 20.2 15 6.2 6.2 0 0 1 15.5 3.8z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                </svg>
            </button>
            <details class="lang-menu">
                <summary aria-label="{{ __('Language') }}" class="inline-flex min-w-[2.6rem] cursor-pointer items-center justify-center rounded-full border border-line px-2 py-1 text-xs font-medium tracking-[0.14em] text-pale hover:text-gold">{{ strtoupper(app()->getLocale()) }}</summary>
                <ul>
                    @foreach (['en' => 'English', 'fr' => 'Français', 'es' => 'Español', 'de' => 'Deutsch'] as $code => $name)
                        <li>
                            <a href="{{ route('locale', $code) }}" class="block rounded-xl px-3 py-2 text-sm text-pale hover:text-gold" @if(app()->getLocale() === $code) aria-current="true" @endif>{{ $name }}</a>
                        </li>
                    @endforeach
                </ul>
            </details>
        </div>
    </div>
</header>
