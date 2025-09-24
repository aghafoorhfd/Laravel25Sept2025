@foreach($rows as $row)
    @php
        $translation = $row->translateOrOrigin(app()->getLocale());
    @endphp

    <div class="col-sm-6 col-lg-6 col-xl-6">
        <div class="blog_grid_post mb30">
            <div class="thumb">
                @if($image_tag = get_image_tag($row->image_id,'full', ['class' => "img-fluid"]))
                    <a href="{{$row->getDetailUrl()}}">
                        {!! $image_tag !!}
                    </a>
                @endif
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
            <div class="details">
                <h3><a href="{{$row->getDetailUrl()}}">{{$translation->title}}</a></h3>
                <ul class="post_meta">
                    @if(!empty($row->getAuthor))
                        <li><a href="javascript:void(0)"><span class="flaticon-profile"></span></a></li>
                        <li><a href="javascript:void(0)"><span>{{$row->getAuthor->getDisplayName() ?? ''}}</span></a></li>
                    @endif
                </ul>
                <p>{!! clean(get_exceprt($translation->content)) !!}</p>
            </div>
        </div>
    </div>
@endforeach
