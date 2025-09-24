<?php
namespace Modules\Template;

use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
	    $this->app->register(RouterServiceProvider::class);

    }

    public static function getTemplateBlocks(){
        return [
            'text'=>"\\Modules\\Template\\Blocks\\Text",
            'video_player'=>"\\Modules\\Template\\Blocks\\VideoPlayer",
            'faqs'=>"\\Modules\\Template\\Blocks\\FaqList",
            'list_featured_item'=>"\\Modules\\Template\\Blocks\\ListFeaturedItem",
            'form_search_all_service'=>"\\Modules\\Template\\Blocks\\FormSearchAllService",
            'slide'=>"\\Modules\\Template\\Blocks\\Slide",
            'testimonial'=>"\\Modules\\Template\\Blocks\\Testimonial",
            'parallax'=>"\\Modules\\Template\\Blocks\\Parallax",
            'app_download'=>"\\Modules\\Template\\Blocks\\AppDownload",
            'partner'=>"\\Modules\\Template\\Blocks\\Partner",
            'counter'=>"\\Modules\\Template\\Blocks\\CounterNumber",
        ];
    }
}
