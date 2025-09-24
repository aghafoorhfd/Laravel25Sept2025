<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{$html_class ?? ''}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php event(new \Modules\Layout\Events\LayoutBeginHead()); @endphp
    @php
        $favicon = setting_item('site_favicon');
    @endphp
    @if($favicon)
        @php
            $file = (new \Modules\Media\Models\MediaFile())->findById($favicon);
        @endphp
        @if(!empty($file))
            <link rel="icon" type="{{$file['file_type']}}" href="{{asset('uploads/'.$file['file_path'])}}" />
        @else:
            <link rel="icon" type="image/png" href="{{url('images/favicon.png')}}" />
        @endif
    @endif

    @include('Layout::parts.seo-meta')
    <link href="{{ asset('dist/frontend/module/course2/css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('module/course/css/ace-responsive-menu.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('module/course/css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('module/course/css/flaticon.css') }}" rel="stylesheet">
    <link href="{{ asset('module/course/css/font-awesome-animation.min.css') }}" rel="stylesheet">
    <link href="{{ asset('module/course/css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('module/course/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('module/course/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('module/course/css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('module/course/css/slider.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/frontend/css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel='stylesheet' id='google-font-css-css'  href='https://fonts.googleapis.com/css?family=Nunito:400,500,600,700|Open+Sans' type='text/css' media='all' />

    {!! \App\Helpers\Assets::css() !!}
    {!! \App\Helpers\Assets::js() !!}
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
                add_to_cart:'{{route('booking.addToCart')}}',
                remove_cart_item:'{{route('booking.remove_cart_item')}}'
            },
            currentUser:{{(int)Auth::id()}}
        };
        var i18n = {
            warning:"{{__("Warning")}}",
            success:"{{__("Success")}}",
            delete_cart_item_confirm:'{{__("Do you want to delete this cart item?")}}',
            confirm_delete:"{{__("Do you want to delete?")}}",
            confirm:"{{__("Confirm")}}",
            cancel:"{{__("Cancel")}}",
            browse:"{{__("Browse")}}",
            choose_file:"{{__("Choose file...")}}",
            clear:"{{__("Clear")}}",
        };
    </script>

    <link href="{{ asset('dist/frontend/module/course2/css/course.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/frontend/module/course/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
    @yield('script.head')
    @include('Layout::parts.custom-css')
    <link href="{{ asset('libs/carousel-2/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('libs/flags/css/flag-icon.min.css')}}" >
    @php event(new \Modules\Layout\Events\LayoutEndHead()); @endphp
</head>
<body class="frontend-page {{$body_class ?? ''}}">
    @php event(new \Modules\Layout\Events\LayoutBeginBody()); @endphp

    {!! setting_item('body_scripts') !!}
    {!! setting_item_with_lang_raw('body_scripts') !!}
    <div class="wrapper">
        @include('Layout::parts.header')
        @include('Layout::parts.breadcrumbs')
        @yield('content')
        @include('Layout::parts.footer')

    </div>
    {!! setting_item('footer_scripts') !!}
    {!! setting_item_with_lang_raw('footer_scripts') !!}
    @php event(new \Modules\Layout\Events\LayoutEndBody()); @endphp


</body>
</html>
