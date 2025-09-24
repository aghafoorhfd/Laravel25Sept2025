@php
    $translation = $row->translateOrOrigin(app()->getLocale());
    $timeShow = !empty($row->updated_at) ? $row->updated_at : $row->created_at;
@endphp
<div class="blog_post">
    <div class="thumb">
        <img class="img-fluid w100" src="{{get_file_url($row->image_id,'medium')}}" alt="{{$translation->title}}">
        <a class="post_date" href="{{$row->getDetailUrl()}}">{{ date('M d, Y',strtotime($timeShow)) }}</a>
    </div>
    <div class="details">
        @php $category = $row->getCategory; @endphp
        @if(!empty($category))
            @php $t = $category->translateOrOrigin(app()->getLocale()); @endphp
                <a href="{{$category->getDetailUrl(app()->getLocale())}}">
                    <h5>{{$t->name ?? ''}}</h5>
                </a>
        @endif

        <h4><a href="{{$row->getDetailUrl()}}">{!! clean(get_exceprt($translation->title, 25, '...')) !!}</a></h4>
    </div>
</div>
