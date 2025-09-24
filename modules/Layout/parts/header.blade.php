
<header class="@if(!empty($is_user_page))
    header-nav menu_style_home_one dashbord_pages navbar-scrolltofixed stricky main-menu
@else
    header-nav menu_style_home_one navbar-scrolltofixed stricky main-menu
@endif
">

    <div class="container-fluid">

        <nav>

            <?php $logo = ''; ?>
            @if($logo_id = setting_item("logo_id"))
                <?php $logo = get_file_url($logo_id,'full') ?>
            @endif
            <?php $logo_sub = ''; ?>
            @if($logo_sub_id = setting_item("logo_sub_id"))
                <?php $logo_sub = get_file_url($logo_sub_id,'full') ?>
            @endif
            <div class="menu-toggle">
                <img class="nav_logo_img img-fluid" src="{{$logo}}" alt="{{setting_item("site_title")}}">
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <a href="{{url(app_get_locale(false,'/'))}}" class="navbar_brand float-left dn-smd">
                <div>
                    @if(!empty($logo))
                        <img class="logo1 img-fluid" src="{{$logo}}" alt="{{setting_item("site_title")}}">
                    @endif
                    @if(!empty($logo_sub))
                        <img class="logo2 img-fluid" src="{{$logo_sub}}" alt="{{setting_item("site_title")}}">
                    @endif
                </div>
               
                 <div style="margin-top: 4px;">

                    <span style="font-size: 31px; font-weight:800;">KCS</span>
                    <p style="color:white; margin-top:5px">King Cambridge Solutions</p>
                </div>
            </a>


            <?php generate_menu('primary') ?>

            <ul class="sign_up_btn pull-right dn-smd @if(Auth::id()) mt20 @endif">
                <li class="list-inline-item list_s">
                    <ul id="userPanel" class="ace-responsive-menu " data-menu-style="horizontal">
                        @if(!Auth::id())
                            <li>
                                <a href="#" class="btn flaticon-user" data-toggle="modal" data-target="#login"> <span class="dn-lg">{{__('Login/Register')}}</span></a>
                                 <span class="btn flaticon-user" style="color: white;"><span class="dn-lg">No of visitor :</span>{{ $visitorCount }}</span>
                           
                            </li>
                        @else
                            <li>
                                <a href="#" class="btn flaticon-user user_heading"><span class="title">{{__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])}}</span></a>
                                 <span class="btn flaticon-user" style="color: white;"><span class="dn-lg">No of visitor :</span>{{ $visitorCount }}</span>
                                <ul>
                                    @if(Auth::user()->hasPermissionTo('dashboard_vendor_access'))
                                        <li><a href="{{route('vendor.dashboard')}}"><i class="icon ion-md-analytics"></i> {{__("Instructor Dashboard")}}</a></li>
                                        <li><a href="{{route('course.vendor.index')}}"><i class="{{\Modules\Course\Models\Course::getServiceIconFeatured()}}"></i> {{__("Manage Course")}}</a></li>
                                    @endif
                                    <li>
                                        <a href="{{route('user.profile.index')}}"><i class="icon ion-md-construct"></i> {{__("My profile")}}</a>
                                    </li>
                                    <li><a href="{{route('vendor.booking_history')}}"><i class="fa fa-clock-o"></i> {{__("Order History")}}</a></li>
                                    <li><a href="{{route('user.change_password')}}"><i class="fa fa-lock"></i> {{__("Change password")}}</a></li>
                                    @if(Auth::user()->hasPermissionTo('dashboard_access'))
                                        <li><a href="{{url('/admin')}}"><i class="icon ion-ios-ribbon"></i> {{__("Admin Dashboard")}}</a></li>
                                    @endif
                                    <li>
                                        <a  href="#" onclick="event.preventDefault(); document.getElementById('logout-form-topbar').submit();"><i class="fa fa-sign-out"></i> {{__('Logout')}}</a>
                                    </li>
                                </ul>
                            </li>
                            <form id="logout-form-topbar" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                    </ul>
                </li>
                <li class="list-inline-item list_s @if(!Auth::id()) mt20 @endif">
                    <div class="cart_btn">
                        <ul class="cart">
                            <li>
                                <a href="{{route('booking.cart')}}" class="btn cart_btn flaticon-shopping-bag"><span>
                                        {{Cart::count()}}
                                    </span></a>
                                <ul class="dropdown_content">
                                    @include('Booking::frontend.cart.mini-cart')
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="list-inline-item list_s">
                    <div class="search_overlay">
                        <a id="search-button-listener" class="mk-search-trigger mk-fullscreen-trigger" href="#">
                            <span id="search-button"><i class="flaticon-magnifying-glass"></i></span>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</header>

