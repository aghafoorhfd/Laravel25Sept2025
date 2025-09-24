@if($list_item)
    <section id="our-testimonials" class="our-testimonials">
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
                <div class="col-lg-6 offset-lg-3">
                    <div class="testimonialsec">
                        <ul class="tes-nav">
                            @foreach($list_item as $item)
                                <?php $avatar_url = get_file_url(@$item['avatar'], 'full') ?>
                                    <li>
                                        <img class="img-fluid" src="{{$avatar_url}}" alt="{{@$item['name']}}"/>
                                    </li>
                            @endforeach
                        </ul>
                        <ul class="tes-for">
                            @foreach($list_item as $item)
                                <li>
                                    <div class="testimonial_item">
                                        <div class="details">
                                            <h5>{{@$item['name']}}</h5>
                                            <span class="small text-thm">{{@$item['job']}}</span>
                                            <p>{{@$item['desc']}}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
