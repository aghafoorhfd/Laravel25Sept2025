@if($list_item)
    <div class="home1-mainslider">
        <div class="container-fluid p0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-banner-wrapper">
                        <div class="banner-style-one owl-theme owl-carousel">
                            @foreach($list_item as $k=>$item)
                                <?php $image_url = get_file_url($item['icon_image'], 'full') ?>
                                    <div class="slide slide-one" style="background-image: url({{$image_url}}); height: 95vh;">
                                        <div class="container">
                                            <div class="row home-content">
                                                <div class="col-lg-12 text-center p0">
                                                    <h3 class="banner-title">{{$item['title']}}</h3>
                                                    <p>{!! clean($item['sub_title']) !!}</p>
                                                    <div class="btn-block"><a href="#" class="banner-btn">{{__('Ready to get Started?')}}</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                        <div class="carousel-btn-block banner-carousel-btn">
                            <span class="carousel-btn left-btn"><i class="flaticon-left-arrow left"></i> <span class="left">{{__('PR')}}<br/>{{__('EV')}}</span></span>
                            <span class="carousel-btn right-btn"><span class="right">{{__('NE')}}<br/>{{__('XT')}}</span> <i class="flaticon-right-arrow-1 right"></i></span>
                        </div><!-- /.carousel-btn-block banner-carousel-btn -->
                    </div><!-- /.main-banner-wrapper -->
                </div>
            </div>
        </div>
        <div class="container home_iconbox_container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @if($list_sub)
                            @foreach($list_sub as $k=>$item)
                                <?php $image_url = get_file_url($item['icon_image'], 'full') ?>
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="home_icon_box">
                                            <div class="icon"><img src="{{$image_url}}" alt="{{$item['title']}}"></div>
                                            <p>{{$item['title']}}</p>
                                        </div>
                                    </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="our-courses pt90 pt650-992" style="margin-bottom: -90px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <a href="#our-courses">
                        <div class="mouse_scroll">
                            <div class="icon"><span class="flaticon-download-arrow"></span></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif
