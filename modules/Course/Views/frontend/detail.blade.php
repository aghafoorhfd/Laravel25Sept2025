@extends('layouts.app')
@section('content')
    <div class="bravo_detail_course">
        @php $review_score = $row->review_data @endphp

        <!-- Inner Page Breadcrumb -->

        <section class="inner_page_breadcrumb csv2"
            @if ($row->banner_image_id) style="background-image: url('{{ $row->getBannerImageUrlAttribute('full') }}')" @endif>
            @include('Course::frontend.layouts.details.vendor')
        </section>

        <!-- Our Team Members -->
        <section class="course-single2 pb40">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-8 col-xl-9">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="courses_single_container">
                                    <div class="cs_row_one">
                                        <div class="cs_ins_container">
                                            <div class="courses_big_thumb">
                                                <div class="thumb">
                                                    @if (!empty($row->video))
                                                        <iframe class="iframe_video"
                                                            src="{{ getYoutubeEmbedUrl($row->video) }}" frameborder="0"
                                                            allowfullscreen></iframe>
                                                    @else
                                                        <img src="{{ $row->getBannerImageUrlAttribute('full') }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cs_rwo_tabs csv2">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="Overview-tab" data-toggle="tab"
                                                    href="#Overview" role="tab" aria-controls="Overview"
                                                    aria-selected="true">{{ __('Overview') }}</a>
                                            </li>
                                            @if ($is_paid)
                                                <li class="nav-item">
                                                    <a class="nav-link" id="course-tab" data-toggle="tab" href="#course"
                                                        role="tab" aria-controls="course"
                                                        aria-selected="false">{{ __('Course Content') }}</a>
                                                </li>
                                            @endif
                                            <li class="nav-item">
                                                <a class="nav-link" id="instructor-tab" data-toggle="tab" href="#instructor"
                                                    role="tab" aria-controls="instructor"
                                                    aria-selected="false">{{ __('Instructor') }}</a>
                                            </li>
                                            @if (setting_item('course_enable_review'))
                                                <li class="nav-item">
                                                    <a class="nav-link" id="review-tab" data-toggle="tab" href="#review"
                                                        role="tab" aria-controls="review"
                                                        aria-selected="false">{{ __('Review') }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="Overview" role="tabpanel"
                                                aria-labelledby="Overview-tab">
                                                <div class="cs_row_two csv2">
                                                    <div class="cs_overview">
                                                        <div>
                                                            @if($row->pdfFile)
                                                            <a href="{{ asset('storage/' . $row->pdfFile->file_path) }}" class="btn btn-primary float-right" target="_blank">View PDF</a>
                                                            @endif
                                                        </div>
                                                        <h4 class="title">{{ __('Overview') }}</h4>
                                                        {!! clean($row->content) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="course" role="tabpanel"
                                                aria-labelledby="review-tab">
                                                @include('Course::frontend.layouts.details.course-content')
                                            </div>
                                            <div class="tab-pane fade" id="instructor" role="tabpanel"
                                                aria-labelledby="review-tab">
                                                @include('Course::frontend.layouts.details.course-instructor')
                                            </div>
                                            @if (setting_item('course_enable_review'))
                                                <div class="tab-pane fade" id="review" role="tabpanel"
                                                    aria-labelledby="review-tab">
                                                    @include('Course::frontend.layouts.details.course-review')
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @include('Course::frontend.layouts.details.course-related')
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="instructor_pricing_widget csv2">
                            <div class="price">
                                <span>{{ __('Price') }}</span>
                                {{ $row->display_price }}
                                <small>{{ $row->display_sale_price }}</small>
                                <br />
                                <span>{{ __('Easypaisa Price') }}</span>
                                Rs{{ $row->easypaisa_price }}
                            </div>
                            @if (!empty($is_student->active))
                                @if ($is_student->active)
                                    <a href="{{ route('course.study', ['slug' => $row->slug]) }}"
                                        class="cart_btnss_white">{{ __('Start now') }}</a>
                                @else
                                    <p class="alert alert-warning">{{ __('Please wait for approval') }}</p>
                                @endif
                            @else
                                <a href="#" class="cart_btnss bravo_add_to_cart"
                                    data-product='{!! json_encode($row->getBookingData()) !!}'>{{ __('Add To Cart') }}</a>
                                <a href="#" class="cart_btnss_white bravo_add_to_cart"
                                    data-product='{!! json_encode($row->getBookingData(['buy_now' => 1])) !!}'>{{ __('Buy Now') }}</a>
                            @endif

                            {!! clean($row->short_desc) !!}
                        </div>
                        <div class="feature_course_widget csv1">
                            <ul class="list-group">
                                <h4 class="title">{{ __('Course Features') }}</h4>
                                <li class="d-flex justify-content-between align-items-center">
                                    {{ __('Lectures') }} <span class="float-right">{{ count($section_list) }}</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    {{ __('Duration') }} <span
                                        class="float-right">{{ convertToHoursMinutes($row->duration, '%02d ' . __('hours') . ' %02d ' . __('minutes')) }}</span>
                                </li>
                                @include('Course::frontend.layouts.details.course-attributes')
                            </ul>
                        </div>
                        <div class="blog_tag_widget csv1">
                            <h4 class="title">{{ __('Tags') }}</h4>
                            <ul class="tag_list">
                                @if (!empty($tags))
                                    @foreach ($tags as $tag)
                                        <li class="list-inline-item"><a href="#">{{ $tag->name }}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
