@extends('layouts.user')
@section('head')

@endsection
@section('content')
    <div class="col-lg-12">
        @include('admin.message')

        @include('Course::admin.lesson.form')
    </div>
@endsection
@section('footer')
    <script type="text/javascript" src="{{ asset('libs/tinymce/js/tinymce/tinymce.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/condition.js?_ver='.config('app.version')) }}"></script>
    <script type="text/javascript" src="{{ asset('dist/admin/js/manifest.js?_ver='.config('app.version')) }}"></script>
    <script type="text/javascript" src="{{ asset('dist/admin/js/vendor.js?_ver='.config('app.version')) }}"></script>
    <script type="text/javascript" src="{{ asset('dist/admin/js/frontend_lectures.js?_ver='.config('app.version')) }}"></script>
@endsection
