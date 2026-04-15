@if ($paginator->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 py-3 px-2">
        
        {{-- Per Page Selector --}}
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small">Show</span>
            <form method="GET" action="{{ request()->url() }}" class="d-inline">
                @foreach(request()->except('per_page', 'page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <select name="per_page" class="form-select form-select-sm" style="width: auto; min-width: 70px;" onchange="this.form.submit()">
                    @foreach([10, 25, 50, 100] as $size)
                        <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </form>
            <span class="text-muted small">entries</span>
        </div>

        {{-- Pagination Info --}}
        <div class="text-muted small">
            <span class="fw-semibold">{{ $paginator->firstItem() ?? 0 }}</span>
            <span>to</span>
            <span class="fw-semibold">{{ $paginator->lastItem() ?? 0 }}</span>
            <span>of</span>
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            <span>results</span>
        </div>

        {{-- Pagination Links --}}
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous --}}
                <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                    @if($paginator->onFirstPage())
                        <span class="page-link rounded-start-pill">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @else
                        <a class="page-link rounded-start-pill" href="{{ $paginator->previousPageUrl() }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif
                </li>

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <span class="page-link bg-primary border-primary">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
                    @if($paginator->hasMorePages())
                        <a class="page-link rounded-end-pill" href="{{ $paginator->nextPageUrl() }}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-link rounded-end-pill">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
@endif
