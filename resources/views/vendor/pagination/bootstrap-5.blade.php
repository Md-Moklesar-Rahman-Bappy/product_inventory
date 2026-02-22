@if ($paginator->hasPages())
    <nav class="d-flex flex-column align-items-center gap-3 mt-4" aria-label="Pagination Navigation">

        {{-- Mobile View --}}
        <div class="d-sm-none">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous --}}
                <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                    @if ($paginator->onFirstPage())
                        <span class="page-link rounded-pill shadow-sm px-3 py-1" aria-hidden="true">
                            <i class="fa fa-angle-left me-1"></i> Previous
                        </span>
                    @else
                        <a class="page-link rounded-pill shadow-sm px-3 py-1" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            <i class="fa fa-angle-left me-1"></i> Previous
                        </a>
                    @endif
                </li>

                {{-- Next --}}
                <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                    @if ($paginator->hasMorePages())
                        <a class="page-link rounded-pill shadow-sm px-3 py-1" href="{{ $paginator->nextPageUrl() }}" rel="next">
                            Next <i class="fa fa-angle-right ms-1"></i>
                        </a>
                    @else
                        <span class="page-link rounded-pill shadow-sm px-3 py-1" aria-hidden="true">
                            Next <i class="fa fa-angle-right ms-1"></i>
                        </span>
                    @endif
                </li>
            </ul>
        </div>

        {{-- Page Summary --}}
        <div>
            <span class="badge bg-light text-dark shadow-sm px-3 py-2 rounded-pill">
                Showing <strong>{{ $paginator->firstItem() }}</strong>
                to <strong>{{ $paginator->lastItem() }}</strong>
                of <strong>{{ $paginator->total() }}</strong> results
            </span>
        </div>

        {{-- Desktop View --}}
        <div class="d-none d-sm-flex justify-content-center">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous --}}
                <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                    @if ($paginator->onFirstPage())
                        <span class="page-link rounded-pill shadow-sm px-3 py-1" aria-hidden="true">&lsaquo;</span>
                    @else
                        <a class="page-link rounded-pill shadow-sm px-3 py-1" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                    @endif
                </li>

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                                @if ($page == $paginator->currentPage())
                                    <span class="page-link rounded-pill shadow-sm px-3 py-1" aria-current="page">{{ $page }}</span>
                                @else
                                    <a class="page-link rounded-pill shadow-sm px-3 py-1" href="{{ $url }}">{{ $page }}</a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                    @if ($paginator->hasMorePages())
                        <a class="page-link rounded-pill shadow-sm px-3 py-1" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
                    @else
                        <span class="page-link rounded-pill shadow-sm px-3 py-1" aria-hidden="true">&rsaquo;</span>
                    @endif
                </li>
            </ul>
        </div>

        {{-- Page Info --}}
        <div class="text-muted small">
            <i class="fa fa-file-alt me-1"></i>
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </div>

        {{-- Per Page Selector --}}
        <form method="GET" action="{{ request()->url() }}" class="d-inline-flex align-items-center gap-2">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <label for="per_page" class="fw-semibold text-muted mb-0">Show:</label>
            <select name="per_page" id="per_page" class="form-select form-select-sm w-auto shadow-sm rounded-pill"
                onchange="this.form.submit()">
                @foreach([10, 25, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
            <span class="text-muted">per page</span>
        </form>

    </nav>
@endif
