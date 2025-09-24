@extends('layouts.app')
@section('head')
    <link href="{{ asset('css/app.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
@endsection
@section('content')
    <section class="blog_post_container">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xl-9">
                    <div class="main_blog_post_content">
                        <div class="row">
                            @if($rows->count() > 0)
                                @include('News::frontend.layouts.details.news-loop')
                            @else
                                <div class="alert alert-danger col-12">
                                    {{__("Sorry, but nothing matched your search terms. Please try again with some different keywords.")}}
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            @if($rows->count() > 0)
                                {{$rows->appends(request()->query())->links('Course::frontend.layouts.search.paging')}}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 pl10 pr10">
                    <div class="main_blog_post_widget_list">
                        @include('News::frontend.layouts.details.news-sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

 
