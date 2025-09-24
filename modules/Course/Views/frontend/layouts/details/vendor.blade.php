<?php
$vendor = $row->author;
?>

<div class="container">
    <div class="row">
        <div class="col-xl-9">
            <div class="breadcrumb_content">
                <div class="cs_row_one csv2">
                    <div class="cs_ins_container">
                        <div class="cs_instructor">
                            <ul class="cs_instrct_list float-left mb0">
                                <li class="list-inline-item">
                                    @if($avatar_url = $vendor->getAvatarUrl())
                                        <img class="thumb" src="{{$avatar_url}}" alt="{{$vendor->getDisplayName()}}">
                                    @else
                                        <span class="avatar-text">{{ucfirst($vendor->getDisplayName()[0])}}</span>
                                    @endif
                                </li>
                                <li class="list-inline-item">
                                    <a class="author-link text-white" href="{{route('user.profile',['id'=>$vendor->id])}}" target="_blank">
                                        {{$vendor->getDisplayName()}}
                                    </a>
                                    @if($vendor->is_verified)
                                        <img data-toggle="tooltip" data-placement="top" src="{{asset('icon/ico-vefified-1.svg')}}" title="{{__("Verified")}}" alt="ico-vefified-1">
                                    @else
                                        <img data-toggle="tooltip" data-placement="top" src="{{asset('icon/ico-not-vefified-1.svg')}}" title="{{__("Not verified")}}" alt="ico-vefified-1">
                                    @endif
                                </li>
                                <li class="list-inline-item"><a class="color-white" href="#">Last updated {{date('m/Y', strtotime(empty($row->updated_at) ? $row->created_at : $row->updated_at))}}</a></li>
                            </ul>
                            <ul class="cs_watch_list float-right mb0">
                                <li class="list-inline-item">
                                    <div class="service-wishlist {{$row->isWishList()}}" data-id="{{$row->id}}" data-type="{{$row->type}}">
                                        <div class="icon"><span class="flaticon-like"></span> {{__('Add to Wishlist')}}</div>
                                    </div>
                                </li>
                                <li class="list-inline-item">
                                    <div class="social-share">
                                        <span class="flaticon-share"> {{__('Share')}}</span>
                                        <ul class="share-wrapper">
                                            <li>
                                                <a class="facebook"
                                                   href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}"
                                                   target="_blank" rel="noopener" original-title="{{__("Facebook")}}">
                                                    <i class="fa fa-facebook fa-lg"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="twitter"
                                                   href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}"
                                                   target="_blank" rel="noopener" original-title="{{__("Twitter")}}">
                                                    <i class="fa fa-twitter fa-lg"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="cs_title color-white">{{$translation->title}}</h3>
                        @if(setting_item('course_enable_review') and $review_score)
                        <ul class="cs_review_seller">
                            <li class="list-inline-item">@if($row->is_featured == "1")<a class="color-white" href="#"><span>{{__('Best Seller')}}</span></a>@endif</li>
                            @for( $i = 0 ; $i < 5 ; $i++ )
                                @if($i < $review_score['score_total'])
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                @else
                                    <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                @endif
                            @endfor
                            <li class="list-inline-item"><a class="color-white" href="#">{{$review_score['score_total']}}</a></li>
                        </ul>
                        <ul class="cs_review_enroll">
                            <li class="list-inline-item"><a class="color-white" href="#"><span class="flaticon-profile"></span> {{__(":number students enrolled",['number'=> number_format($row->getStudentCount())])}} </a></li>
                            <li class="list-inline-item"><a class="color-white" href="#"><span class="flaticon-comment"></span>{{__(":number Reviews",['number'=>$review_score['total_review']])}}</a></li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
