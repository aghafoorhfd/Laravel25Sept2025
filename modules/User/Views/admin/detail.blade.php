@extends('admin.layouts.app')

@section('content')
    <form action="{{route('user.admin.store', ['id'=>($row->id) ? $row->id : '-1']) }}" method="post" class="needs-validation" novalidate>
        @csrf
        <div class="container">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{$row->id ? 'Edit: '.$row->getDisplayName() : 'Add new user'}}</h1>
                </div>
            </div>
            @include('admin.message')
            <div class="row">
                <div class="col-md-9">
                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('User Info')}}</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("Business name")}}</label>
                                        <input type="text" value="{{old('business_name',$row->business_name)}}" name="business_name" placeholder="{{__("Business name")}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Email')}}</label>
                                        <input type="email" required value="{{old('email',$row->email)}}" placeholder="{{ __('Email')}}" name="email" class="form-control"  >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("First name")}}</label>
                                        <input type="text" required value="{{old('first_name',$row->first_name)}}" name="first_name" placeholder="{{__("First name")}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("Last name")}}</label>
                                        <input type="text" required value="{{old('last_name',$row->last_name)}}" name="last_name" placeholder="{{__("Last name")}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Phone')}}</label>
                                        <input type="text" value="{{old('phone',$row->phone)}}" placeholder="{{ __('Phone')}}" name="phone" class="form-control" required   >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Birthday')}}</label>
                                        <input type="text" value="{{old('phone',$row->birthday)}}" placeholder="{{ __('Birthday')}}" name="birthday" class="form-control has-datepicker input-group date" id='datetimepicker1'>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Address Line 1')}}</label>
                                        <input type="text" value="{{old('address',$row->address)}}" placeholder="{{ __('Address')}}" name="address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Address Line 2')}}</label>
                                        <input type="text" value="{{old('address2',$row->address2)}}" placeholder="{{ __('Address 2')}}" name="address2" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="">{{__("Country")}}</label>
                                        <select name="country" class="form-control" id="country-sms-testing" required   >
                                            <option value="">{{__('-- Select --')}}</option>
                                            @foreach(get_country_lists() as $id=>$name)
                                                <option @if($row->country==$id) selected @endif value="{{$id}}">{{$name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{{ __('Biographical')}}</label>
                                <div class="">
                                    <textarea name="bio" class="d-none has-ckeditor" cols="30" rows="10">{{old('bio',$row->bio)}}</textarea>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('Education & Experience')}}</strong></div>
                        <div class="panel-body">
                            <h3 class="panel-body-title">{{__('Education')}}</h3>
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
                                    <?php $educations = json_decode(@$row->education); ?>
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

                            <hr>
                            <h3 class="panel-body-title">{{__('Experience')}}</h3>
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
                                    <?php $experiences = json_decode(@$row->experience); ?>
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
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('Publish')}}</strong></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>{{__('Status')}}</label>
                                <select required class="custom-select" name="status">
                                    <option value="">{{ __('-- Select --')}}</option>
                                    <option @if(old('status',$row->status) =='publish') selected @endif value="publish">{{ __('Publish')}}</option>
                                    <option @if(old('status',$row->status) =='blocked') selected @endif value="blocked">{{ __('Blocked')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{__('Role')}}</label>
                                <select required class="custom-select" name="role_id">
                                    <option value="">{{ __('-- Select --')}}</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if(!old('role_id') && $row->hasRole($role)) selected @elseif(old('role_id')  == $role->id ) selected @endif >{{ucfirst($role->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('Vendor')}}</strong></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>{{__('Vendor Commission Type')}}</label>
                                <div class="form-controls">
                                    <select name="vendor_commission_type" class="form-control">
                                        <option value="">{{__("Default")}}</option>
                                        <option value="percent" {{($row->vendor_commission_type ?? '') == 'percent' ? 'selected' : ''  }}>{{__('Percent')}}</option>
                                        <option value="amount" {{($row->vendor_commission_type ?? '') == 'amount' ? 'selected' : ''  }}>{{__('Amount')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{__('Vendor commission value')}}</label>
                                <div class="form-controls">
                                    <input type="text" class="form-control" name="vendor_commission_amount" value="{{!empty($row->vendor_commission_amount) ? $row->vendor_commission_amount:'' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('Avatar')}}</strong></div>
                        <div class="panel-body">
                            <div class="form-group">
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('avatar_id',old('avatar_id',$row->avatar_id)) !!}
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('Social Media')}}</strong></div>
                        <div class="panel-body">
                            <?php $socialMediaData = json_decode($row->social_media); ?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-skype"><i class="fa fa-skype"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[skype]" value="{{@$socialMediaData->skype}}" placeholder="{{__('Skype')}}" aria-label="{{__('Skype')}}" aria-describedby="social-skype">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-facebook"><i class="fa fa-facebook"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[facebook]" value="{{@$socialMediaData->facebook}}" placeholder="{{__('Facebook')}}" aria-label="{{__('Facebook')}}" aria-describedby="social-facebook">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-twitter"><i class="fa fa-twitter"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[twitter]" value="{{@$socialMediaData->twitter}}" placeholder="{{__('Twitter')}}" aria-label="{{__('Twitter')}}" aria-describedby="social-twitter">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-instagram"><i class="fa fa-instagram"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[instagram]" value="{{@$socialMediaData->instagram}}" placeholder="{{__('Instagram')}}" aria-label="{{__('Instagram')}}" aria-describedby="social-instagram">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-pinterest"><i class="fa fa-pinterest"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[pinterest]" value="{{@$socialMediaData->pinterest}}" placeholder="{{__('Pinterest')}}" aria-label="{{__('Pinterest')}}" aria-describedby="social-pinterest">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-dribbble"><i class="fa fa-dribbble"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[dribbble]" value="{{@$socialMediaData->dribbble}}" placeholder="{{__('Dribbble')}}" aria-label="{{__('Dribbble')}}" aria-describedby="social-dribbble">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-google"><i class="fa fa-google"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[google]" value="{{@$socialMediaData->google}}" placeholder="{{__('Google')}}" aria-label="{{__('Google')}}" aria-describedby="social-google">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <span></span>
                <button class="btn btn-primary" type="submit">{{ __('Save Change')}}</button>
            </div>
        </div>
    </form>

@endsection
@section ('script.body')
@endsection
