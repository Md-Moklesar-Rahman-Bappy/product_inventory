@if ($paginator->hasPages())
    <nav class="pagination-block mt-4" aria-label="Pagination Navigation">
        <ul class="pagination justify-content-center flex-wrap gap-2">

            {{-- First Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}" rel="first">&laquo;&laquo;</a></li>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            {{-- Page Numbers Window --}}
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $start = max($current - 2, 1);
                $end = min($start + 4, $last);
                if ($end - $start < 4) {
                    $start = max($end - 4, 1);
                }
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($last) }}" rel="last">&raquo;&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;&raquo;</span></li>
            @endif

        </ul>
    </nav>
@endif