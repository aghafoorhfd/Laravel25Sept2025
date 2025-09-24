<?php
namespace Modules\Vendor;

use Illuminate\Support\ServiceProvider;
use Modules\ModuleServiceProvider;
use Modules\Vendor\Models\VendorPayout;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){
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
    }


    public static function getTemplateBlocks(){
        return [
            'vendor_register_form'=>"\\Modules\\Vendor\\Blocks\\VendorRegisterForm",
        ];
    }
    public static function getUserMenu()
    {
    }
}
