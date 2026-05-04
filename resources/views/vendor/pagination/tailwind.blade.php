@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-7">

    {{-- Result count --}}
    <p class="text-sm text-neutral-500 order-2 sm:order-1">
        {!! __('Showing') !!}
        <span class="font-semibold text-neutral-800">{{ $paginator->firstItem() }}</span>
        {!! __('to') !!}
        <span class="font-semibold text-neutral-800">{{ $paginator->lastItem() }}</span>
        {!! __('of') !!}
        <span class="font-semibold text-neutral-800">{{ $paginator->total() }}</span>
        {!! __('results') !!}
    </p>

    {{-- Page buttons --}}
    <div class="flex items-center gap-1 order-1 sm:order-2">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-neutral-200 bg-white text-neutral-300 cursor-not-allowed select-none text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               rel="prev"
               aria-label="{{ __('pagination.previous') }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-neutral-200 bg-white text-neutral-600 hover:border-brand-400 hover:text-brand-600 hover:bg-brand-50 transition-base text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            {{-- Dots / Ellipsis --}}
            @if (is_string($element))
                <span class="inline-flex items-center justify-center w-9 h-9 text-neutral-400 text-sm select-none">
                    {{ $element }}
                </span>
            @endif

            {{-- Page number links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        {{-- Active page --}}
                        <span aria-current="page"
                              class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-semibold text-white shadow-sm select-none"
                              style="background-color: var(--color-brand-500);">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                           class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-neutral-200 bg-white text-neutral-600 hover:border-brand-400 hover:text-brand-600 hover:bg-brand-50 transition-base text-sm shadow-sm">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               rel="next"
               aria-label="{{ __('pagination.next') }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-neutral-200 bg-white text-neutral-600 hover:border-brand-400 hover:text-brand-600 hover:bg-brand-50 transition-base text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-neutral-200 bg-white text-neutral-300 cursor-not-allowed select-none text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        @endif

    </div>
</nav>
@endif
