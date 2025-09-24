<section id="our-courses" >
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h3 class="mt0">{{@$title}}</h3>
                    <p>{{@$sub_title}}</p>
                </div>
            </div>
        </div>
        @if($rows)
            <div class="row">
                @foreach($rows as $k=>$item)
                    @if(!empty($item['data']))
                        <?php $image_url = get_file_url($item['data']->image_id, 'full') ?>
                        <div class="col-sm-6 col-lg-3">
                                <div onclick="window.location.href='{{$item['data']->getDetailUrl()}}'" class="img_hvr_box" style="background-image: url({{$image_url}});">
                                    <div class="overlay">
                                        <div class="details">
                                            <h5>{{$item['data']->name}}</h5>
                                            <p>{{__('Over')}} {{@$item['data']->countCourse->count()}} {{ intval(@$item['data']->countCourse->count()) > 1 ? __('Courses') : __('Course')}}</p>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @endif
                @endforeach
                <div class="col-lg-6 offset-lg-3">
                    <div class="courses_all_btn text-center">
                        <a class="btn btn-transparent" href="{{route('course.search')}}">{{__('View All Courses')}}</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>


