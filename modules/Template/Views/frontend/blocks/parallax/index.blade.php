<?php $image_url = !empty($icon_image) ? get_file_url($icon_image, 'full') : '' ?>
<section class="divider_home1 parallax" data-stellar-background-ratio="0.3" style="background-image: url({{$image_url}});">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="divider-one">
                    <p class="color-white">{{@$title}}</p>
                    <h1 class="color-white text-uppercase">{{@$sub_title}}</h1>
                    <a class="btn btn-transparent divider-btn" href="{{!empty($link) ? $link : 'javascript:void(0)'}}">{{@$text_btn}}</a>
                </div>
            </div>
        </div>
    </div>
</section>
