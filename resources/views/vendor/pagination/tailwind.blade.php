@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col sm:flex-row items-center justify-between mt-4 gap-4">

        {{-- Mobile Previous/Next --}}
        <div class="flex justify-between w-full sm:hidden">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-1.5 py-1.5 text-sm text-gray-400 bg-white border border-gray-300 rounded-md cursor-not-allowed dark:bg-gray-800 dark:border-gray-600 dark:text-gray-600">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-1.5 py-1.5 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-gray-400">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-1.5 py-1.5 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:text-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-gray-400">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex items-center px-1.5 py-1.5 text-sm text-gray-400 bg-white border border-gray-300 rounded-md cursor-not-allowed dark:bg-gray-800 dark:border-gray-600 dark:text-gray-600">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop Pagination --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between w-full">
            {{-- Showing Info --}}
            <div>
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            {{-- Page Links --}}
            <div>
                <span class="inline-flex items-center space-x-1 rtl:space-x-reverse shadow-sm rounded-md">
                    {{-- ✅ Smaller Previous Arrow --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center px-1.5 py-1.5 text-sm text-gray-400 bg-white border border-gray-300 rounded-l-md cursor-not-allowed dark:bg-gray-800 dark:border-gray-600" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-1.5 py-1.5 text-sm text-gray-700 bg-white border border-gray-300 rounded-l-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-gray-400 dark:focus:border-blue-700" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="inline-flex items-center px-3 py-2 text-sm text-gray-400 bg-white border border-gray-300 cursor-default dark:bg-gray-800 dark:border-gray-600">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex items-center px-3 py-2 text-sm font-semibold text-white bg-blue-500 border border-blue-500 cursor-default">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 hover:text-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-gray-400">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Arrow --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-2 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-r-md hover:text-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span class="inline-flex items-center px-2 py-2 text-sm text-gray-400 bg-white border border-gray-300 rounded-r-md cursor-not-allowed dark:bg-gray-800 dark:border-gray-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
