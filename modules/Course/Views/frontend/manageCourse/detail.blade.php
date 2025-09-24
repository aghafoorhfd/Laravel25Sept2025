@extends('layouts.user')
@section('head')

@endsection
@section('content')
    <div class="col-lg-12">
        @include('admin.message')

        <div class="d-flex justify-content-between mb20">

            <div class="">
                @if($row->id)
                    <a class="btn btn-warning btn-xs" href="{{route('course.vendor.lesson.index',['id'=>$row->id])}}" target="_blank"><i class="fa fa-hand-o-right"></i> {{__("Manage Lessons")}}</a>
                @endif
                @if($row->slug)
                    <a class="btn btn-primary btn-sm" href="{{$row->getDetailUrl(request()->query('lang'))}}" target="_blank">{{__("View Course")}}</a>
                @endif
            </div>
        </div>
        <form action="{{route('course.vendor.store',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="col-lg-9 col-xs-12 pt-3">
                    @include('Course::admin/course/course-content')

                    @include('Core::admin/seo-meta/seo-meta')
                </div>

                <div class="col-lg-3 col-xs-12 pt-3">
                    <div class="panel">
                        <div class="panel-title"><strong>{{__("Featured Image")}}</strong></div>
                        <div class="panel-body">
                            <div class="form-group">
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title"><strong>{{__('Publish')}}</strong></div>
                        <div class="panel-body">
                            @if(is_default_lang())
                                <div>
                                    <label><input @if($row->status=='publish') checked @endif type="radio" name="status" value="publish"> {{__("Publish")}}
                                    </label></div>
                                <div>
                                    <label><input @if($row->status=='draft') checked @endif type="radio" name="status" value="draft"> {{__("Draft")}}
                                    </label></div>
                            @endif
                            <div class="text-right">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save Changes')}}</button>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title"><strong>{{__('Featured')}}</strong></div>
                        <div class="panel-body">
                            @if(is_default_lang())
                                <div>
                                    <label><input @if($row->is_featured==1) checked @endif type="radio" name="is_featured" value="1"> {{__("Featured")}}
                                    </label></div>
                                <div>
                                    <label><input @if($row->is_featured=='0') checked @endif type="radio" name="is_featured" value="0"> {{__("Normal")}}
                                    </label></div>
                            @endif
                        </div>
                    </div>


                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('Tag')}}</strong></div>
                        <div class="panel-body">
                            <input type="text" data-role="tagsinput" value="{{$row->tag}}" placeholder="{{ __('Enter tag')}}" name="tag" class="form-control tag-input">
                            <br>
                            <div class="show_tags">
                                @if(!empty($tags))
                                    @foreach($tags as $tag)
                                        <span class="tag_item">{{$tag->name}}<span data-role="remove"></span>
                                                    <input type="hidden" name="tag_ids[]" value="{{$tag->id}}">
                                                </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    @include('Course::admin/course/pricing')

                    @include('Course::admin/course/attributes')
                </div>
                <div class="col-lg-12 pt-3">
                    <button type="submit" class="my_setting_savechange_btn btn btn-thm">{{__('Save')}} <span class="flaticon-right-arrow-1 ml15"></span></button>
                </div>
            </div>



        </form>
    </div>
@endsection
@section('footer')
    <script type="text/javascript" src="{{ asset('libs/tinymce/js/tinymce/tinymce.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('js/condition.js?_ver='.config('app.version')) }}"></script>

@endsection
