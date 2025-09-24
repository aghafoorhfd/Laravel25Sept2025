@if($list_item)
    <section id="our-partners" class="our-partners">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="main-title text-center">
                        <h3 class="mt0">{{@$title}}</h3>
                        <p>{{$sub_title}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($list_item as $k=>$item)
                    <?php $image_url = get_file_url($item['icon_image'], 'full') ?>
                        <div class="col-sm-6 col-md-4 col-lg">
                            <div class="our_partner">
                                <a href="{{$item['link']}}" target="_blank">
                                    <img class="img-fluid" src="{{$image_url}}" alt="{{$item['title']}}">
                                </a>

                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
