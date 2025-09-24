@extends('layouts.app')
@section('script.head')
    <link href="{{ asset('dist/frontend/module/booking/css/checkout.css?_ver='.config('app.version')) }}" rel="stylesheet">
@endsection
@section('content')
    <div class="bravo-booking-page padding-content" >
        <div class="container">
            <div id="bravo-checkout-page" >
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="form-title">{{__('CHECKOUT')}}</h3>
                         <div class="booking-form">
                             @include ('Booking::frontend/booking/checkout-form')

                         </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking-detail">
                            @include ('Booking::frontend.checkout.detail')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script.body')
    <script src="{{ asset('module/booking/js/checkout.js') }}"></script>
@endsection
