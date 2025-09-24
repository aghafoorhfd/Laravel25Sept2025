@if(setting_item("course_enable_review"))
    <div class="cs_row_five csv2">
        <div class="student_feedback_container">
            <h4 class="aii_title">{{ __('Student feedback') }}</h4>
            <div class="s_feeback_content">
                @if($review_score['rate_score'])
                    @foreach($review_score['rate_score'] as $item)
                        <ul class="skills">
                            <li class="list-inline-item">{{$item['title']}}</li>
                            <li class="list-inline-item progressbar" data-width="{{$item['percent']}}" data-target="100">{{$item['total']}}</li>
                        </ul>
                    @endforeach
                @endif
            </div>
            <div class="aii_average_review text-center">
                <div class="av_content">
                    <h2>{{$review_score['score_total']}}</h2>
                    <ul class="aii_rive_list mb0">
                        @for( $i = 0 ; $i < 5 ; $i++ )
                            @if($i < $review_score['score_total'])
                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                            @else
                                <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                            @endif
                        @endfor
                    </ul>
                    <p>{{ __('Course Rating') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="cs_row_six csv2">
        <div class="sfeedbacks">
            <div class="mbp_pagination_comments">
                @if($review_list)
                    @foreach($review_list as $item)
                        @php($userInfo = $item->author)
                        <div class="mbp_first media csv1 pb-5">
                            @if($avatar_url = $userInfo->getAvatarUrl())
                                <img class="avatar mr-3 " src="{{$avatar_url}}" alt="{{$userInfo->getDisplayName()}}">
                            @else
                                <span class="avatar-text mr-3">{{ucfirst($userInfo->getDisplayName()[0])}}</span>
                            @endif
                            <div class="media-body">
                                <h4 class="sub_title mt-0">{{$userInfo->getDisplayName()}}
                                    <span class="sspd_review float-right">
                                        @if($item->rate_number)
                                            <ul>
                                                @for( $i = 0 ; $i < 5 ; $i++ )
                                                    @if($i < $item->rate_number)
                                                        <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    @else
                                                        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                                    @endif
                                                @endfor
                                            </ul>
                                        @endif
                                    </span>
                                </h4>
                                <div class="sspd_postdate fz14" >{{display_datetime($item->created_at)}}</div>
                                <div class="fz15 mt20">{{$item->content}}</div>

                            </div>
                        </div>
                        <div class="custom_hr my-3"></div>
                    @endforeach
                @endif

                <div class="text-center mt50">
                    <div class="review-pag-wrapper">
                        @if($review_list->total() > 0)
                            <div class="bravo-pagination">
                                {{$review_list->appends(request()->query())->fragment('review-list')->links()}}
                            </div>
                            <div class="review-pag-text">
                                {{ __("Showing :from - :to of :total total",["from"=>$review_list->firstItem(),"to"=>$review_list->lastItem(),"total"=>$review_list->total()]) }}
                            </div>
                        @else
                            <div class="review-pag-text">{{__("No Review")}}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($row->check_enable_review_after_booking() and Auth::id())

        <form action="{{ url(app_get_locale()."/review") }}" class="needs-validation sfeedbacks_form" novalidate method="post">
            @csrf
            <div class="cs_row_seven csv2">
                <div class="sfeedbacks ">
                    <div class="mbp_comment_form style2 pb0">
                        @include('admin.message')
                        <h4>{{__("Add Reviews & Rate")}}</h4>
                        <ul>
                            <li class="list-inline-item pr15"><p>{{__('What is it like to Course?')}}</p></li>
                            <li class="list-inline-item">
                                <input class="review_stats" type="hidden" name="review_rate">
                                <span class="sspd_review">
                                    <i class="fa fa-star-o fz18"></i>
                                    <i class="fa fa-star-o fz18"></i>
                                    <i class="fa fa-star-o fz18"></i>
                                    <i class="fa fa-star-o fz18"></i>
                                    <i class="fa fa-star-o fz18"></i>
                                </span>
                            </li>
                        </ul>

                        <div class="form-group">
                            <label for="exampleInputName1">{{__("Review Title")}}</label>
                            <input type="text" required class="form-control" id="review_title" aria-describedby="textHelp" name="review_title" placeholder="{{__("Title")}}">
                            <div class="invalid-feedback">{{__('Review title is required')}}</div>
                        </div>
                        <div class="form-group">
                            <label for="review_content">{{__("Review content")}}</label>
                            <textarea class="form-control" required id="review_content" name="review_content" rows="6" minlength="10"></textarea>
                            <div class="invalid-feedback">
                                {{__('Review content has at least 10 character')}}
                            </div>
                        </div>
                        <div class="comments_form">
                            <input type="hidden" name="review_service_id" value="{{$row->id}}">
                            <input type="hidden" name="review_service_type" value="course">
                            <button type="submit" class="btn btn-thm">{{__("Submit Review")}} <span class="flaticon-right-arrow-1"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

    @if(!Auth::id())
    <div class="review-message">
        {!!  __("You must <a href='#login' data-toggle='modal' data-target='#login'>log in</a> to write review") !!}
    </div>
@endif

@endif
