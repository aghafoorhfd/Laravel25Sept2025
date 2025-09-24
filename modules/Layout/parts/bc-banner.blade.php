
@if(!empty($breadcrumbs))
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
    @foreach($breadcrumbs as $breadcrumb)
        <li class="breadcrumb-item {{$breadcrumb['class'] ?? ''}}">
            @if(!empty($breadcrumb['url']))
                <a href="{{url($breadcrumb['url'])}}">{{$breadcrumb['name']}}</a>
            @else
                {{$breadcrumb['name']}}
            @endif
        </li>
    @endforeach
</ol>
@endif