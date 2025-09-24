@extends('layouts.user')
@section('head')
@endsection
@section('content')

    <div class="col-lg-12">
        <div class="my_course_content_container">
            <div class="my_setting_content mb30">
                <form action="{{ route("user.change_password") }}" method="post" class="input-has-icon">
                    @csrf
                    <div class="my_setting_content_header">
                        <div class="my_sch_title">
                            <h4 class="m0">{{__("Change Password")}}</h4>
                        </div>
                    </div>
                    <div class="row my_setting_content_details">
                        <div class="col-12">
                            @include('admin.message')
                        </div>
                        <div class="col-xl-6">
                            <div class="password_change_form">
                                <form>
                                    <div class="form-group">
                                        <label for="current-password">{{__("Current Password")}}</label>
                                        <input type="password" class="form-control" id="current-password" name="current-password" placeholder="{{__("Current Password")}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="new-password">{{__("New Password")}}</label>
                                        <input type="password" class="form-control" id="new-password" name="new-password" placeholder="{{__("New Password")}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="new-password_confirmation">{{__("Confirm Password")}}</label>
                                        <input type="password" class="form-control mb0" id="new-password_confirmation" name="new-password_confirmation" placeholder="{{__("New Password Again")}}">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="my_setting_savechange_btn btn btn-thm">{{__("Change")}} <span class="flaticon-right-arrow-1 ml15"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')

@endsection
