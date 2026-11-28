<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
        try {
            if (localStorage.getItem('td-theme') === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        } catch (e) {}
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title.' · Travelers Diary' : 'Travelers Diary' }}</title>
    <meta name="description" content="{{ $description ?? __('Safari journeys written by nature and lived by you. Choose a departure, send your details, and the desk confirms the reservation.') }}">
    @isset($robots)
        <meta name="robots" content="{{ $robots }}">
    @endisset
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        night: 'rgb(var(--rgb-night) / <alpha-value>)',
                        gold: 'rgb(var(--rgb-gold) / <alpha-value>)',
                        pale: 'rgb(var(--rgb-pale) / <alpha-value>)',
                        mist: 'rgb(var(--rgb-mist) / <alpha-value>)',
                        khaki: 'rgb(var(--rgb-khaki) / <alpha-value>)',
                        ink: 'rgb(var(--rgb-ink) / <alpha-value>)',
                        line: 'rgb(var(--rgb-line) / <alpha-value>)',
                        leaf: '#2e9d57',
                        'leaf-light': '#3cb56c',
                    },
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body class="flex min-h-full flex-col antialiased">
    <a href="#content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-full focus:bg-gold focus:px-4 focus:py-2 focus:text-night">{{ __('Skip to content') }}</a>
    @include('partials.header')
    <div class="border-b border-line bg-night px-5 py-3">
        <div class="mx-auto flex max-w-6xl justify-center">
            <a href="{{ route('plan') }}" class="inline-flex rounded-full bg-leaf px-5 py-2 text-sm text-pale hover:bg-leaf-light focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-leaf">{{ __('Plan a safari') }}</a>
        </div>
    </div>
    <main id="content" class="flex-1">
        @yield('content')
    </main>
    @include('partials.footer')
    @include('partials.nav')
    <script>
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.querySelectorAll('video').forEach(function (video) {
                video.pause();
                video.removeAttribute('autoplay');
            });
        }
        var themeButton = document.getElementById('theme-toggle');
        if (themeButton) {
            var light = document.documentElement.getAttribute('data-theme') === 'light';
            themeButton.setAttribute('aria-pressed', light ? 'true' : 'false');
            themeButton.addEventListener('click', function () {
                var nextLight = document.documentElement.getAttribute('data-theme') !== 'light';
                if (nextLight) document.documentElement.setAttribute('data-theme', 'light');
                else document.documentElement.removeAttribute('data-theme');
                try { localStorage.setItem('td-theme', nextLight ? 'light' : 'dark'); } catch (e) {}
                themeButton.setAttribute('aria-pressed', nextLight ? 'true' : 'false');
            });
        }
    </script>
</body>
</html>
