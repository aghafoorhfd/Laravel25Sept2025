@extends ('layouts.app')
@section ('content')
    @if($row->template_id)
        <div class="page-template-content">
            {!! clean($row->getProcessedContent()) !!}
        </div>
    @else
        <div class="container " style="padding-top: 40px;padding-bottom: 40px;">
            <h1>{{$translation->title}}</h1>
            <div class="blog-content">
                {!! clean($translation->content) !!}
            </div>
        </div>
    @endif
@endsection
