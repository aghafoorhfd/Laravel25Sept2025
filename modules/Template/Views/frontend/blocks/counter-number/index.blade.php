@if($list_item)
    <section class="about-section">
        <div class="container">
            <div class="row mb60">
                <div class="col-lg-12 text-center">
                    <ul class="funfact_two_details">
                        @foreach($list_item as $k=>$item)
                            <li class="list-inline-item">
                                <div class="funfact_two text-left">
                                    <div class="details">
                                        <h5>{{$item['title']}}</h5>
                                        <div class="timer">{{ number_format($item['counter'])}}</div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endif
