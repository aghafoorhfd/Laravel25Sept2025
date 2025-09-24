<div class="blog_recent_post_widget media_widget">
    <h4 class="title">{{ $item->title }}</h4>
    @php $list_blog = $model_news->with(['getCategory','translations'])->orderBy('id','desc')->paginate(5) @endphp
    @if($list_blog)
        @foreach($list_blog as $blog)
            @php $translation = $blog->translateOrOrigin(app()->getLocale()) @endphp
            <div class="media">
                @if($image_url = get_file_url($blog->image_id, 'thumb'))
                    <a href="{{ $blog->getDetailUrl(app()->getLocale()) }}">
                        {!! get_image_tag($blog->image_id,'thumb',['class'=>'align-self-start mr-3','alt'=>$blog->title]) !!}
                    </a>
                @endif
                <div class="media-body">
                    <a href="{{ $blog->getDetailUrl(app()->getLocale()) }}"><h5 class="mt-0 post_title">{{$translation->title}}</h5></a>
                    <a href="javascript:void(0)">{{ date('F d, Y.', strtotime((!empty($blog->updated_at) ? $blog->updated_at : $blog->created_at))) }}</a>
                </div>
            </div>
        @endforeach
    @endif
</div>
