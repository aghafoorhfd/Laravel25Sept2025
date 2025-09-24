<?php
namespace Modules\Report;

use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public static function getAdminMenu()
    {
        return [
            'report'=>[
                "position"=>110,
                'url'        => '#',
                'title'      => __('Reports'),
                'icon'       => 'icon ion-ios-pie',
                'permission' => 'report_view',
                'children'   => [
                    'contact'=>[
                        'url'        => 'admin/module/contact',
                        'title'      => __('Contact Submissions'),
                        'icon'       => 'icon ion ion-md-mail',
                        'permission' => 'contact_manage',
                    ],

                ]
            ],
        ];
    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
