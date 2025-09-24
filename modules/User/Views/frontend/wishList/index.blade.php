@extends('layouts.user')
@section('head')

@endsection
@section('content')
    <div class="col-lg-12">
        <div class="my_course_content_container">
            <div class="my_course_content mb30">
                <div class="my_course_content_header">
                    <div class="col-xl-12">
                        <div class="instructor_search_result style2">
                            <h4 class="mt10">{{__('WishList')}}</h4>
                        </div>
                    </div>

                </div>
                @include('admin.message')

                @if($rows->total() > 0)
                    <div class="my_course_content_list">
                        @foreach($rows as $row)
                            @include('User::frontend.wishList.loop-list')
                        @endforeach
                        {{$rows->appends(request()->query())->links('Course::frontend.layouts.search.paging')}}

                    </div>
                @else
                    <div class="my_course_content_list">
                        <div class="mc_content_list">
                            {{__("No Items")}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection
