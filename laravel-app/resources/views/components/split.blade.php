@props(['item', 'tone' => 'night', 'hero' => false])
<section class="split-media {{ $tone === 'khaki' ? 'split-media-khaki' : '' }} {{ $hero ? 'split-media-hero' : '' }}">
    <div class="split-media-visual">
        @include('partials.frame', ['item' => $item])
    </div>
    <div class="split-media-copy">
        {{ $slot }}
    </div>
</section>
