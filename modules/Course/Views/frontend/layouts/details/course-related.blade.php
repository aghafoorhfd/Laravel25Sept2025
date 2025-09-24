@if(!empty($course_related) && count($course_related) > 0)
    <div class="col-lg-12">
        <h3 class="r_course_title">{{__('Related Courses')}}</h3>
    </div>
    @foreach($course_related as $k=>$item)

    <div class="col-lg-6 col-xl-4">
        @includeIf("Course::frontend.layouts.search.loop-gird", ['row' => $item])
    </div>
    @endforeach
@endif
