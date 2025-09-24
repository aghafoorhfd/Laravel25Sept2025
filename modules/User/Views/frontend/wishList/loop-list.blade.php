<?php
$service = $row->getService;
?>
@if(!empty($service))

<div class="mc_content_list">
    <div class="thumb">
        <img class="img-whp" src="{{$service->image_url}}" alt="{{$service->title}}">
        <div class="overlay">
            <ul class="mb0">
                <li class="list-inline-item">
                    <a class="mcc_edit" href="{{$service->getDetailUrl()}}">{{__("View")}}</a>
                </li>
                <li class="list-inline-item">
                    <a class="mcc_view" href="{{ route('user.wishList.remove',['id'=>$service->id , 'type' => $service->type]) }}">{{__("Remove")}}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="details">
        <div class="mc_content">
            <p class="subtitle">{{ $service->author->getDisplayName() }}</p>
            <h5 class="title">{{$service->title}}<span class="{{$service->status != 'publish' ? 'style2' : ''}}"><small class="tag">{{ ucfirst($service->status) }}</small></span></h5>
            <p>{!!  substr(strip_tags($service->content),0 , 300). '...' !!}</p>
        </div>
        <div class="mc_footer">
            <?php
            $reviewData = $service->getScoreReview();
            $score_total = $reviewData['score_total'];
            ?>
            <ul class="mc_meta fn-414">
                <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                <li class="list-inline-item"><a href="#">{{number_format($service->getStudentCount())}}</a></li>
                <li class="list-inline-item"><a href="#"><i class="flaticon-comment"></i></a></li>
                <li class="list-inline-item"><a href="#">{{$reviewData['total_review']}}</a></li>
            </ul>
            <ul class="mc_review fn-414">
                @for( $i = 0 ; $i < 5 ; $i++ )
                    @if($i < $score_total)
                        <li class="list-inline-item"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                    @else
                        <li class="list-inline-item"><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                    @endif
                @endfor
                <li class="list-inline-item"><a href="#">({{$score_total}})</a></li>
                <li class="list-inline-item tc_price fn-414">
                    <span class="onsale">{{ $service->display_sale_price_admin }}</span>
                    <span class="text-price">{{ $service->display_price_admin }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endif
