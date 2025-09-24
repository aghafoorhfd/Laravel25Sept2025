


<section class="footer_one">
    <div class="container">
        <div class="row">
            @if($list_widget_footers = setting_item_with_lang("list_widget_footer"))
                <?php $list_widget_footers = json_decode($list_widget_footers); ?>
                @foreach($list_widget_footers as $key=>$item)
                    <div class="col-sm-6 col-md-4 col-md-3 col-lg-{{$item->size ?? '3'}}">
                        <div class="{{$item->size == '2' ? 'footer_contact_widget' : 'footer_apps_widget'}}">
                            <h4>
                                {{$item->title}}
                            </h4>
                            <ul class="list-unstyled">
                                {!! clean($item->content)  !!}
                            </ul>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


<section class="footer_middle_area p0">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3 col-lg-3 col-xl-2 pb15 pt15">
                <div class="logo-widget home1">
                    @if($logo_id = setting_item("logo_id"))
                        <?php $logo = get_file_url($logo_id,'full') ?>
                        <img class="img-fluid" src="{{$logo}}" alt="{{setting_item("site_title")}}">
                    @endif
                    <span>{{setting_item("site_title")}}</span>
                </div>
            </div>
            <div class="col-sm-8 col-md-5 col-lg-6 col-xl-6 pb25 pt25 brdr_left_right">
                <div class="footer_menu_widget">
                    {!! clean(setting_item_with_lang("footer_text_left")) !!}
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-4 pb15 pt15">
                <div class="footer_social_widget mt15">
                    {!! clean(setting_item_with_lang("footer_text_right")) !!}
                </div>
            </div>
        </div>
    </div>
</section>


<section class="footer_bottom_area pt25 pb25">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="copyright-widget text-center">
                    <p>{!! clean(setting_item_with_lang("copyright_text")) !!}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>

@include('Layout::parts.login-register-modal')
@include('Layout::parts.chat')
@if(Auth::id())
    @include('Media::browser')
@endif


{!! \App\Helpers\Assets::css(true) !!}

<script src="{{asset('libs/lazy-load/intersection-observer.js')}}"></script>
<script async src="{{asset('libs/lazy-load/lazyload.min.js')}}"></script>
<script>
    // Set the options to make LazyLoad self-initialize
    window.lazyLoadOptions = {
        elements_selector: ".lazy",
        // ... more custom settings?
    };

    // Listen to the initialization event and get the instance of LazyLoad
    window.addEventListener('LazyLoad::Initialized', function (event) {
        window.lazyLoadInstance = event.detail.instance;
    }, false);


</script>
<script src="{{ asset('libs/lodash.min.js') }}"></script>
<script src="{{ asset('libs/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('libs/jquery-ui.min.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/popper.min.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/jquery.mmenu.all.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/ace-responsive-menu.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/bootstrap-select.min.js') }}"></script>

<script src="{{ asset('dist/frontend/module/course/js/parallax.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/scrollto.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/jquery-scrolltofixed-min.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/jquery.counterup.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/progressbar.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/slider.js') }}"></script>
<script src="{{ asset('dist/frontend/module/course/js/timepicker.js') }}"></script>


<script src="{{ asset('libs/vue/vue.js') }}"></script>
<script src="{{ asset('libs/bootbox/bootbox.min.js') }}"></script>

@if(Auth::id())
    <script src="{{ asset('module/media/js/browser.js?_ver='.config('app.version')) }}"></script>
@endif
<script src="{{ asset("libs/daterange/moment.min.js") }}"></script>
<script src="{{ asset("libs/daterange/daterangepicker.min.js") }}"></script>
<script src="{{ asset('libs/select2/js/select2.min.js') }}" ></script>
<script src="{{ asset('js/functions.js?_ver='.config('app.version')) }}"></script>

@if(setting_item('inbox_enable'))
    <script src="{{ asset('module/core/js/chat-engine.js?_ver='.config('app.version')) }}"></script>
@endif
<script src="{{ asset('js/home.js?_ver='.config('app.version')) }}"></script>

@if(!empty($is_user_page))
    <script src="{{ asset('module/user/js/user.js?_ver='.config('app.version')) }}"></script>
@endif


{!! \App\Helpers\Assets::js(true) !!}

<script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
<script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
<script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>


@yield('script.body')


<script src="{{ asset('dist/frontend/module/course/js/script.js?_ver='.config('app.version')) }}"></script>
<script defer src="{{ asset('dist/frontend/module/course/js/isotop.js') }}"></script>
@php \App\Helpers\ReCaptchaEngine::scripts() @endphp
