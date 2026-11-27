@php
    $fit = in_array($item['ratio'], ['landscape', 'video-landscape'], true) ? 'object-contain' : 'object-cover object-center';
@endphp
<div class="mx-auto overflow-hidden bg-night frame-{{ $item['ratio'] }}">
    @if($item['kind'] === 'video')
        <video class="h-full w-full {{ $fit }}" src="{{ $item['src'] }}" muted loop playsinline autoplay aria-label="{{ $item['alt'] }}"></video>
    @else
        <img src="{{ $item['src'] }}" alt="{{ $item['alt'] }}" class="h-full w-full {{ $fit }}">
    @endif
</div>
