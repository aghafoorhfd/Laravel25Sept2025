
<div class="my_profile_setting_input2">
    <label>
        {{$field['name_'.app()->getLocale()] ?? $field['name'] ?? $field['id']}}
        @if(!empty($field['required']))<span class="text-danger">*</span> @endif
    </label>
    <div class="input-group">
        @if(empty($only_show_data))
            <input type="text" class="form-control" name="verify_data_{{$field['id']}}" value="{{$field['data']}}">
        @else
            <div class=""><strong>{{$field['data'] ? $field['data'] : __('N/A')}}</strong></div>
            @if(!empty($field['is_verified']))
                <a class="badge badge-success" href="#" onclick="return false"><i>{{__("Verified")}}</i></a>
            @else
                <span class="badge badge-secondary"><i>{{__("Not Verified")}}</i></span>
            @endif
        @endif
    </div>
</div>
