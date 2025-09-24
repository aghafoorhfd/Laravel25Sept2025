<?php
$vendor = $row->author;
?>
<div class="cs_row_four csv2">
    <div class="about_ins_container">
        <h4 class="aii_title">{{__('About the instructor')}}</h4>
        <div class="about_ins_info">
            @if($avatar_url = $vendor->getAvatarUrl())
                <img class="thumb" src="{{$avatar_url}}" alt="{{$vendor->getDisplayName()}}">
            @else
                <span class="avatar-text">{{ucfirst($vendor->getDisplayName()[0])}}</span>
            @endif
        </div>
        <div class="details">
            @if(setting_item('course_enable_review'))
                <?php
                $reviewData = $row->getScoreReview();
                $score_total = $reviewData['score_total'];
                ?>
                <ul class="review_list">
                    @for( $i = 0 ; $i < 5 ; $i++ )
                        @if($i < $score_total)
                            <li class="list-inline-item"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                        @else
                            <li class="list-inline-item"><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                        @endif
                    @endfor
                        <li class="list-inline-item">{{$score_total}} {{__('Instructor Rating')}}</li>
                </ul>
            @endif
            <ul class="about_info_list">
                @if(setting_item('course_enable_review'))
                <li class="list-inline-item"><span class="flaticon-comment"></span> {{ number_format(intval($reviewData['total_review'])) }} {{__('Reviews')}} </li>
                @endif
                <li class="list-inline-item"><span class="flaticon-profile"></span> {{ number_format($vendor->getStudentCount()) }} {{__('Students')}} </li>
                <li class="list-inline-item"><span class="flaticon-play-button-1"></span> {{ number_format($vendor->getCourseCount()) }} {{__('Courses')}} </li>
            </ul>
            <h4>{{$vendor->getDisplayName()}}</h4>
            <?php $categoryCreated = $vendor->getCategoryCourseByUser(); $listCategoryCreated = [];
            if(!empty($categoryCreated)){
                foreach($categoryCreated as $oneCategory){
                    if(isset($oneCategory->category_course->name)){
                        $listCategoryCreated[$oneCategory->category_course->name] = $oneCategory->category_course->name;
                    }
                }
                printf("<p class='subtitle'>%s</p>", implode(', ', $listCategoryCreated));
            }
            ?>
                <div class="instructor_personal_infor">
                    {!! clean($vendor->bio) !!}

                    @if(!empty($vendor->education))
                        <h4>{{__('My Education')}}</h4>
                        <div class="my_resume_eduarea">
                            @php  $i = 1; @endphp
                            @foreach(json_decode(@$vendor->education) as $oneEducation)
                                <div class="content style{{$i}}">
                                    <div class="circle"></div>
                                    <h4 class="edu_stats">{{$oneEducation->location}} <small>{{$oneEducation->from}} - {{$oneEducation->to}}</small></h4>
                                    <p class="edu_center">{{$oneEducation->reward}}</p>
                                </div>
                                @php  $i++; if($i == 4) $i = 1; @endphp
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($vendor->experience))
                        <h4>{{__('My Experience')}}</h4>
                        <div class="my_resume_eduarea">
                            @php  $j = 1; @endphp
                            @foreach(json_decode(@$vendor->experience) as $oneExperience)
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
