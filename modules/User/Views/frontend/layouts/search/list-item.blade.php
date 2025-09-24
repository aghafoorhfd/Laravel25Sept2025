<div class="row">
    @if($rows->total() > 0)
        @foreach($rows as $row)
            <div class="col-sm-6 col-lg-6 col-xl-4">
                @include('User::frontend.layouts.search.loop-gird',['slider'=>false])
            </div>
        @endforeach
    @else
        <div class="col-lg-12">
            {{__("Instructor not found")}}
        </div>
    @endif

        {{$rows->appends(request()->query())->links('User::frontend.layouts.search.paging')}}
</div>


