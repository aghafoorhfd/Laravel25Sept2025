@if($list_item)
    @if($style == 'style4')
        <section class="about-section">
            <div class="container">
                <div class="row">
                    @foreach($list_item as $k=>$item)
                        <div class="col-lg-6">
                            <div class="about_whoweare">
                                <h4>{{$item['title']}}</h4>
                                {!! clean($item['sub_title']) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <div class="bravo-featured-item {{$style ?? ''}}">
            <div class="container">
                <div class="row">
                    @foreach($list_item as $k=>$item)
                        <?php $image_url = get_file_url($item['icon_image'], 'full') ?>
                        <div class="col-md-4">
                            <div class="featured-item">
                                <div class="image">
                                    @if(!empty($style) and $style == 'style2')
                                        <span class="number-circle">{{$k+1}}</span>
                                    @else
                                        <img src="{{$image_url}}" class="img-fluid">
                                    @endif
                                </div>
                                <div class="content">
                                    <h4 class="title">
                                        {{$item['title']}}
                                    </h4>
                                    <div class="desc">{!! clean($item['sub_title']) !!}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endif
