@extends('layouts.user')
@section('head')

@endsection
@section('content')
    <div class="col-lg-12">
        @include('admin.message')

        <div class="my_course_content_container">
            <div class="my_setting_content mb30">
                <form action="{{ route("user.profile.index") }}" method="post" class="input-has-icon">
                    @csrf
                    <div class="my_setting_content_header">
                        <div class="my_sch_title">
                            <h4 class="m0">{{__("Personal Information")}}</h4>
                        </div>
                    </div>
                    <div class="row my_setting_content_details pb0">
                        <div class="col-xl-2">
                            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('avatar_id', @$dataUser->avatar_id) !!}
                        </div>

                        <div class="col-xl-10">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="my_profile_setting_input form-group">
                                        <label for="business_name">{{__("Business name")}}</label>
                                        <input type="text" class="form-control" id="business_name" value="{{old('business_name',$dataUser->business_name)}}" name="business_name" placeholder="{{__("Business name")}}">
                                    </div>
                                    <div class="my_profile_setting_input form-group">
                                        <label for="email">{{__("E-mail")}}</label>
                                        <input type="text" class="form-control" id="email" name="email" value="{{old('email',$dataUser->email)}}" placeholder="{{__("E-mail")}}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="my_profile_setting_input form-group">
                                        <label for="first_name">{{__("First name")}}</label>
                                        <input type="text" class="form-control" id="first_name"  value="{{old('first_name',$dataUser->first_name)}}" name="first_name" placeholder="{{__("First name")}}">
                                    </div>
                                    <div class="my_profile_setting_input form-group">
                                        <label for="last_name">{{__("Last name")}}</label>
                                        <input type="text" class="form-control" id="last_name" value="{{old('last_name',$dataUser->last_name)}}" name="last_name" placeholder="{{__("Last name")}}">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="my_profile_setting_input form-group">
                                        <label for="phone">{{__("Phone Number")}}</label>
                                        <input type="text" class="form-control" id="phone" value="{{old('phone',$dataUser->phone)}}" name="phone" placeholder="{{__("Phone Number")}}">
                                    </div>
                                    <div class="my_profile_setting_input form-group">
                                        <label for="birthday">{{__("Birthday")}}</label>
                                        <input type="text" id="birthday" value="{{ old('birthday',$dataUser->birthday? display_date($dataUser->birthday) :'') }}" name="birthday" placeholder="{{__("Birthday")}}" class="form-control date-picker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <div class="my_resume_textarea">
                                <div class="form-group">
                                    <label for="bio">{{__("About Yourself")}}</label>
                                    <textarea class="form-control has-ckeditor" name="bio" id="bio" rows="7">{{old('bio',$dataUser->bio)}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my_setting_content_header style3">
                        <div class="my_sch_title">
                            <h4 class="m0">{{__("Location Information")}}</h4>
                        </div>
                    </div>
                    <div class="row my_setting_content_details pb0">
                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="address">{{__("Address")}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="address" value="{{old('address',$dataUser->address)}}" name="address" placeholder="{{__("Address")}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="address2">{{__("Address2")}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="address2" value="{{old('address2',$dataUser->address2)}}" name="address2" placeholder="{{__("Address2")}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="country">{{__("Country")}}</label>
                                <select id="country" name="country" class="form-control">
                                    <option value="">{{__('-- Select --')}}</option>
                                    @foreach(get_country_lists() as $id=>$name)
                                        <option @if((old('country',$dataUser->country ?? '')) == $id) selected @endif value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="my_setting_content_header style3">
                        <div class="my_sch_title">
                            <h4 class="m0">{{__("Social Media")}}</h4>
                        </div>
                    </div>
                    <div class="row my_setting_content_details pb0">
                        <?php $socialMediaData = json_decode($dataUser->social_media); ?>
                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="address"><i class="fa fa-skype"></i> {{__("Skype")}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="social_media[skype]" value="{{@$socialMediaData->skype}}" placeholder="{{__('Skype')}}" aria-label="{{__('Skype')}}" aria-describedby="social-skype">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="address"><i class="fa fa-facebook"></i> {{__("Facebook")}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="social_media[facebook]" value="{{@$socialMediaData->facebook}}" placeholder="{{__('Facebook')}}" aria-label="{{__('Facebook')}}" aria-describedby="social-facebook">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="address"><i class="fa fa-twitter"></i> {{__("Twitter")}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="social_media[twitter]" value="{{@$socialMediaData->twitter}}" placeholder="{{__('Twitter')}}" aria-label="{{__('Twitter')}}" aria-describedby="social-twitter">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="address"><i class="fa fa-instagram"></i> {{__("Instagram")}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="social_media[instagram]" value="{{@$socialMediaData->instagram}}" placeholder="{{__('Instagram')}}" aria-label="{{__('Instagram')}}" aria-describedby="social-instagram">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="address"><i class="fa fa-pinterest"></i> {{__("Pinterest")}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="social_media[pinterest]" value="{{@$socialMediaData->pinterest}}" placeholder="{{__('Pinterest')}}" aria-label="{{__('Pinterest')}}" aria-describedby="social-pinterest">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="address"><i class="fa fa-dribbble"></i> {{__("Dribbble")}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="social_media[dribbble]" value="{{@$socialMediaData->dribbble}}" placeholder="{{__('Dribbble')}}" aria-label="{{__('Dribbble')}}" aria-describedby="social-dribbble">
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="my_profile_setting_input2">
                                <label for="address"><i class="fa fa-google"></i> {{__("Google")}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="social_media[google]" value="{{@$socialMediaData->google}}" placeholder="{{__('Google')}}" aria-label="{{__('Google')}}" aria-describedby="social-google">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my_setting_content_header style3">
                        <div class="my_sch_title">
                            <h4 class="m0">{{__("Education")}}</h4>
                        </div>
                    </div>
                    <div class="row my_setting_content_details pb0">
                        <div class="form-group-item">
                            <div class="g-items-header">
                                <div class="row">
                                    <div class="col-md-4">{{__("Time")}}</div>
                                    <div class="col-md-3">{{__('Location')}}</div>
                                    <div class="col-md-3">{{__('Reward')}}</div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                            <div class="g-items">
                                <?php $educations = json_decode(@$dataUser->education); ?>
                                @if(!empty($educations))
                                    @foreach($educations as $key=>$item)
                                        <div class="item" data-number="{{$key}}">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <input type="text" name="education[{{$key}}][from]" class="form-control" value="{{$item->from}}" placeholder="{{__('From')}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="education[{{$key}}][to]" class="form-control" value="{{$item->to}}" placeholder="{{__('To')}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="education[{{$key}}][location]" class="form-control" value="{{$item->location}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="education[{{$key}}][reward]" class="form-control" value="{{$item->reward}}">
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                            </div>
                            <div class="g-more hide">
                                <div class="item" data-number="__number__">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="text" __name__="education[__number__][from]" class="form-control" value="" placeholder="{{__('From')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" __name__="education[__number__][to]" class="form-control" value="" placeholder="{{__('To')}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" __name__="education[__number__][location]" class="form-control" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" __name__="education[__number__][reward]" class="form-control" value="">
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my_setting_content_header style3">
                        <div class="my_sch_title">
                            <h4 class="m0">{{__("Experience")}}</h4>
                        </div>
                    </div>
                    <div class="row my_setting_content_details pb0">
                        <div class="form-group-item">
                            <div class="g-items-header">
                                <div class="row">
                                    <div class="col-md-4">{{__("Time")}}</div>
                                    <div class="col-md-3">{{__('Location')}}</div>
                                    <div class="col-md-3">{{__('Position')}}</div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                            <div class="g-items">
                                <?php $experiences = json_decode(@$dataUser->experience); ?>
                                @if(!empty($experiences))
                                    @foreach($experiences as $key=>$item)
                                        <div class="item" data-number="{{$key}}">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <input type="text" name="experience[{{$key}}][from]" class="form-control" value="{{$item->from}}" placeholder="{{__('From')}}">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="experience[{{$key}}][to]" class="form-control" value="{{$item->to}}" placeholder="{{__('To')}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="experience[{{$key}}][location]" class="form-control" value="{{$item->location}}">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="experience[{{$key}}][position]" class="form-control" value="{{$item->position}}">
                                                </div>
                                                <div class="col-md-1">
                                                    <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                            </div>
                            <div class="g-more hide">
                                <div class="item" data-number="__number__">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="text" __name__="experience[__number__][from]" class="form-control" value="" placeholder="{{__('From')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" __name__="experience[__number__][to]" class="form-control" value="" placeholder="{{__('To')}}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" __name__="experience[__number__][location]" class="form-control" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" __name__="experience[__number__][position]" class="form-control" value="">
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my_setting_content_details">
                        <div class="col-lg-12">
                            <button type="submit" class="my_setting_savechange_btn btn btn-thm">{{__('Save')}} <span class="flaticon-right-arrow-1 ml15"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('footer')
    <script>

        $('.has-ckeditor').each(function () {
            var els  = $(this);

            var id = $(this).attr('id');

            if(!id){
                id = makeid(10);
                $(this).attr('id',id);
            }
            var h  = els.data('height');
            if(!h && typeof h =='undefined') h = 300;

            tinymce.init({
                selector:'#'+id,
                plugins: 'preview searchreplace autolink fullscreen image link media codesample table charmap hr toc advlist lists wordcount imagetools textpattern help pagebreak hr',
                toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | pagebreak codesample | removeformat',
                image_advtab: true,
                image_caption: true,
                toolbar_drawer: 'sliding',
                relative_urls : false,
                height:h,
                file_picker_callback: function (callback, value, meta) {
                    /* Provide file and text for the link dialog */
                    if (meta.filetype === 'file') {
                        uploaderModal.show({
                            multiple:false,
                            file_type:'video',
                            onSelect:function (files) {
                                if(files.length)
                                    callback(bookingCore.url+'/media/preview/'+files[0].id);
                            },
                        });
                    }

                    /* Provide image and alt text for the image dialog */
                    if (meta.filetype === 'image') {
                        uploaderModal.show({
                            multiple:false,
                            file_type: file.type.includes('image') ? 'image' : 'file',
                            onSelect:function (files) {
                                if(files.length)
                                    callback(files[0].thumb_size);
                            },
                        });
                    }

                    /* Provide alternative source and posted for the media dialog */
                    if (meta.filetype === 'media') {
                        uploaderModal.show({
                            multiple:false,
                            file_type:'video',
                            onSelect:function (files) {
                                if(files.length)
                                    callback(bookingCore.url+'/media/preview/'+files[0].id);
                            },
                        });
                    }
                },
            });

        });
    </script>
@endsection
