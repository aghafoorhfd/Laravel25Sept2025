<form id="course_search_form" action="{{url(app_get_locale(false,false,'/').config('course.course_route_prefix'))}}" method="get">

    <div class="row">
        <div class="col-xl-4">
            <div class="instructor_search_result style2">
                <p class="mt10 fz15"><span class="color-dark pr10">{{ $rows->total() }}</span> {{__("results")}}</p>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="candidate_revew_select style2 text-right mb25">
                <ul>
                    <li class="list-inline-item">
                        <select id="time_s" name="time_s" class="selectpicker">
                            <option value="newly">{{__("Newly published")}}</option>
                            <option value="recent">{{__("Recent")}}</option>
                        </select>
                    </li>
                    <li class="list-inline-item">
                        <div class="candidate_revew_search_box course mb30 fn-520">
                            <div class="form-inline my-2 my-lg-0">
                                <input type="search" class="form-control mr-sm-2" value="{{ Request::query("s") }}" name="s" aria-label="Search" placeholder="{{__("Search our courses")}}">
                                <button class="btn my-2 my-sm-0" type="submit"><span class="flaticon-magnifying-glass"></span></button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</form>
