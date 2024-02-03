<section class="user_pagination">
    <div class="pagination_links">
        @if ($paginator->hasPages())
            <nav class="nav">
                <ul class="list">
                    @if ($paginator->onFirstPage())
                        <li class="li_prev disabled" aria-disabled="true"><img src="{{ asset('img/Stars/left.png') }}"
                                alt="" srcset=""></li>
                    @else
                        <li class="li_prev"><a href="{{ $paginator->previousPageUrl() }}"><img
                                    src="{{ asset('img/Stars/left.png') }}" alt="" srcset=""></a></li>
                    @endif
                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    {{-- <li class="active" aria-current="page"><span>{{ $page }}</span></li> --}}
                                    <li class="li_{{ $page }}_active"><a href="#">{{ $page }}</a></li>
                                @else
                                    <li class="li_{{ $page }}"><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li class="li_next"><a href="{{ $paginator->nextPageUrl() }}"><img
                                    src="{{ asset('img/Stars/right.png') }}" alt="no" srcset=""></a></li>
                    @else
                        <li class="li_next disabled" aria-disabled="true"><img src="{{ asset('img/Stars/right.png') }}"
                                alt="no" srcset=""></li>
                    @endif
                </ul>
            </nav>
        @endif
    </div>
</section>
