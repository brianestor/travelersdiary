<figure class="circuit-map">
    <img src="{{ asset('maps/'.$image) }}" alt="{{ $title }}" width="640" height="400">
    <figcaption class="mt-2 text-sm font-light leading-6 text-mist">
        {{ collect($names)->join(' · ') }}
        <span class="mt-1 block text-xs">
            <a href="https://www.openstreetmap.org/copyright" class="hover:text-gold" target="_blank" rel="noopener noreferrer">{{ __('Map data © OpenStreetMap contributors') }}</a>
        </span>
    </figcaption>
</figure>
