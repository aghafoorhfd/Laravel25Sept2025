@if ($paginator->hasPages())
    <div class="col-lg-12">
        <div class="mbp_pagination">
            <ul class="page_navigation">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true"> <span class="flaticon-left-arrow"></span> {{__("Prev")}}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1" rel="prev"> <span class="flaticon-left-arrow"></span>{{__("Prev")}} </a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" >{{__("Next")}} <span class="flaticon-right-arrow-1"></span></a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">{{__("Next")}} <span class="flaticon-right-arrow-1"></span></span>
                    </li>

                @endif
            </ul>
        </div>
    </div>

@endif
