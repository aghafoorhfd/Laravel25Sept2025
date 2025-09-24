<?php
$dataUser = Auth::user();
$menus = [
    'dashboard'       => [
        'url'        => route("vendor.dashboard"),
        'title'      => __("Dashboard"),
        'icon'       => 'fa fa-home',
        'permission' => 'dashboard_vendor_access',
        'position'   => 10
    ],
    [
        'url'   => route("user.wishList.index"),
        'title' => __("Wishlist"),
        'icon'  => 'fa fa-heart-o',
        'position' => 21
    ],
    'profile'         => [
        'url'      => route("user.profile.index"),
        'title'    => __("My Profile"),
        'icon'     => 'fa fa-cogs',
        'position' => 40
    ],
    'password'        => [
        'url'      => route("user.change_password"),
        'title'    => __("Change password"),
        'icon'     => 'fa fa-lock',
        'position' => 50
    ],
    'admin'           => [
        'url'        => 'admin',
        'title'      => __("Admin Dashboard"),
        'icon'       => 'icon ion-ios-ribbon',
        'permission' => 'dashboard_access',
        'position'   => 60
    ]
];

// Modules
$custom_modules = \Modules\ServiceProvider::getModules();
if(!empty($custom_modules)){
    foreach($custom_modules as $module){
        $moduleClass = "\\Modules\\".ucfirst($module)."\\ModuleProvider";
        if(class_exists($moduleClass))
        {
            $menuConfig = call_user_func([$moduleClass,'getUserMenu']);
            if(!empty($menuConfig)){
                $menus = array_merge($menus,$menuConfig);
            }
            $menuSubMenu = call_user_func([$moduleClass,'getUserSubMenu']);
            if(!empty($menuSubMenu)){
                foreach($menuSubMenu as $k=>$submenu){
                    $submenu['id'] = $submenu['id'] ?? '_'.$k;
                    if(!empty($submenu['parent']) and isset($menus[$submenu['parent']])){
                        $menus[$submenu['parent']]['children'][$submenu['id']] = $submenu;
                        $menus[$submenu['parent']]['children'] = array_values(\Illuminate\Support\Arr::sort($menus[$submenu['parent']]['children'], function ($value) {
                            return $value['position'] ?? 100;
                        }));
                    }
                }
            }
        }
    }
}

// Custom Menu
$custom_modules = \Custom\ServiceProvider::getModules();
if(!empty($custom_modules)){
    foreach($custom_modules as $module){
        $moduleClass = "\\Custom\\".ucfirst($module)."\\ModuleProvider";
        if(class_exists($moduleClass))
        {
            $menuConfig = call_user_func([$moduleClass,'getUserMenu']);
            if(!empty($menuConfig)){
                $menus = array_merge($menus,$menuConfig);
            }
            $menuSubMenu = call_user_func([$moduleClass,'getUserSubMenu']);
            if(!empty($menuSubMenu)){
                foreach($menuSubMenu as $k=>$submenu){
                    $submenu['id'] = $submenu['id'] ?? '_'.$k;
                    if(!empty($submenu['parent']) and isset($menus[$submenu['parent']])){
                        $menus[$submenu['parent']]['children'][$submenu['id']] = $submenu;
                        $menus[$submenu['parent']]['children'] = array_values(\Illuminate\Support\Arr::sort($menus[$submenu['parent']]['children'], function ($value) {
                            return $value['position'] ?? 100;
                        }));
                    }
                }
            }
        }
    }
}
// Plugins Menu
$plugins_modules = \Plugins\ServiceProvider::getModules();
if(!empty($plugins_modules)){
    foreach($plugins_modules as $module){
        $moduleClass = "\\Plugins\\".ucfirst($module)."\\ModuleProvider";
        if(class_exists($moduleClass))
        {
            $menuConfig = call_user_func([$moduleClass,'getUserMenu']);
            if(!empty($menuConfig)){
                $menus = array_merge($menus,$menuConfig);
            }
            $menuSubMenu = call_user_func([$moduleClass,'getUserSubMenu']);
            if(!empty($menuSubMenu)){
                foreach($menuSubMenu as $k=>$submenu){
                    $submenu['id'] = $submenu['id'] ?? '_'.$k;
                    if(!empty($submenu['parent']) and isset($menus[$submenu['parent']])){
                        $menus[$submenu['parent']]['children'][$submenu['id']] = $submenu;
                        $menus[$submenu['parent']]['children'] = array_values(\Illuminate\Support\Arr::sort($menus[$submenu['parent']]['children'], function ($value) {
                            return $value['position'] ?? 100;
                        }));
                    }
                }
            }
        }
    }
}

$currentUrl = url(Illuminate\Support\Facades\Route::current()->uri());
if (!empty($menus))
    $menus = array_values(\Illuminate\Support\Arr::sort($menus, function ($value) {
        return $value['position'] ?? 100;
    }));
    foreach ($menus as $k => $menuItem) {
        if (!empty($menuItem['permission']) and !Auth::user()->hasPermissionTo($menuItem['permission'])) {
            unset($menus[$k]);
            continue;
        }
        $menus[$k]['class'] = $currentUrl == url($menuItem['url']) ? 'active' : '';
        if (!empty($menuItem['children'])) {
            $menus[$k]['class'] .= ' has-children d-inline-block w-100 h-auto';
            foreach ($menuItem['children'] as $k2 => $menuItem2) {
                if (!empty($menuItem2['permission']) and !Auth::user()->hasPermissionTo($menuItem2['permission'])) {
                    unset($menus[$k]['children'][$k2]);
                    continue;
                }
                $menus[$k]['children'][$k2]['class'] = $currentUrl == url($menuItem2['url']) ? 'active active_child' : '';
            }
        }
    }
?>
<section class="dashboard_sidebar dn-1199">
    <div class="dashboard_sidebars">
        <div class="user_board">
            <div class="user_profile">
                <div class="media">
                    <div class="media-body">
                        <h4 class="mt-0">{{$dataUser->getDisplayName()}}</h4>
                    </div>
                </div>
            </div>
            <div class="dashbord_nav_list">
                <ul>
                    @foreach($menus as $menuItem)
                        <li class="{{$menuItem['class']}}">
                            <a href="{{ url($menuItem['url']) }}" class="@if(!empty($menuItem['children'])) first-node @else d-block @endif">
                                @if(!empty($menuItem['icon']))
                                    <span class="icon text-center"><i class="{{$menuItem['icon']}}"></i></span>
                                @endif
                                {!! clean($menuItem['title']) !!}
                            </a>
                            @if(!empty($menuItem['children']))
                                <ul class="children">
                                    @foreach($menuItem['children'] as $menuItem2)
                                        <li class="{{$menuItem2['class']}}"><a class="d-block" href="{{ url($menuItem2['url']) }}">
                                                @if(!empty($menuItem2['icon']))
                                                    <i class="{{$menuItem2['icon']}}"></i>
                                                @endif
                                                {!! clean($menuItem2['title']) !!}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
