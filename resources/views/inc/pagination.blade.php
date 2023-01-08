@if ($paginator->hasPages())
    <div class="mt-5">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-primary justify-content-center">
                @if (!$paginator->onFirstPage())
                    {{-- <li class="page-item disabled">
                        <span class="page-link" aria-disabled="true">Previous</span>
                    </li>
                @else --}}
                    <li class="page-item ">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1"
                            aria-disabled="true">Trở lại</a>
                    </li>
                @endif
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @if ($paginator->hasMorePages())
                    <li class="page-item ">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" tabindex="-1"
                            aria-disabled="true">Tiếp</a>
                    </li>
                    {{-- @else
                    <li class="page-item disabled">
                        <span class="page-link" aria-disabled="true">Tiếp</span>
                    </li> --}}
                @endif
            </ul>
        </nav>
    </div>
@endif
<!-- paginator -->
