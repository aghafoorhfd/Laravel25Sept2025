<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{$html_class ?? ''}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php($favicon = setting_item('site_favicon'))
    <link rel="icon" type="image/png" href="{{!empty($favicon)?get_file_url($favicon,'full'):url('images/favicon.png')}}" />
    @include('Layout::parts.seo-meta')
    <link href="{{ asset('libs/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/frontend/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/admin/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}" >

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel='stylesheet' id='google-font-css-css'  href='https://fonts.googleapis.com/css?family=Poppins%3A400%2C500%2C600' type='text/css' media='all' />
    <script>
        var bookingCore = {
            url:'{{url( app_get_locale() )}}',
            url_root:'{{ url('') }}',
			booking_decimals:{{(int)get_current_currency('currency_no_decimal',2)}},
			thousand_separator:'{{get_current_currency('currency_thousand')}}',
			decimal_separator:'{{get_current_currency('currency_decimal')}}',
			currency_position:'{{get_current_currency('currency_format')}}',
			currency_symbol:'{{currency_symbol()}}',
			currency_rate:'{{get_current_currency('rate',1)}}',
            date_format:'{{get_moment_date_format()}}',
            map_provider:'{{setting_item('map_provider')}}',
            map_gmap_key:'{{setting_item('map_gmap_key')}}',
            routes:{
                login:'{{route('auth.login')}}',
                register:'{{route('auth.register')}}',
            }
        };
        var i18n = {
            warning:"{{__("Warning")}}",
            success:"{{__("Success")}}",
            confirm_delete:"{{__("Do you want to delete?")}}",
            confirm:"{{__("Confirm")}}",
            cancel:"{{__("Cancel")}}",
            browse:"{{__("Browse")}}",
            choose_file:"{{__("Choose file...")}}",
            clear:"{{__("Clear")}}",
        };
    </script>

    <link href="{{ asset('dist/frontend/module/course/css/course.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link href="{{ asset('dist/frontend/module/course/css/dashbord_navitaion.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/frontend/module/course/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>


    @yield('head')
    <style type="text/css">
        .bravo_topbar, .bravo_header, .bravo_footer {
            display: none;
        }
        html, body, .bravo_wrap, .bravo_user_profile,
        .bravo_user_profile > .container-fluid > .row-eq-height > .col-md-3 {
            min-height: 100vh !important;
        }
    </style>
    @include('Layout::parts.custom-css')
    <link href="{{ asset('libs/carousel-2/owl.carousel.css') }}" rel="stylesheet">
</head>
<body class="user-page {{$body_class ?? ''}}">
    {!! setting_item('body_scripts') !!}
    <div class="bravo_wrap wrapper">
        @include('Layout::parts.header',['is_user_page'=>1])

        @include('User::frontend.layouts.sidebar')


        <div class="our-dashbord dashbord">
            <div class="dashboard_main_content">
                <div class="container-fluid">
                    <div class="main_content_container">
                        <div class="row">
                            <div class="col-sm-12 col-lg-8 col-xl-12">
                                <div class="row">
                                    @include('Layout::parts.user-bc')
                                    @yield('content')
                                </div>
                                <div class="row mt10 mb50">
                                    <div class="col-lg-12">
                                        <div class="copyright-widget text-center">
                                            <p class="color-black2">{!! clean(setting_item_with_lang("copyright_text"))  !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>
        <a class="dn" id="countdown" href="#"></a>

        @if(Auth::id())
            @include('Media::browser')
        @endif

        <script src="{{ asset('libs/lodash.min.js') }}"></script>
        <script src="{{ asset('libs/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('libs/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/jquery-migrate-3.0.0.min.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/popper.min.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/jquery.mmenu.all.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/ace-responsive-menu.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/isotop.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/snackbar.min.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/simplebar.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/parallax.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/scrollto.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/jquery-scrolltofixed-min.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/jquery.counterup.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/progressbar.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/slider.js') }}"></script>
        <script src="{{ asset('dist/frontend/module/course/js/timepicker.js') }}"></script>
        <script src="{{ asset('libs/tinymce/js/tinymce/tinymce.min.js') }}" ></script>

        <script type="text/javascript" src="{{ asset('dist/frontend/module/course/js/smartuploader2.js') }}"></script>
        <script type="text/javascript" src="{{ asset('dist/frontend/module/course/js/dashboard-script.js') }}"></script>
        <script src="{{ asset("libs/daterange/moment.min.js") }}"></script>
        <script src="{{ asset("libs/daterange/daterangepicker.min.js") }}"></script>
        <script src="{{ asset('libs/select2/js/select2.min.js') }}" ></script>
        <script src="{{ asset('js/functions.js?_ver='.config('app.version')) }}"></script>
        <script src="{{ asset('js/home.js?_ver='.config('app.version')) }}"></script>


        <script src="{{ asset('libs/vue/vue.js') }}"></script>
        <script src="{{ asset('libs/bootbox/bootbox.min.js') }}"></script>

        @if(Auth::id())
            <script src="{{ asset('module/media/js/browser.js?_ver='.config('app.version')) }}"></script>
        @endif
        <script src="{{ asset('module/user/js/user.js?_ver='.config('app.version')) }}"></script>

        @yield('footer')
        <script src="{{ asset('dist/frontend/module/course/js/script.js?_ver='.config('app.version')) }}"></script>
    </div>
    {!! setting_item('footer_scripts') !!}
</body>
</html>
