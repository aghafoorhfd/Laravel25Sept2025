<form action="{{url(app_get_locale(false,false,'/').config('user.instructor_route_prefix'))}}" method="get">

    <div class="row">
        <div class="col-xl-4">
            <div class="instructor_search_result style2">
                <p class="mt10 fz15"><span class="color-dark pr10">{{ $rows->total() }}</span> {{__("Instructors")}} </p>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="candidate_revew_select style2 text-right mb25">
                <ul>
                    <li class="list-inline-item">
                        <div class="candidate_revew_search_box course mb30 fn-520">
                            <div class="form-inline my-2 my-lg-0">
                                <input type="search" class="form-control mr-sm-2" value="{{ Request::query("s") }}" name="s" aria-label="Search" placeholder="{{__("Search our instructors")}}">
                                <button class="btn my-2 my-sm-0" type="submit"><span class="flaticon-magnifying-glass"></span></button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</form>
