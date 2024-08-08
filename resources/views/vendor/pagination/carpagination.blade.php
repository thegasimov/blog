<div class="blog-pagination">
    <nav>
        <ul class="pagination page-item justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="previtem disabled">
                    <a class="page-link" href="#"><i class="fas fa-regular fa-arrow-left me-2"></i> Əvvəlki</a>
                </li>
            @else
                <li class="previtem">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="fas fa-regular fa-arrow-left me-2"></i> Əvvəlki</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            <li class="justify-content-center pagination-center">
                <div class="page-group">
                    <ul>
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="page-item disabled">
                                    <a class="page-link">{{ $element }}</a>
                                </li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li class="page-item">
                                            <a class="active page-link" href="#">{{ $page }} <span class="visually-hidden">(current)</span></a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                </div>
            </li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="nextlink">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Növbəti <i class="fas fa-regular fa-arrow-right ms-2"></i></a>
                </li>
            @else
                <li class="nextlink disabled">
                    <a class="page-link" href="#">Növbəti <i class="fas fa-regular fa-arrow-right ms-2"></i></a>
                </li>
            @endif
        </ul>
    </nav>
</div>
