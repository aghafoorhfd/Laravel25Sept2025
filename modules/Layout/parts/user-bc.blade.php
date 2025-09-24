@if(!empty($breadcrumbs))
<div class="col-lg-12">
    <nav class="breadcrumb_widgets" aria-label="breadcrumb mb30">
        <h4 class="title float-left">{{@end($breadcrumbs)['name']}}</h4>
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="{{url(app_get_locale())}}">{{__('Home')}}</a></li>
            @foreach($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item {{$breadcrumb['class'] ?? ''}}">
                    @if(!empty($breadcrumb['url']))
                        <a href="{{ $breadcrumb['url'] }}">{{$breadcrumb['name']}}</a>
                    @else
                        {{$breadcrumb['name']}}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>
@endif
