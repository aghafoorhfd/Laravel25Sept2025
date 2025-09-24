@extends('layouts.app')
@section('content')
    <section class="our-team pb40">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8 col-xl-9">
                    @include('Course::frontend.layouts.search.form-search')
                    @include('Course::frontend.layouts.search.list-item',['blank'=>false])

                </div>
                <div class="col-lg-4 col-xl-3">
                    @include('Course::frontend.layouts.search.filter-search')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script.body')
    <script>
        $( "#time_s" ).change(function() {
            $('#course_search_form').submit();
        });
    </script>
@endsection

