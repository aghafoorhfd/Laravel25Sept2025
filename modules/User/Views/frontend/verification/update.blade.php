@extends('layouts.user')
@section('content')
    <div class="col-lg-12">
        @include('admin.message')
        <div class="my_course_content_container">
            <div class="my_setting_content mb30">
                <div class="my_setting_content_header">
                    <div class="my_sch_title">
                        <h4 class="m0">{{__("Update verification data")}}</h4>
                    </div>
                </div>
                <div class="row my_setting_content_details">
                    <form action="{{route("user.verification.store")}}" method="post">
                        @csrf
                    @foreach($fields as $field)
                        <div class="col-xl-6">
                            @switch($field['type'])
                                @case("email")
                                @include('User::frontend.verification.fields.email')
                                @break
                                @case("phone")
                                @include('User::frontend.verification.fields.phone')
                                @break
                                @case("file")
                                @include('User::frontend.verification.fields.file')
                                @break
                                @case("multi_files")
                                @include('User::frontend.verification.fields.multi_files')
                                @break
                                @case('text')
                                @default
                                @include('User::frontend.verification.fields.text')
                                @break
                            @endswitch
                        </div>
                    @endforeach
                        <div class="col-lg-12">
                            <button type="submit" class="my_setting_savechange_btn btn btn-thm">{{__('Save changes')}} <span class="flaticon-right-arrow-1 ml15"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
