@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1.5 font-['Poppins']">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="size-9 rounded-xl border border-slate-200 bg-slate-100 text-slate-400 flex items-center justify-center cursor-not-allowed select-none" aria-disabled="true" aria-label="Sebelumnya">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="m15 18-6-6 6-6"/>
            </svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="size-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-blue-950 hover:border-blue-900 flex items-center justify-center transition shadow-2xs hover:shadow-xs cursor-pointer" aria-label="Sebelumnya">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="m15 18-6-6 6-6"/>
            </svg>
        </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <span class="size-9 flex items-center justify-center text-xs font-semibold text-slate-400 select-none" aria-disabled="true">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page" class="size-9 rounded-xl bg-blue-950 text-white text-xs font-bold flex items-center justify-center shadow-xs select-none">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="size-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-blue-900 text-slate-700 hover:text-blue-950 text-xs font-semibold flex items-center justify-center transition shadow-2xs hover:shadow-xs cursor-pointer">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="size-9 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:text-blue-950 hover:border-blue-900 flex items-center justify-center transition shadow-2xs hover:shadow-xs cursor-pointer" aria-label="Berikutnya">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="m9 18 6-6-6-6"/>
            </svg>
        </a>
    @else
        <span class="size-9 rounded-xl border border-slate-200 bg-slate-100 text-slate-400 flex items-center justify-center cursor-not-allowed select-none" aria-disabled="true" aria-label="Berikutnya">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="m9 18 6-6-6-6"/>
            </svg>
        </span>
    @endif
</nav>
@endif

