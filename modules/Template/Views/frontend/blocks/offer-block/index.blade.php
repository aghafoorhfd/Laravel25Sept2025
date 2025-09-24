@if(!empty($list_item))
    @foreach($list_item as $key=>$item)
        <section id="our-newslatters" class="our-newslatters">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="main-title text-center">
                            <h3 class="mt0">{{@$item['title']}}</h3>
                            <p>{{@$item['desc']}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="footer_apps_widget_home1">
                            <form action="{{@$item['link_more']}}" class="form-inline mailchimp_form">
                                <input type="email" class="form-control" placeholder="{{@$item['featured_text']}}">
                                <button type="submit" class="btn btn-lg btn-thm dbxshad">{{@$item['link_title']}} <span class="flaticon-right-arrow-1"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endif
