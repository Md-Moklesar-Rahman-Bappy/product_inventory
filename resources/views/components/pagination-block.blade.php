@if ($paginator->hasPages())
    <nav class="pagination-block mt-4" aria-label="Pagination Navigation">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            
            {{-- Per Page Selector --}}
            <div class="d-flex align-items-center">
                <label for="perPage" class="me-2 small text-muted">Show:</label>
                <select id="perPage" onchange="window.location.href=updateQueryStringParameter(this.value)" 
                        class="form-select form-select-sm" style="width: auto;">
                    @foreach([10, 25, 50, 100] as $perPage)
                        <option value="{{ $perPage }}" {{ request('per_page', 10) == $perPage ? 'selected' : '' }}>
                            {{ $perPage }}
                        </option>
                    @endforeach
                </select>
            </div>

            <ul class="pagination justify-content-center flex-wrap gap-2 mb-0">

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
        </div>
    </nav>

    <script>
        function updateQueryStringParameter(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            return url.toString();
        }
    </script>
@endif