<section id="top-courses" class="top-courses pb30">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="main-title text-center">
                    <h3 class="mt0">{{@$title}}</h3>
                    <p>{{@$sub_title}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="options" class="alpha-pag full">
                    <div class="option-isotop">
                        <ul id="filter" class="option-set" data-option-key="filter">
                            <li class="list-inline-item"><a href="#all" data-option-value="*" class="selected">All</a></li>
                            @foreach($rows as $key => $oneRow)
                                <li class="list-inline-item"><a href="#{{$oneRow['slug']}}" data-option-value=".{{$oneRow['slug']}}">{{$oneRow['name']}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- FILTER BUTTONS -->
                <div class="emply-text-sec">
                    <div class="row" id="masonry_abc">
                        @foreach($rows as $key => $oneRow)
                            @foreach($oneRow['data'] as $row)
                                <div class="col-md-6 col-lg-4 col-xl-3 {{$oneRow['slug']}}">
                                    @include('Course::frontend.layouts.search.loop-gird')
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


