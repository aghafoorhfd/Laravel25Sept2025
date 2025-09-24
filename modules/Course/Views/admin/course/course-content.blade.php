<div class="panel">
    <div class="panel-title"><strong>{{ __('Course Content') }}</strong></div>
    <div class="panel-body">
        <div class="form-group">
            <label>{{ __('Title') }}</label>
            <input type="text" value="{{ $translation->title }}" placeholder="{{ __('Course') }}" name="title"
                class="form-control" required>
        </div>
        <div class="form-group">
            <label class="control-label">Upload PDF</label>
           <input type="file" name="pdf_file" accept="application/pdf" class="form-control">
           @if($row->pdf_file_id)
               <div class="mt-2">
                   <a href="{{ asset('storage/' . $row->pdfFile->file_path) }}" target="_blank" class="btn btn-info btn-sm">
                       <i class="fa fa-file-pdf-o"></i> {{ __('View Current PDF') }}
                   </a>
               </div>
           @endif
        </div>
        <div class="form-group">
            <label class="control-label">{{ __('Content') }}</label>
            <div class="">
                <textarea name="content" class="d-none has-ckeditor" cols="30" rows="10">{{ $translation->content }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{ __('Description') }}</label>
            <div class="">
                <textarea name="short_desc" class="d-none has-ckeditor" cols="30" rows="10">{{ $translation->short_desc }}</textarea>
            </div>
        </div>
        @if (is_default_lang())
            <div class="form-group">
                <label class="control-label">{{ __('Category') }}</label>
                <div class="">
                    <select name="category_id" class="form-control">
                        <option value="">{{ __('-- Please Select --') }}</option>
                        <?php
                        $traverse = function ($categories, $prefix = '') use (&$traverse, $row) {
                            foreach ($categories as $category) {
                                $selected = '';
                                if ($row->category_id == $category->id) {
                                    $selected = 'selected';
                                }
                                printf("<option value='%s' %s>%s</option>", $category->id, $selected, $prefix . ' ' . $category->name);
                                $traverse($category->children, $prefix . '-');
                            }
                        };
                        $traverse($course_category);
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">{{ __('Link Video') }}</label>
                <input type="text" name="video" class="form-control" value="{{ $row->video }}"
                    placeholder="{{ __('Link video') }}">
            </div>
            <div class="form-group">
                <label class="control-label">{{ __('Duration') }}</label>
                <input type="number" name="duration" id="duration" min="0" class="form-control"
                    value="{{ $row->duration }}" placeholder="{{ __('Duration') }}">
            </div>
        @endif
        @if (is_default_lang())
            <div class="form-group">
                <label class="control-label">{{ __('Banner Image') }}</label>
                <div class="form-group-image">
                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('banner_image_id', $row->banner_image_id) !!}
                </div>
            </div>
        @endif
    </div>
</div>
@section('script.body')
@endsection
