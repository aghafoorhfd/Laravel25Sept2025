<?php
namespace Modules\Course;

use Illuminate\Support\ServiceProvider;
use Modules\ModuleServiceProvider;
use Modules\Course\Models\Course;

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

    public static function getBookableServices()
    {
        return [
            'course' => Course::class,
        ];
    }

    public static function getAdminMenu()
    {
        $res = [];
        if(Course::isEnable()){
            $res['course'] = [
                "position"=>40,
                'url'        => 'admin/module/course',
                'title'      => __("Course"),
                'icon'       => 'icon ion-md-umbrella',
                'permission' => 'course_view',
                'children'   => [
                    'course_view'=>[
                        'url'        => 'admin/module/course',
                        'title'      => __('All Courses'),
                        'permission' => 'course_view',
                    ],
                    'course_create'=>[
                        'url'        => 'admin/module/course/create',
                        'title'      => __("Add Course"),
                        'permission' => 'course_create',
                    ],
                    'course_category'=>[
                        'url'        => 'admin/module/course/category',
                        'title'      => __('Categories'),
                        'permission' => 'course_manage_others',
                    ],
                    'course_attribute'=>[
                        'url'        => 'admin/module/course/attribute',
                        'title'      => __('Attributes'),
                        'permission' => 'course_manage_attributes',
                    ],
                    'course_tag'=>[
                        'url'        => 'admin/module/course/tag',
                        'title'      => __('Tags'),
                        'permission' => 'course_create',
                    ],
                ]
            ];
        }
        return $res;
    }


    public static function getUserMenu()
    {
        $res = [];
        if(Course::isEnable()){
            $res['course'] = [
                'url'   => '#',
                'title'      => __("Manage Course"),
                'icon'       => Course::getServiceIconFeatured(),
                'permission' => 'course_view',
                'position'   => 30,
                'children'   => [
                    [
                        'url'   => route('course.vendor.index'),
                        'title' => "All Courses",
                    ],
                    [
                        'url'        => route('course.vendor.create'),
                        'title'      => "Add Course",
                        'permission' => 'course_create',
                    ],
                    [
                        'url'   => route('course.vendor.orders'),
                        'title'      => __("Course Orders"),
                        'permission' => 'course_view',
                        'position'   => 31,
                    ]
                ]
            ];
        }
        return $res;
    }

    public static function getMenuBuilderTypes()
    {
        if(!Course::isEnable()) return [];

        return [
            [
                'class' => \Modules\Course\Models\Course::class,
                'name'  => __("Course"),
                'items' => \Modules\Course\Models\Course::searchForMenu(),
                'position'=>20
            ],
            [
                'class' => \Modules\Course\Models\CourseCategory::class,
                'name'  => __("Course Category"),
                'items' => \Modules\Course\Models\CourseCategory::searchForMenu(),
                'position'=>30
            ],
        ];
    }

    public static function getTemplateBlocks(){
        if(!Course::isEnable()) return [];

        return [
            'list_courses'=>"\\Modules\\Course\\Blocks\\ListCourses",
            'form_search_course'=>"\\Modules\\Course\\Blocks\\FormSearchCourse",
            // 'list_categories'=>"\\Modules\\Course\\Blocks\\ListCategories",
            // 'categories_with_items'=>"\\Modules\\Course\\Blocks\\CategoriesWithItems",
        ];
    }
}
