@php
    $items = [
        ['route' => 'plan', 'label' => 'Plan', 'match' => 'plan*'],
        ['route' => 'safaris', 'label' => 'Popular', 'match' => 'safaris*'],
        ['route' => 'diary', 'label' => 'Diary', 'match' => 'diary'],
        ['route' => 'contact', 'label' => 'Contacts', 'match' => 'contact'],
    ];
@endphp
<nav aria-label="Pages" class="fixed inset-x-4 bottom-3 z-40 rounded-3xl border border-line bg-night/30 pb-[env(safe-area-inset-bottom)] shadow-lg backdrop-blur-md">
    <ul class="mx-auto grid max-w-lg grid-cols-4">
        @foreach($items as $item)
            @php $active = request()->is($item['match']); @endphp
            <li>
                <a href="{{ route($item['route']) }}" @if($active) aria-current="page" @endif class="flex flex-col items-center gap-1 px-2 py-2.5 text-[0.65rem] font-light uppercase tracking-[0.14em] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold {{ $active ? 'text-gold' : 'text-mist hover:text-gold' }}">
                    @include('partials.icons.'.$item['route'])
                    {{ $item['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
