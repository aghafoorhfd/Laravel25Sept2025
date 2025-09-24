<div class="row">
    @if($rows->total() > 0)
        @foreach($rows as $row)
            <div class="col-lg-6 col-xl-4">
                @include('Course::frontend.layouts.search.loop-gird')
            </div>
        @endforeach
        {{$rows->appends(request()->query())->links('Course::frontend.layouts.search.paging')}}
    @else
        <div class="col-lg-12">
            {{__("Course not found")}}
        </div>
    @endif


</div>


