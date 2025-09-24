@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="top_courses">
    <div class="thumb">
        <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
            @if($row->image_url)
                @if(!empty($disable_lazyload))
                    <img src="{{$row->image_url}}" class="img-responsive img-whp" alt="{{$location->name ?? ''}}">
                @else
                    {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive img-whp','alt'=>$row->title]) !!}
                @endif
            @endif
        </a>
        <div class="overlay">
            @if($row->is_featured == "1")
                <div class="tag">
                    {{__("Featured")}}
                </div>
            @endif
            <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
                <div class="icon"><span class="flaticon-like"></span></div>
            </div>
            <a class="tc_preview_course" @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">{{__("Preview Course")}}</a>
        </div>
    </div>
    <div class="details">
        <div class="tc_content">
            <p>{{ $row->author->getDisplayName() }}</p>
            <h5>
                <a @if(!empty($blank)) target="_blank" @endif href="{{$row->getDetailUrl($include_param ?? true)}}">
                    {{Illuminate\Support\Str::words($translation->title, 8, ' ...')}}
                </a>
            </h5>
            @if(setting_item('course_enable_review'))
                <?php
                $reviewData = $row->getScoreReview();
                $score_total = $reviewData['score_total'];
                ?>
                <ul class="tc_review">
                @for( $i = 0 ; $i < 5 ; $i++ )
                    @if($i < $score_total)
                        <li class="list-inline-item"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                    @else
                        <li class="list-inline-item"><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                    @endif
                @endfor
            </ul>
            @endif

        </div>
        <div class="tc_footer">
            @if(setting_item('course_enable_review'))
                @if($reviewData['total_review'])
                    <ul class="tc_meta float-left">
                        <li class="list-inline-item"><a href="javascript:void(0)"><i class="flaticon-profile"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)">{{number_format($row->getStudentCount())}}</a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><i class="flaticon-comment"></i></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)">{{$reviewData['total_review']}}</a></li>
                    </ul>
                @endif
            @endif
            <div class="tc_price float-left">
                <span class="text-price">Rs{{ $row->easypaisa_price }}</span>
            </div>
            <div class="tc_price float-right">
                <span class="onsale">{{ $row->display_sale_price }}</span>
                <span class="text-price">{{ $row->display_price }}</span>
            </div>
        </div>
    </div>
</div>
