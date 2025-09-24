@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__('Import Template')}}</h1>

        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                    <form method="post" action="{{url('admin/module/template/importTemplate')}}" class="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="custom-file mb-3">
                            <input type="file" name="file" class="custom-file-input" id="customFile" accept="application/json">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <button  class="btn-info btn btn-icon dungdt-apply-form-btn" type="submit">{{__('Import')}}</button>
                    </form>
            </div>
        </div>
    </div>
@endsection
