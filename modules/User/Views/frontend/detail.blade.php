@extends('layouts.app')
@section('content')
    <div class="bravo_detail_course">
        @php $review_score = $row->review_data @endphp

        <!-- Inner Page Breadcrumb -->

        <section class="our-team">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="instructor_personal_infor">
                                <div class="instructor_thumb text-center">
                                    @if($avatar_url = $row->getAvatarUrl())
                                        <img class="img-fluid " src="{{$avatar_url}}" alt="{{$row->getDisplayName()}}">
                                    @else
                                        <span class="img-fluid avatar-text">{{ucfirst($row->getDisplayName()[0])}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-8 col-xl-9">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="instructor_personal_infor">
                                        {!! clean($row->bio) !!}

                                        @if(!empty($row->education))
                                            <h4>{{__('My Education')}}</h4>
                                            <div class="my_resume_eduarea">
                                                @php  $i = 1; @endphp
                                                @foreach(json_decode(@$row->education) as $oneEducation)
                                                    <div class="content style{{$i}}">
                                                        <div class="circle"></div>
                                                        <h4 class="edu_stats">{{$oneEducation->location}} <small>{{$oneEducation->from}} - {{$oneEducation->to}}</small></h4>
                                                        <p class="edu_center">{{$oneEducation->reward}}</p>
                                                    </div>
                                                    @php  $i++; if($i == 4) $i = 1; @endphp
                                                @endforeach
                                            </div>
                                        @endif

                                        @if(!empty($row->experience))
                                            <h4>{{__('My Experience')}}</h4>
                                            <div class="my_resume_eduarea">
                                                @php  $j = 1; @endphp
                                                @foreach(json_decode(@$row->experience) as $oneExperience)
                                                    <div class="content style{{$j}}">
                                                        <div class="circle"></div>
                                                        <h4 class="edu_stats">{{$oneExperience->location}} <small>{{$oneExperience->from}} - {{$oneExperience->to}}</small></h4>
                                                        <p class="edu_center">{{$oneExperience->position}}</p>
                                                    </div>
                                                    @php  $j++; if($j == 4) $j = 1; @endphp
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <div class="selected_filter_widget style2 mb30">
                                <div class="siderbar_contact_widget">
                                    <?php
                                    $socialMediaData = json_decode($row->social_media);
                                    ?>

                                    <h4>{{__('Contact')}}</h4>
                                    <p>{{__('Phone Number')}}</p>
                                    <i>{{$row->phone}}</i>
                                    <p>{{__('Email')}}</p>
                                    <i>{{$row->email}}</i>
                                    <p>{{__('Skype')}}</p>
                                    <i>{{@$socialMediaData->skype}}</i>
                                    <p>{{__('Social Media')}}</p>
                                    <ul class="scw_social_icon mb0">
                                        @if(!empty(@$socialMediaData->facebook))
                                            <li class="list-inline-item"><a target="_blank" href="{{$socialMediaData->facebook}}"><i class="fa fa-facebook"></i></a></li>
                                        @endif
                                        @if(!empty(@$socialMediaData->twitter))
                                            <li class="list-inline-item"><a target="_blank" href="{{$socialMediaData->twitter}}"><i class="fa fa-twitter"></i></a></li>
                                        @endif
                                        @if(!empty(@$socialMediaData->instagram))
                                            <li class="list-inline-item"><a target="_blank" href="{{$socialMediaData->instagram}}"><i class="fa fa-instagram"></i></a></li>
                                        @endif
                                        @if(!empty(@$socialMediaData->pinterest))
                                            <li class="list-inline-item"><a target="_blank" href="{{$socialMediaData->pinterest}}"><i class="fa fa-pinterest"></i></a></li>
                                        @endif
                                        @if(!empty(@$socialMediaData->dribbble))
                                            <li class="list-inline-item"><a target="_blank" href="{{$socialMediaData->dribbble}}"><i class="fa fa-dribbble"></i></a></li>
                                        @endif
                                        @if(!empty(@$socialMediaData->google))
                                            <li class="list-inline-item"><a target="_blank" href="{{$socialMediaData->google}}"><i class="fa fa-google"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="selected_filter_widget style2">
                                <div class="siderbar_contact_widget">
                                    <?php
                                    $reviewData = $row->getReviewDataAttribute();
                                    $score_total = $reviewData['score_total'];
                                    ?>
                                    <p>{{__('Total students')}}</p>
                                    <i>{{ number_format($row->getStudentCount()) }}</i>
                                    <p>{{__('Courses')}}</p>
                                    <i>{{ $countCourse }}</i>
                                    <p>{{__('Reviews')}}</p>
                                    <i>{{intval($reviewData['total_review'])}}</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


    </div>
@endsection
@section('script.body')
    <script>
        $('.breadcrumb_content').html('<h4 class="breadcrumb_title">{{$row->getDisplayName()}}</h4><p class="color-white">{{$row->business_name}}</p>');
    </script>
@endsection
