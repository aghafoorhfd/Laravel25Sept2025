@if(!empty($section))
    <input type="hidden" name="section_id" value="{{$section->id}}">
@endif
<div class="form-group">
    <label>{{__("Name")}}</label>
    <input type="text" value="{{$translation->name}}" placeholder="{{__("Lesson name")}}" name="name" class="form-control">
</div>
<div class="form-group">
    <label>{{__("Duration")}}</label>
    <input type="number" name="duration" id="duration" min="0" max="100" step="0.25" class="form-control" value="{{$row->duration}}" placeholder="{{__("Duration")}}">
</div>
@if(is_default_lang())
<div class="form-group">
    <label >{{__('Icon')}}</label>
    <input type="text" value="{{$row->icon}}" placeholder="{{__("Icon code")}}" name="icon" class="form-control">
</div>
<div class="form-group">
    <label >{{__('Image')}}</label>
    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',$row->image_id) !!}
</div>
@endif
<div class="form-group">
    <label class="control-label">{{__("Description")}}</label>
    <div class="">
        <textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{$translation->content}}</textarea>
    </div>
</div>
