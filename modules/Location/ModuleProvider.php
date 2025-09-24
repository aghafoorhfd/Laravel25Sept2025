<?php
namespace Modules\Location;

use Illuminate\Support\ServiceProvider;
use Modules\ModuleServiceProvider;

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

        return [];
    }
    public static function getTemplateBlocks(){
        return [
            'list_locations'=>"\\Modules\\Location\\Blocks\\ListLocations",
        ];
    }
}
