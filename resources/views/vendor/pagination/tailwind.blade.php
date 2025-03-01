@if ($paginator->hasPages())
    <ul class="pagination flex justify-end mx-4 mt-4 gap-4 list-reset text-white font-bold">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <span class="button border border-brown py-2 px-4 rounded opacity-50 cursor-not-allowed flex-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm text-center">@lang('pagination.previous')</span>
            </li>
        @else
            <li class="">
                <a class="button border border-brown py-2 px-4 rounded opacity-85 flex-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
            </li>
        @endif
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="page-item  disabled" aria-disabled="true">
                <span class="page-link button border border-brown py-2 px-4 rounded opacity-50 cursor-not-allowed flex-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm text-center">{{ $element }}</span>
            </li>
        @endif
        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item  active" aria-current="page">
                        <span class="page-link button border border-brown py-2 px-4 rounded opacity-50 flex-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item ">
                        <a class="page-link button border border-brown py-2 px-4 rounded opacity-85 flex-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm px-3 py-2 text-center" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach
        @endif
    @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="">
                <a class="button border border-brown py-2 px-4 rounded opacity-85 flex-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm text-center" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
            </li>
        @else
            <li class="disabled">
                <span class="button  border border-brown py-2 px-4 rounded opacity-50 cursor-not-allowed flex-1 text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium inline-flex items-center justify-center rounded-lg text-sm text-center">@lang('pagination.next')</span>
            </li>
        @endif
    </ul>
@endif
