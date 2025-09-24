@extends('layouts.app')
@section('content')

    <section class="our-team instructor-page pb40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title text-center">
                        <h3 class="mb0 mt0">{{__('Popular Instructors')}}</h3>
                    </div>
                </div>
            </div>
            @if(count($popular) > 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="team_slider">
                            @foreach($popular as $row)
                                <div class="item">
                                    @include('User::frontend.layouts.search.loop-gird',['slider'=>true])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="our-team pb40">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8 col-xl-9">
                    @include('User::frontend.layouts.search.form-search')
                    @include('User::frontend.layouts.search.list-item',['blank'=>false])

                </div>
                <div class="col-lg-4 col-xl-3">
                    @include('User::frontend.layouts.search.filter-search')
                </div>
            </div>
        </div>
    </section>
@endsection
