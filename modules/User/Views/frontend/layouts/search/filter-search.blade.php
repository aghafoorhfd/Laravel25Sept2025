<form action="{{url(app_get_locale(false,false,'/').config('user.instructor_route_prefix'))}}" class="bravo_form_filter">

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
                        <a href="#panelBodyRating" class="accordion-toggle link fz20 mb15" data-toggle="collapse" data-parent="#accordion">{{__("Rating")}}</a>
                    </h4>
                </div>
                <div id="panelBodyRating" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="ui_kit_checkbox style2">
                            @for ($number = 5 ;$number >= 1 ; $number--)
                                <div class="custom-control custom-checkbox">
                                    <input name="review_score[]" type="checkbox" class="custom-control-input" id="customCheck8{{$number}}" value="{{$number}}" @if(  in_array($number , request()->query('review_score',[])) )  checked @endif>
                                    <label class="custom-control-label" for="customCheck8{{$number}}">{{$number}} {{__('star and higher')}} <span class="float-right">(15)</span></label>
                                    <span class="checkmark"></span>

                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


