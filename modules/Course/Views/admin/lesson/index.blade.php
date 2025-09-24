@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("Lessons Management")}}</h1>
        </div>
        @include('admin.message')
        @include('Course::admin.lesson.form')
    </div>
@endsection
