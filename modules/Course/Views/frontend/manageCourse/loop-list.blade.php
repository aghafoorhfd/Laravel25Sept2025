<div class="mc_content_list">
    <div class="thumb">
        <img class="img-whp" src="{{$row->image_url}}" alt="t1.jpg">
        <div class="overlay">
            <ul class="mb0">
                <li class="list-inline-item">
                    <a class="mcc_edit" href="{{ route("course.vendor.edit",[$row->id]) }}">{{__('Edit')}}</a>
                </li>
                <li class="list-inline-item">
                    <a class="mcc_view" href="{{$row->getDetailUrl()}}">{{__('View')}}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="details">
        <div class="mc_content">
            <p class="subtitle">{{ $row->author->getDisplayName() }}</p>
            <h5 class="title">{{$row->title}}<span class="{{$row->status != 'publish' ? 'style2' : ''}}"><small class="tag">{{ ucfirst($row->status) }}</small></span></h5>
            <p>{!!  substr(strip_tags($row->content),0 , 300). '...' !!}</p>
        </div>
        <div class="mc_footer">
            <?php
            $reviewData = $row->getScoreReview();
            $score_total = $reviewData['score_total'];
            ?>
            <ul class="mc_meta fn-414">
                <li class="list-inline-item"><a href="#"><i class="flaticon-profile"></i></a></li>
                <li class="list-inline-item"><a href="#">{{number_format($row->getStudentCount())}}</a></li>
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
                    <span class="onsale">{{ $row->display_sale_price_admin }}</span>
                    <span class="text-price">{{ $row->display_price_admin }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
