@extends('layouts.app')
@section('head')
    <link href="{{ asset('module/booking/css/checkout.css?_ver='.config('app.version')) }}" rel="stylesheet">
@endsection
@section('content')
    <div class="bravo-booking-page padding-content " >
        <div class="container">
            <div id="bravo-cart-page" >
                @if(Cart::count())
                <div class="row">
                    <div class="col-md-12 col-lg-8 col-xl-8">
                         <div class="booking-form">
                             @include ('Booking::frontend.cart.form')
                         </div>
                    </div>
                    <div class="col-lg-4 col-xl-4">
                        <div class="booking-detail">
                            @include ('Booking::frontend.checkout.detail',['hide_list'=>true])
                            <div class="ui_kit_button payment_widget_btn">
                                <a href="{{route('booking.checkout')}}" class="btn dbxshad btn-lg btn-thm3 circle btn-block">{{__('Proceed To Checkout') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-warning">{{__("Your cart is empty!")}}</div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('module/booking/js/cart.js') }}"></script>
@endsection
