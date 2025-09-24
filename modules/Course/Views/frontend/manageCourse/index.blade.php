@extends('layouts.user')
@section('head')

@endsection
@section('content')
    <div class="col-lg-12">
        <div class="my_course_content_container">
            <div class="my_course_content mb30">
                <div class="my_course_content_header">
                    <div class="col-xl-4">
                        <div class="instructor_search_result style2">
                            <h4 class="mt10">{{__('Courses')}}</h4>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="candidate_revew_select style2 text-right">
                            <ul class="mb0">
                                <li class="list-inline-item">
                                    <div class="candidate_revew_search_box course fn-520">
                                        <form class="form-inline my-2 my-lg-0" action="{{ route('course.vendor.index') }}" method="get">
                                            <input type="search" class="form-control mr-sm-2" value="{{ Request::query("s") }}" name="s" aria-label="Search" placeholder="{{__("Search our instructors")}}">
                                            <button class="btn my-2 my-sm-0" type="submit"><span class="flaticon-magnifying-glass"></span></button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        @include('admin.message')
                    </div>
                </div>

                @if($rows->total() > 0)
                <div class="my_course_content_list">
                    @foreach($rows as $row)
                        @include('Course::frontend.manageCourse.loop-list')
                    @endforeach
                        {{$rows->appends(request()->query())->links('Course::frontend.layouts.search.paging')}}

                </div>
                @else
                    {{__("No Courses")}}
                @endif
            </div>
        </div>
    </div>



@endsection
@section('footer')
@endsection
