{{--
    Category Card Component
    Props: name, image, count, href
--}}
@props([
    'name'  => 'Category',
    'image' => '',
    'count' => null,
    'href'  => '#',
])

<a href="{{ $href }}" class="group relative overflow-hidden rounded-2xl block aspect-square hover-lift">
    <img src="{{ $image }}"
         alt="{{ $name }}"
         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-108"
         loading="lazy" />

    {{-- Gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/80 via-neutral-900/20 to-transparent
                group-hover:from-brand-900/85 transition-all duration-300"></div>

    {{-- Label --}}
    <div class="absolute bottom-0 left-0 right-0 p-4">
        <p class="font-display text-white font-semibold text-lg leading-tight">{{ $name }}</p>
        @if($count !== null)
        <p class="text-brand-300 text-xs mt-0.5 font-medium">{{ $count }} items</p>
        @endif
    </div>

    {{-- Arrow icon on hover --}}
    <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/0 group-hover:bg-white/20 flex items-center justify-center
                opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-1 group-hover:translate-x-0">
        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
    </div>
</a>
