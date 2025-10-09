@if ($paginator->hasPages())
    <nav class="pagination-block mt-4" aria-label="Pagination Navigation">
        <ul class="pagination justify-content-center flex-wrap gap-2">
            {{-- Previous Arrow --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}"
                aria-disabled="{{ $paginator->onFirstPage() ? 'true' : 'false' }}"
                aria-label="{{ __('pagination.previous') }}">
                @if ($paginator->onFirstPage())
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-angle-left fa-sm text-muted"></i>
                    </span>
                @else
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-angle-left fa-sm"></i>
                    </a>
                @endif
            </li>

            {{-- Page Numbers --}}
            @foreach ($paginator->links()->elements[0] as $page => $url)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}"
                    aria-current="{{ $page == $paginator->currentPage() ? 'page' : '' }}">
                    @if ($page == $paginator->currentPage())
                        <span class="page-link">{{ $page }}</span>
                    @else
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    @endif
                </li>
            @endforeach

            {{-- Next Arrow --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}"
                aria-disabled="{{ $paginator->hasMorePages() ? 'false' : 'true' }}"
                aria-label="{{ __('pagination.next') }}">
                @if ($paginator->hasMorePages())
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="fas fa-angle-right fa-sm"></i>
                    </a>
                @else
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-angle-right fa-sm text-muted"></i>
                    </span>
                @endif
            </li>
        </ul>
    </nav>
@endif
