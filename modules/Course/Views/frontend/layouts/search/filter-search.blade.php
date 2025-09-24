<form action="{{url(app_get_locale(false,false,'/').config('course.course_route_prefix'))}}" class="bravo_form_filter">

    <div class="selected_filter_widget style2 mb30">
        <div id="accordion" class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#panelBodySoftware" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">{{ __('Category') }}</a>
                    </h4>
                </div>
                <div id="panelBodySoftware" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="ui_kit_checkbox">
                            <?php
                            $current_category_ids = Request::query('cat_id');
                            $traverse = function ($categories, $prefix = '') use (&$traverse, $current_category_ids) {
                                $i = 0;
                                foreach ($categories as $category) {
                                    $checked = '';
                                    if (!empty($current_category_ids)) {
                                        foreach ($current_category_ids as $key => $current) {
                                            if ($current == $category->id)
                                                $checked = 'checked';
                                        }
                                    }
                                    $traslate = $category->translateOrOrigin(app()->getLocale())
                            ?>
                            <div class="custom-control custom-checkbox @if($i > 2 and empty($current_category_ids)) hide @endif">
                                <input type="checkbox" name="cat_id[]" {{$checked}} class="custom-control-input" id="category{{$category->id}}" value="{{$category->id}}">
                                <label class="custom-control-label" for="category{{$category->id}}">{{$prefix}} {{$traslate->name}} <span class="float-right">({{$category->countCourse->count()}})</span></label>
                            </div>
                            <?php
                                    $i++;
                                    $traverse($category->children, $prefix . '-');
                                }
                            };
                            $traverse($course_category);
                            ?>
                            @if(count($course_category) > 3 and empty($current_category_ids))
                            <a class="color-orose btn-more-item" href="javascript:void(0)"><span class="fa fa-plus pr10"></span> {{__("See More")}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="selected_filter_widget style2">
        <div id="accordion" class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#panelBodyAuthors" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">{{ __('Author') }}</a>
                    </h4>
                </div>
                <div id="panelBodyAuthors" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="ui_kit_checkbox">
                            <?php $current_author = Request::query('author_id'); $j = 0;
                            ?>
                            @foreach($author as $oneAuthor)
                                <?php $checked = (!empty($current_author) && in_array($oneAuthor->id, $current_author)? 'checked' : ''); ?>
                                <div class="custom-control custom-checkbox @if($j > 2 and empty($current_author)) hide @endif">
                                    <input type="checkbox" name="author_id[]" {{$checked}} class="custom-control-input" id="author{{$oneAuthor->id}}" value="{{$oneAuthor->id}}">
                                    <label class="custom-control-label" for="author{{$oneAuthor->id}}">{{$oneAuthor->getDisplayName()}} <span class="float-right">({{$oneAuthor->getCourseCount()}})</span></label>
                                </div>
                                <?php $j++; ?>
                            @endforeach
                            @if(count($author) > 3 and empty($current_author))
                                <a class="color-orose btn-more-item" href="javascript:void(0)"><span class="fa fa-plus pr10"></span> {{__("See More")}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="selected_filter_widget style2 mb30">
        <div id="accordion" class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#panelBodyPrice" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">{{__("Price")}}</a>
                    </h4>
                </div>
                <div id="panelBodyPrice" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="ui_kit_whitchbox">
                            <div class="bravo-filter-price">
                                <?php
                                $price_min = $pri_from = $course_min_max_price[0];
                                $price_max = $pri_to = $course_min_max_price[1];
                                if (!empty($price_range = Request::query('price_range'))) {
                                    $pri_from = explode(";", $price_range)[0];
                                    $pri_to = explode(";", $price_range)[1];
                                }
                                $currency = App\Currency::getCurrency(setting_item('currency_main'))
                                ?>
                                <input type="hidden" class="filter-price irs-hidden-input" name="price_range"
                                       data-symbol=" {{$currency['symbol'] ?? ''}}"
                                       data-min="{{$price_min}}"
                                       data-max="{{$price_max}}"
                                       data-from="{{$pri_from}}"
                                       data-to="{{$pri_to}}"
                                       readonly="" value="{{$price_range}}">
                                <button type="submit" class="btn btn-link btn-apply-price-range">{{__("APPLY")}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $selected = (array) Request::query('terms');
        if(!empty($countTerm)){
            $countTerm = $countTerm->toArray();
        }else{
            $countTerm = [];
        }
    @endphp
    @foreach ($attributes as $item)
        @php
            $translate = $item->translateOrOrigin(app()->getLocale());
        @endphp

        <div class="selected_filter_widget style2 mb30">
            <div id="accordion" class="panel-group">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#panelBodySkills" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">{{$translate->name}}</a>
                        </h4>
                    </div>
                    <div id="panelBodySkills" class="panel-collapse collapse show">
                        <div class="panel-body">
                            <div class="ui_kit_checkbox">
                                @foreach($item->terms as $key => $term)
                                    @php $translate = $term->translateOrOrigin(app()->getLocale()); @endphp
                                    <div class="custom-control custom-checkbox @if($key > 2 and empty($selected)) hide @endif">
                                        <input type="checkbox" name="terms[]" value="{{$term->id}}" @if(in_array($term->id,$selected)) checked @endif class="custom-control-input" id="term{{$term->id}}">
                                        <label class="custom-control-label" for="term{{$term->id}}">{!! clean($translate->name) !!}
                                            @php $courseWithTerm = \Arr::first($countTerm, function ($value, $key) use($term) { if($value['term_id'] == $term->id) {return $value['total'];}  }); @endphp
                                            <span class="float-right">({{intval($courseWithTerm['total'])}})</span>
                                        </label>
                                    </div>
                                @endforeach
                                @if(count($item->terms) > 3 and empty($selected))
                                    <a class="color-orose btn-more-item" href="javascript:void(0)"><span class="fa fa-plus pr10"></span> {{__("See More")}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <div class="selected_filter_widget style2">
        <div id="accordion" class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#panelBodyRating" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">{{__("Rating")}}</a>
                    </h4>
                </div>
                <div id="panelBodyRating" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="ui_kit_checkbox style2">
                            @for ($number = 5 ;$number >= 1 ; $number--)
                                <div class="custom-control custom-checkbox">
                                    <input name="review_score[]" type="checkbox" class="custom-control-input" id="customCheck8{{$number}}" value="{{$number}}" @if(  in_array($number , request()->query('review_score',[])) )  checked @endif>
                                    <label class="custom-control-label" for="customCheck8{{$number}}">{{$number}} star and higher <span class="float-right">(15)</span></label>
                                    <span class="checkmark"></span>

                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="selected_filter_widget style2">
        <span class="float-left"><img class="mr20" src="/dist/frontend/module/course/images/resource/2.png" alt="2.png"></span>
        <h4 class="mt15 fz20 fw500">{{__("Not sure?")}}</h4>
        <br>
        <p>{{__("Every course comes with a 30-day money-back guarantee")}}</p>
    </div>
</form>