<div class="sign_up_modal modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <ul class="sign_up_tab nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{__('Login')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{__('Register')}}</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                @if(!Auth::id())
                    <li class="login-item">
                        <a href="#login" data-toggle="modal" data-target="#login" class="login">{{__('Login')}}</a>
                    </li>
                    <li class="signup-item">
                        <a href="#register" data-toggle="modal" data-target="#register" class="signup">{{__('Sign Up')}}</a>
                    </li>
                @else
                    <li class="login-item dropdown">
                        <a href="#" data-toggle="dropdown" class="is_login">
                            @if($avatar_url = Auth::user()->getAvatarUrl())
                                <img class="avatar" src="{{$avatar_url}}" alt="{{ Auth::user()->getDisplayName()}}">
                            @else
                                <span class="avatar-text">{{ucfirst( Auth::user()->getDisplayName()[0])}}</span>
                            @endif
                            {{__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])}}
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu text-left">
                            @if(Auth::user()->hasPermissionTo('dashboard_vendor_access'))
                                <li><a href="{{route('vendor.dashboard')}}"><i class="icon ion-md-analytics"></i> {{__("Instructor Dashboard")}}</a></li>
                                <li><a href="{{route('course.vendor.index')}}"><i class="{{\Modules\Course\Models\Course::getServiceIconFeatured()}}"></i> {{__("Manage Course")}}</a></li>
                            @endif
                            <li class="@if(Auth::user()->hasPermissionTo('dashboard_vendor_access')) menu-hr @endif">
                                <a href="{{route('user.profile.index')}}"><i class="icon ion-md-construct"></i> {{__("My profile")}}</a>
                            </li>
                            <li><a href="{{route('vendor.booking_history')}}"><i class="fa fa-clock-o"></i> {{__("Order History")}}</a></li>
                            <li><a href="{{route('user.change_password')}}"><i class="fa fa-lock"></i> {{__("Change password")}}</a></li>
                            @if(Auth::user()->hasPermissionTo('dashboard_access'))
                                <li class="menu-hr"><a href="{{url('/admin')}}"><i class="icon ion-ios-ribbon"></i> {{__("Admin Dashboard")}}</a></li>
                            @endif
                            <li class="menu-hr">
                                <a  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> {{__('Logout')}}</a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="login_form">
                        <form action="#">
                            <div class="heading">
                                <h3 class="text-center">{{__('Login to your account')}}</h3>
                                <p class="text-center">{{__("Don't have an account?")}} <a class="text-thm" href="#">{{__('Sign Up!')}}</a></p>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-group custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="exampleCheck1">
                                <label class="custom-control-label" for="exampleCheck1">{{__('Remember me')}}</label>
                                <a class="tdu btn-fpswd float-right" href="#">Forgot Password?</a>
                            </div>
                            <button type="submit" class="btn btn-log btn-block btn-thm2">{{__('Login')}}</button>
                            <hr>
                            <div class="row mt40">
                                <div class="col-lg">
                                    <button type="submit" class="btn btn-block color-white bgc-fb"><i class="fa fa-facebook float-left mt5"></i> {{__('Facebook')}}</button>
                                </div>
                                <div class="col-lg">
                                    <button type="submit" class="btn btn-block color-white bgc-gogle"><i class="fa fa-google float-left mt5"></i> {{__('Google')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="sign_up_form">
                        <div class="heading">
                            <h3 class="text-center">{{__('Create New Account')}}</h3>
                            <p class="text-center">{{__('Have an account?')}} <a class="text-thm" href="#">{{__('Login')}}</a></p>
                        </div>
                        <form action="#">
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputName1" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Confirm Password">
                            </div>
                            <div class="form-group custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="exampleCheck2">
                                <label class="custom-control-label" for="exampleCheck2">{{__('Want to become an instructor?')}}</label>
                            </div>
                            <button type="submit" class="btn btn-log btn-block btn-thm2">{{__('Register')}}</button>
                            <hr>
                            <div class="row mt40">
                                <div class="col-lg">
                                    <button type="submit" class="btn btn-block color-white bgc-fb"><i class="fa fa-facebook float-left mt5"></i> {{__('Facebook')}}</button>
                                </div>
                                <div class="col-lg">
                                    <button type="submit" class="btn btn-block color-white bgc-gogle"><i class="fa fa-google float-left mt5"></i> {{__('Google')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="page" class="stylehome1 h0">
    <div class="mobile-menu">
        <div class="header stylehome1">
            <div class="main_logo_home2">
                <img class="nav_logo_img img-fluid float-left mt20" src="{{$logo}}" alt="{{setting_item("site_title")}}">
                <span>{{setting_item("site_title")}}</span>
            </div>
            <ul class="menu_bar_home2">
                <li class="list-inline-item"><a href="#menu"><span></span></a></li>
            </ul>
        </div>
    </div>
    <nav id="menu" class="stylehome1">
        <?php generate_menu('primary', ['device'=> 'mobile']) ?>
    </nav>
</div>








