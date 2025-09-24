@php
    $translation = $row->translateOrOrigin(app()->getLocale());
    $timeShow = !empty($row->updated_at) ? $row->updated_at : $row->created_at;
$category = $row->getCategory;
@endphp

<div class="item">
    <div class="blog_post one">
        <div class="thumb">
            <div class="post_title">{{$translation->title}}</div>
            <img class="img-fluid w100" src="{{get_file_url($row->image_id)}}" alt="{{$translation->title}}">
            <a class="post_date" href="javascript:void(0)"><span>{{ date('d',strtotime($timeShow)) }} <br> {{ ucfirst(date('F',strtotime($timeShow))) }}</span></a>
        </div>
        <div class="details">
            <div class="post_meta">
                <ul>
                    @if(!empty($category))
                        @php $t = $category->translateOrOrigin(app()->getLocale()); @endphp
                        <li class="list-inline-item">
                            <a href="{{$category->getDetailUrl(app()->getLocale())}}"><i class="flaticon-calendar"></i>{{$t->name ?? ''}}</a>
                        </li>
                    @endif
                </ul>
            </div>
            <h4><a class="color-inherit" href="{{$row->getDetailUrl()}}">{{$translation->title}}</a></h4>
        </div>
    </div>
</div>
