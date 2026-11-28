@php
    $socials = [
        ['label' => 'Instagram', 'href' => 'https://www.instagram.com/'],
        ['label' => 'Facebook', 'href' => 'https://www.facebook.com/'],
        ['label' => 'TikTok', 'href' => 'https://www.tiktok.com/'],
    ];
@endphp
<footer class="mt-16 border-t border-line">
    <div class="mx-auto flex max-w-6xl flex-col items-center px-5 py-10">
        @include('partials.brand', ['compact' => true])
        <ul class="mt-6 flex flex-wrap items-center justify-center gap-5">
            @foreach($socials as $social)
                <li>
                    <a href="{{ $social['href'] }}" aria-label="{{ $social['label'] }}" target="_blank" rel="noopener noreferrer" class="text-pale hover:text-gold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gold">
                        @include('partials.icons.'.strtolower($social['label']))
                    </a>
                </li>
            @endforeach
        </ul>
        <p class="mt-5 text-center text-sm font-light tracking-wide text-mist">&copy; {{ date('Y') }} Travelers Diary</p>
    </div>
</footer>
