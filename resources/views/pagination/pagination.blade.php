<style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 2rem;
    }

    .pagination__link {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        height: 2.5rem;
        min-width: 2.5rem;
        margin: 0.25rem;
        padding: 0.5rem;
        color: #333;
        text-decoration: none;
        background-color: #f1f1f1;
        border: none;
        border-radius: 0.25rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }

    .pagination__link:hover {
        background-color: #ddd;
    }

    .pagination__link--active {
        color: white;
        background-color: #3490dc;
    }

    .pagination__link--disabled {
        color: #999;
        cursor: not-allowed;
    }

    .pagination__dots {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        height: 2.5rem;
        min-width: 2.5rem;
        margin: 0.25rem;
        padding: 0.5rem;
        color: #999;
        font-size: 1rem;
        font-weight: 600;
    }
</style>

@if ($paginator->hasPages())
<nav class="pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <span class="pagination__link pagination__link--disabled" aria-disabled="true"
        aria-label="@lang('pagination.previous')">
        <span aria-hidden="true">&laquo;</span>
    </span>
    @else
    <a class="pagination__link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
        aria-label="@lang('pagination.previous')">
        <span aria-hidden="true">&laquo;</span>
    </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <span class="pagination__dots">{{ $element }}</span>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span class="pagination__link pagination__link--active" aria-current="page">{{ $page }}</span>
    @else
    <a class="pagination__link" href="{{ $url }}">{{ $page }}</a>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a class="pagination__link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
        <span aria-hidden="true">&raquo;</span>
    </a>
    @else
    <span class="pagination__link pagination__link--disabled" aria-disabled="true"
        aria-label="@lang('pagination.next')">
        <span aria-hidden="true">&raquo;</span>
    </span>
    @endif
</nav>
@endif
