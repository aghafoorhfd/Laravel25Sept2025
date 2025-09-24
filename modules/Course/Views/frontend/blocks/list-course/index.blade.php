<section class="popular-courses">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h3 class="mt0">{{@$title}}</h3>
                    <p>{{@$desc}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="popular_course_slider_home3">
                    @foreach($rows as $row)
                        <div class="item">
                            @include('Course::frontend.layouts.search.loop-gird')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
