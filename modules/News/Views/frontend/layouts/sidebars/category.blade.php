@php
    $list_category = $model_category->with('translations')->get()->toTree();
@endphp
@if(!empty($list_category))
    <div class="blog_category_widget">
        <ul class="list-group">
            <h4 class="title">{{ $item->title }}</h4>
            <?php
            $traverse = function ($categories, $prefix = '') use (&$traverse) {
            foreach ($categories as $category) {
            $translation = $category->translateOrOrigin(app()->getLocale());
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ $category->getDetailUrl() }}"><h5>{{$prefix}} {{$translation->name}}</h5></a> <span class="float-right">{{ $category->countNews() }}</span>
            </li>
            <?php
            $traverse($category->children, $prefix . '-');
            }
            };
            $traverse($list_category);
            ?>
        </ul>
    </div>
@endif
