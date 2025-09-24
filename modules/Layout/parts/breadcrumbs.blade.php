@if(empty(@$hideBc))
<section class="inner_page_breadcrumb" style="background-image: url({{!empty($banner_image) ? get_file_url($banner_image, 'full') : ''}});">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">@if(empty($breadcrumbs)){{__('Home')}}@else {{ end($breadcrumbs)['name'] }} @endif</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url(app_get_locale())}}">{{__('Home')}}</a></li>
                        @if(!empty($breadcrumbs))
                            @foreach($breadcrumbs as $breadcrumb)
                                <li class="breadcrumb-item {{$breadcrumb['class'] ?? ''}}" aria-current="page">
                                    @if(!empty($breadcrumb['url']))
                                        <a href="{{url($breadcrumb['url'])}}">{{$breadcrumb['name']}}</a>
                                    @else
                                        {{$breadcrumb['name']}}
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
