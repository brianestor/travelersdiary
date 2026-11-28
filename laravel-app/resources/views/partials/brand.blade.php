@php $compact = $compact ?? false; @endphp
<span class="flex items-center gap-3">
    <img src="{{ asset('brand/mark-black.jpeg') }}" alt="" class="brand-mark {{ $compact ? 'h-10 w-10' : 'h-14 w-14' }} object-contain">
    <span class="flex flex-col leading-none">
        <span class="brand-name display whitespace-nowrap text-gold {{ $compact ? 'text-xs' : 'text-sm' }}">Travelers Diary</span>
        @unless($compact)
            <span class="brand-motto mt-1 whitespace-nowrap text-[0.7rem] font-light tracking-[0.14em] text-pale">{{ __('Written by nature, lived by you') }}</span>
        @endunless
    </span>
</span>
