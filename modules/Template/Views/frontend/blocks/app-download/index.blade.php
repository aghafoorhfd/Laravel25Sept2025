<?php $image_url = !empty($icon_image) ? get_file_url($icon_image, 'full') : '' ?>
<?php $image_capture = !empty($icon_capture) ? get_file_url($icon_capture, 'full') : '' ?>
<section class="home1-divider2 parallax" data-stellar-background-ratio="0.3" style="background-image: url({{$image_url}});">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-lg-7">
                <div class="app_grid">
                    <h1 class="mt0">{{@$title}}</h1>
                    <p>{{@$sub_title}}</p>
                    <button class="apple_btn btn-transparent" onclick="window.open('{{@$link_apple}}', '_blank')">
							<span class="icon">
								<span class="flaticon-apple"></span>
							</span>
                        <span class="title">{{__('App Store')}}</span>
                        <span class="subtitle">{{__('Available now on the')}}</span>
                    </button>
                    <button class="play_store_btn btn-transparent" onclick="window.open('{{@$link_google}}', '_blank')">
							<span class="icon">
								<span class="flaticon-google-play"></span>
							</span>
                        <span class="title">{{(__('Google Play'))}}</span>
                        <span class="subtitle">{{(__('Get in on'))}}</span>
                    </button>
                </div>
            </div>
            <div class="col-md-5 col-lg-5">
                <div class="phone_img">
                    <img class="img-fluid" src="{{$image_capture}}" alt="{{__('Capture Screen')}}">
                </div>
            </div>
        </div>
    </div>
</section>
