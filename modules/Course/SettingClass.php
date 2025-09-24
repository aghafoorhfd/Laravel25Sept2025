<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/2/2019
 * Time: 10:26 AM
 */
namespace  Modules\Course;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id'   => 'course',
                'title' => __("Course Settings"),
                'position'=>20,
                'view'=>"Course::admin.settings.course",
                "keys"=>[
                    'course_disable',
                    'course_page_search_title',
                    'course_page_search_banner',
                    'course_layout_search',
                    'course_location_search_style',
                    'course_enable_review',
                    'course_review_approved',
                    'course_enable_review_after_booking',
                    'course_review_number_per_page',
                    'course_review_stats',
                    'course_page_list_seo_title',
                    'course_page_list_seo_desc',
                    'course_page_list_seo_image',
                    'course_page_list_seo_share',
                    'course_booking_buyer_fees',
                    'course_vendor_create_service_must_approved_by_admin',
                    'course_allow_vendor_can_change_their_booking_status',
                    'course_search_fields',
                    'course_allow_review_after_making_completed_booking',
                ],
                'html_keys'=>[

                ]
            ]
        ];
    }
}
