<div class="flex justify-center mt-6">
    <ul class="flex items-center space-x-4">
        {{-- Previous Button --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <span class="px-4 py-2 text-sm font-semibold text-gray-500 bg-gray-200 rounded-md cursor-not-allowed">
                    Previous
                </span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Previous
                </a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li>
                        <a href="{{ $url }}"
                            class="px-4 py-2 text-sm font-semibold rounded-md {{ $page == $paginator->currentPage() ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-100' }}">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach
            @endif
        @endforeach

        {{-- Next Button --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Next
                </a>
            </li>
        @else
            <li class="disabled">
                <span class="px-4 py-2 text-sm font-semibold text-gray-500 bg-gray-200 rounded-md cursor-not-allowed">
                    Next
                </span>
            </li>
        @endif
    </ul>
</div>
