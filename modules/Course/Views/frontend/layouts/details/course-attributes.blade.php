@php
    $terms_ids = $row->course_term->pluck('term_id');
    $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
@endphp
@if(!empty($terms_ids) and !empty($attributes))
    @foreach($attributes as $attribute )
        @php $translate_attribute = $attribute['parent']->translateOrOrigin(app()->getLocale()) @endphp
        <li class="d-flex justify-content-between align-items-center">
            {{ $translate_attribute->name }}
            <span class="float-right text-right">
               @foreach($attribute['child'] as $term )
                    @php $translate_term = $term->translateOrOrigin(app()->getLocale()) @endphp
                    {{ $translate_term->name }}<br/>
                @endforeach
            </span>
        </li>
    @endforeach
@endif
