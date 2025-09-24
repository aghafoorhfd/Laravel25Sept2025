@extends('layouts.app')
@section('head')
	<link href="{{ asset('css/contact.css?_ver='.config('app.version')) }}" rel="stylesheet">
@endsection
@section('content')
<section class="our-contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-placeholder-1"></span></div>
                    <h4>{{__('Our Location')}}</h4>
                    <p>{{setting_item("contact_location")}}</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-phone-call"></span></div>
                    <h4>{{__('Our Contact')}}</h4>
                    <p class="mb0">{{__('Mobile')}}: {{setting_item("contact_phone")}}
                        <br> {{__('Fax')}}: {{setting_item("contact_fax")}}
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="contact_localtion text-center">
                    <div class="icon"><span class="flaticon-email"></span></div>
                    <h4>{{__('Write Some Words')}}</h4>
                    <p>{{setting_item("email_from_address")}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="h600" id="map-canvas"></div>
            </div>
            <div class="col-lg-6 form_grid">
                <h4 class="mb5">{{ setting_item_with_lang("page_contact_title") }}</h4>
                <p>{{ setting_item_with_lang("page_contact_sub_title") }}</p>
                <form class="contact_form" id="contact_form" name="contact_form" action="{{url(app_get_locale().'/contact/store')}}" method="post" novalidate="novalidate">
                        {{csrf_field()}}
                    <div style="display: none;">
                        <input type="hidden" name="g-recaptcha-response" value="">
                    </div>
                    @include('admin.message')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name">{{__('Full Name')}}</label>
                                <input id="text" name="name" class="form-control" required="required" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email">{{__('Your Email')}}</label>
                                <input id="email" name="email" class="form-control required email" required="required" type="email">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="subject">{{__('Subject')}}</label>
                                <input id="subject" name="subject" class="form-control required" required="required" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="message">{{__('Your Message')}}</label>
                                <textarea id="message" name="message" class="form-control required" rows="5" required="required"></textarea>
                            </div>
                            <div class="form-group">
                                {{recaptcha_field('contact')}}
                            </div>
                            <div class="form-group ui_kit_button mb0">
                                <button type="submit" class="btn dbxshad btn-lg btn-thm circle white">{{__('SEND')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script.body')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            new BravoMapEngine('map-canvas', {
                disableScripts: true,
                fitBounds: true,
                center: [{{setting_item("map_lat") ?? "51.505"}}, {{setting_item("map_lng") ?? "-0.09"}}],
                zoom:{{setting_item("map_zoom") ?? "8"}},
                ready: function (engineMap) {
                    @if(!empty(setting_item("map_lat")) && !empty(setting_item("map_lng")))
                    engineMap.addMarker([{{setting_item("map_lat")}}, {{setting_item("map_lng")}}], {
                        icon_options: {}
                    });
                    @endif

                    engineMap.on('zoom_changed', function (zoom) {
                        $("input[name=map_zoom]").attr("value", zoom);
                    });
                }
            });
        })
    </script>
@endsection
