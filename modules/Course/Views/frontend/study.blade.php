@extends('Layout::app')
@section('script.head')
    <link rel="stylesheet" href="{{asset('dist/frontend/module/course2/css/study.css')}}">
@endsection
@section('content')
    <div class="course-layouts page-content" id="course_study_box" v-cloak="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-section-nav">
                    @include('Course::frontend.study.sections')
                </div>
                <div class="col-md-9 col-lesson-play">
                    @include('Course::frontend.study.study')
                </div>
            </div>
        </div>
    </div>
    <script>
        var course_data = {!! json_encode($row->study_js_data) !!};
    </script>
@endsection
