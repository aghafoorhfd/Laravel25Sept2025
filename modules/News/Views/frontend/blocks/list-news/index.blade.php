@php
    $loop_slide = count($rows);
    $loop_fix = false;
    if(count($rows) > 4){
        $loop_slide = count($rows) - 4;
    }else{
        $loop_fix = true;
    }
@endphp
<section class="our-blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h3 class="mt0">{{@$title}}</h3>
                    <p>{{@$desc}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @if(empty($loop_fix))
            <div class="col-lg-6 col-xl-6">
                @if($loop_slide == 1)
                    <!-- case count = 5 -->
                    @php($row = $rows[0])
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            @include('News::frontend.blocks.list-news.loop')
                        </div>
                    </div>
                @else
                <div class="blog_slider_home1">
                    @php($i = 0)
                    @foreach($rows as $row)
                        @if($i < $loop_slide)
                            @include('News::frontend.blocks.list-news.loop-slide')
                        @else
                            @break
                        @endif
                        @php($i++)
                    @endforeach
                </div>
                @endif
            </div>
            @endif
            <div class="@if(count($rows) > 2) col-lg-6 col-xl-6 @else col-lg-12 col-xl-12 @endif">
                <div class="row">
                @php($j = !empty($loop_fix) ? $loop_slide : 0)
                @foreach($rows as $row)
                    @if($j >= $loop_slide)
                        <div class="@if(count($rows) > 2) col-lg-6 col-xl-6 @else col-lg-12 col-xl-12 @endif">
                            @include('News::frontend.blocks.list-news.loop')
                        </div>
                    @endif
                    @php($j++)
                @endforeach
                </div>
            </div>
        </div>
        <div class="row mt50">
            <div class="col-lg-12">
                <div class="read_more_home text-center">
                    <h4><a href="{{!empty($link) ? $link : 'javascript:void(0)'}}">{{@$text_btn}}<span class="flaticon-right-arrow pl10"></span></a></h4>
                </div>
            </div>
        </div>
    </div>
</section>
