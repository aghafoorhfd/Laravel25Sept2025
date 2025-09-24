<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Page Search")}}</h3>
        <p class="form-group-desc">{{__('Config page search of your website')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("General Options")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Title Page")}}</label>
                    <div class="form-controls">
                        <input type="text" name="course_page_search_title" value="{{ setting_item_with_lang('course_page_search_title',request()->query('lang')) }}" class="form-control">
                    </div>
                </div>
                @if(is_default_lang())
                <div class="form-group">
                    <label class="" >{{__("Banner Page")}}</label>
                    <div class="form-controls form-group-image">
                        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('course_page_search_banner',$settings['course_page_search_banner'] ?? "") !!}
                    </div>
                </div>

                @endif
            </div>
        </div>
        <div class="panel">
            <div class="panel-title"><strong>{{__("SEO Options")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#seo_1">{{__("General Options")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#seo_2">{{__("Share Facebook")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#seo_3">{{__("Share Twitter")}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" >
                        <div class="tab-pane active" id="seo_1">
                            <div class="form-group" >
                                <label class="control-label">{{__("Seo Title")}}</label>
                                <input type="text" name="course_page_list_seo_title" class="form-control" placeholder="{{__("Enter title...")}}" value="{{ setting_item_with_lang('course_page_list_seo_title',request()->query('lang'))}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Seo Description")}}</label>
                                <input type="text" name="course_page_list_seo_desc" class="form-control" placeholder="{{__("Enter description...")}}" value="{{setting_item_with_lang('course_page_list_seo_desc',request()->query('lang'))}}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Featured Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('course_page_list_seo_image', $settings['course_page_list_seo_image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        @php
                            $seo_share = json_decode(setting_item_with_lang('course_page_list_seo_desc',request()->query('lang'),'[]'),true);
                        @endphp
                        <div class="tab-pane" id="seo_2">
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Title")}}</label>
                                <input type="text" name="course_page_list_seo_share[facebook][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['facebook']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Description")}}</label>
                                <input type="text" name="course_page_list_seo_share[facebook][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['facebook']['desc'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Facebook Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('course_page_list_seo_share[facebook][image]',$seo_share['facebook']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="seo_3">
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Title")}}</label>
                                <input type="text" name="course_page_list_seo_share[twitter][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Description")}}</label>
                                <input type="text" name="course_page_list_seo_share[twitter][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                                <div class="form-group form-group-image">
                                    <label class="control-label">{{__("Twitter Image")}}</label>
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('course_page_list_seo_share[twitter][image]', $seo_share['twitter']['image'] ?? "" ) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(is_default_lang())
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Review Options")}}</h3>
        <p class="form-group-desc">{{__('Config review for course')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Enable review system for Course?")}}</label>
                    <div class="form-controls">
                        <label><input type="checkbox" name="course_enable_review" value="1" @if(!empty($settings['course_enable_review'])) checked @endif /> {{__("Yes, please enable it")}} </label>
                        <br>
                        <small class="form-text text-muted">{{__("Turn on the mode for reviewing course")}}</small>
                    </div>
                </div>
                <div class="form-group" data-condition="course_enable_review:is(1)">
                    <label class="" >{{__("Customer must book a course before writing a review?")}}</label>
                    <div class="form-controls">
                        <label><input type="checkbox" name="course_enable_review_after_booking" value="1"  @if(!empty($settings['course_enable_review_after_booking'])) checked @endif /> {{__("Yes please")}} </label>
                        <br>
                        <small class="form-text text-muted">{{__("ON: Only post a review after booking - Off: Post review without booking")}}</small>
                    </div>
                </div>
                <div class="form-group" data-condition="course_enable_review:is(1),course_enable_review_after_booking:is(1)">
                    <label class="" >{{__("Allow Review after making Completed Booking?")}}</label>
                    <div class="form-controls">
                        @php
                            $status = config('booking.statuses');
                            $settings_status = !empty($settings['course_allow_review_after_making_completed_booking']) ? json_decode($settings['course_allow_review_after_making_completed_booking']) : [];
                        @endphp
                        <div class="row">
                            @foreach($status as $item)
                                <div class="col-md-4">
                                    <label><input type="checkbox" name="course_allow_review_after_making_completed_booking[]" @if(in_array($item,$settings_status)) checked @endif value="{{$item}}"  /> {{booking_status_to_text($item)}} </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="form-text text-muted">{{__("Pick to the Booking Status, that allows reviews after booking")}}</small>
                    </div>
                </div>
                <div class="form-group" data-condition="course_enable_review:is(1)">
                    <label class="" >{{__("Does the review need approved by admin?")}}</label>
                    <div class="form-controls">
                        <label><input type="checkbox" name="course_review_approved" value="1"  @if(!empty($settings['course_review_approved'])) checked @endif /> {{__("Yes please")}} </label>
                        <br>
                        <small class="form-text text-muted">{{__("ON: Review must be approved by admin - OFF: Review is automatically approved")}}</small>
                    </div>
                </div>
                <div class="form-group" data-condition="course_enable_review:is(1)">
                    <label class="" >{{__("Review number per page")}}</label>
                    <div class="form-controls">
                        <input type="number" class="form-control" name="course_review_number_per_page" value="{{ $settings['course_review_number_per_page'] ?? 5 }}" />
                        <small class="form-text text-muted">{{__("Break comments into pages")}}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif



@if(is_default_lang())
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <h3 class="form-group-title">{{__("Vendor Options")}}</h3>
            <p class="form-group-desc">{{__('Vendor config for course')}}</p>
        </div>
        <div class="col-sm-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="" >{{__("Course create by vendor must be approved by admin?")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="course_vendor_create_service_must_approved_by_admin" value="1" @if(!empty($settings['course_vendor_create_service_must_approved_by_admin'])) checked @endif /> {{__("Yes please")}} </label>
                            <br>
                            <small class="form-text text-muted">{{__("ON: When vendor posts a service, it needs to be approved by administrator")}}</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="" >{{__("Allow vendor can change their booking status")}}</label>
                        <div class="form-controls">
                            <label><input type="checkbox" name="course_allow_vendor_can_change_their_booking_status" value="1" @if(!empty($settings['course_allow_vendor_can_change_their_booking_status'])) checked @endif /> {{__("Yes please")}} </label>
                            <br>
                            <small class="form-text text-muted">{{__("ON: Vendor can change their booking status")}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if(is_default_lang())
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Disable course module?")}}</h3>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("Disable course module")}}</strong></div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="form-controls">
                    <label><input type="checkbox" name="course_disable" value="1" @if(setting_item('course_disable')) checked @endif > {{__('Yes, please disable it')}}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif
