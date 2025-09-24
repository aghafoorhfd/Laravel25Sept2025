<div class="team_member {{ !empty($slider) ? 'style2' : 'style3 mb30' }} text-center ">
    <div class="instructor_col">
        <div class="thumb">
            <a class="author-link" href="{{route('user.detail',['id'=>$row->id])}}" target="_blank">
            @if($avatar_url = $row->getAvatarUrl())
                <img class="img-fluid img-rounded-circle" src="{{$avatar_url}}" alt="{{$row->getDisplayName()}}">
            @else
                <span class="img-fluid avatar-text">{{ucfirst($row->getDisplayName()[0])}}</span>
            @endif
            </a>
        </div>
        <div class="details">
            <h4>
                <a class="author-link" href="{{route('user.detail',['id'=>$row->id])}}" target="_blank">
                    {{$row->getDisplayName()}}
                </a>
            </h4>
            <?php $categoryCreated = $row->getCategoryCourseByUser(); $listCategoryCreated = [];
            if(!empty($categoryCreated)){
                foreach($categoryCreated as $oneCategory){
                    if(isset($oneCategory->category_course->name)){
                        $listCategoryCreated[$oneCategory->category_course->name] = $oneCategory->category_course->name;    
                    }
                }
                printf("<p class='p-1'>%s</p>", implode(', ', $listCategoryCreated));
            }
            ?>
            @if(setting_item('course_enable_review'))
                <?php
                $reviewData = $row->getReviewDataAttribute();
                $score_total = $reviewData['score_total'];
                ?>
                <ul>
                    @for( $i = 0 ; $i < 5 ; $i++ )
                        @if($i < $score_total)
                            <li class="list-inline-item"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                        @else
                            <li class="list-inline-item"><a href="javascript:void(0)"><i class="fa fa-star-o"></i></a></li>
                        @endif
                    @endfor
                        <li class="list-inline-item"><a href="javascript:void(0)">({{intval($reviewData['total_review'])}})</a></li>
                </ul>
            @endif
        </div>
    </div>
    <div class="tm_footer">
        <ul>
            <li class="list-inline-item"><a href="#">{{ number_format($row->getStudentCount()) }} {{__('students')}}</a></li>
            <li class="list-inline-item"><a href="#">{{ $row->getCourseCount() }} {{__('courses')}}</a></li>
        </ul>
    </div>
</div>
