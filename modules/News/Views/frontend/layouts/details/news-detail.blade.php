<div class="mbp_thumb_post">
    @if($image_url = get_file_url($row->image_id, 'full'))
        <div class="thumb">
            <img class="img-fluid" src="{{ $image_url  }}" alt="{{$translation->title}}">
            <div class="tag">
                @php $category = $row->getCategory; @endphp
                @if(!empty($category))
                    @php $t = $category->translateOrOrigin(app()->getLocale()); @endphp
                    <div>
                        <a class="text-white" href="{{$category->getDetailUrl(app()->getLocale())}}">
                            {{$t->name ?? ''}}
                        </a>
                    </div>
                @endif
            </div>
            @php
                $timeShow = !empty($row->updated_at) ? $row->updated_at : $row->created_at;
            @endphp

            <div class="post_date"><h2>{{ date('d',strtotime($timeShow)) }}</h2> <span>{{ strtoupper(date('F',strtotime($timeShow))) }}</span></div>
        </div>
    @endif

    <div class="details">
        <h3>{{$translation->title}}</h3>
        <ul class="post_meta">
            @if(!empty($row->getAuthor))
                <li><a href="#"><span class="flaticon-profile"></span></a></li>
                <li><a href="{{ route('user.detail', ['id'=>$row->getAuthor->id]) }}"><span>{{$row->getAuthor->getDisplayName() ?? ''}}</span></a></li>
            @endif
        </ul>
        <h4>{{__('Description')}}</h4>
        {!! clean($translation->content) !!}
    </div>
        <br/>
    <ul class="blog_post_share">
        <li><p>{{__('Share')}}</p></li>
        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
        <li><a href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
    </ul>

</div>
