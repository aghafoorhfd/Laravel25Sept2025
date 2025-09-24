<?php
namespace Modules\Booking;

use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        return [
            'orders'=>[
                'url'        => route('booking.admin.order.index'),
                'title'      => __('Orders'),
                'icon'       => 'icon ion ion-md-mail',
                'position'=>45,
                'permission' => 'report_view',
                ]
        ];
    }
}
