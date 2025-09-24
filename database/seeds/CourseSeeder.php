<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Media\Models\MediaFile;
use Modules\Course\Models\CourseCategory;

use Modules\Review\Models\Review;
use Modules\Review\Models\ReviewMeta;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            ['name' => 'Photoshop', 'image_id' => MediaFile::findMediaByName("category-1")->id, 'content' => '', 'status' => 'publish',],
            ['name' => 'Adobe Illustrator', 'image_id' => MediaFile::findMediaByName("category-2")->id, 'content' => '', 'status' => 'publish',],
            ['name' => 'Graphic Design', 'image_id' => MediaFile::findMediaByName("category-3")->id, 'content' => '', 'status' => 'publish',],
            ['name' => 'Sketch', 'image_id' => MediaFile::findMediaByName("category-4")->id, 'content' => '', 'status' => 'publish',],
            ['name' => 'InDesign', 'image_id' => MediaFile::findMediaByName("category-5")->id, 'content' => '', 'status' => 'publish',],
            ['name' => 'CorelDRAW', 'image_id' => MediaFile::findMediaByName("category-6")->id, 'content' => '', 'status' => 'publish',],
            ['name' => 'After Effects', 'image_id' => MediaFile::findMediaByName("category-7")->id, 'content' => '', 'status' => 'publish',],
            ['name' => 'Video Editor', 'image_id' => MediaFile::findMediaByName("category-8")->id, 'content' => '', 'status' => 'publish',]
        ];

        foreach ($categories as $category) {
            $row = new CourseCategory($category);
            $row->save();
        }

        $list_gallery = [];
        for ($i = 1; $i <= 7; $i++) {
            $list_gallery[] = MediaFile::findMediaByName("gallery-" . $i)->id;
        }
        $IDs_vendor[] = $create_user = 1;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Introduction Web Design with HTML',
                'slug' => Str::slug('Introduction Web Design with HTML', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-1")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-1")->id,
                'category_id' => 1,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "1",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 1;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Designing a Responsive Mobile Website with Muse',
                'slug' => Str::slug('Designing a Responsive Mobile Website with Muse', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-2")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-2")->id,
                'category_id' => 1,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "1",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 2;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Adobe XD: Prototyping Tips and Tricks',
                'slug' => Str::slug('Adobe XD: Prototyping Tips and Tricks', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-3")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-3")->id,
                'category_id' => 2,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "1",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 2;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Sketch: Creating Responsive SVG',
                'slug' => Str::slug('Sketch: Creating Responsive SVG', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-4")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-4")->id,
                'category_id' => 2,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "0",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 3;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Design Instruments for Communication',
                'slug' => Str::slug('Design Instruments for Communication', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-5")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-5")->id,
                'category_id' => 3,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "1",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 3;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'How to be a DJ? Make Electronic Music',
                'slug' => Str::slug('How to be a DJ? Make Electronic Music', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-6")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-6")->id,
                'category_id' => 3,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "0",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 4;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'How to Make Beautiful Landscape Photos?',
                'slug' => Str::slug('How to Make Beautiful Landscape Photos?', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-7")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-7")->id,
                'category_id' => 4,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "1",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 4;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Fashion Photography From Professional',
                'slug' => Str::slug('Fashion Photography From Professional', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-8")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-8")->id,
                'category_id' => 4,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "0",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 5;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'The Complete 2020 Web Development Bootcamp',
                'slug' => Str::slug('The Complete 2020 Web Development Bootcamp', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-9")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-9")->id,
                'category_id' => 5,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "0",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 5;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'The Ultimate Drawing Course - Beginner to Advanced',
                'slug' => Str::slug('The Ultimate Drawing Course - Beginner to Advanced', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-10")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-10")->id,
                'category_id' => 5,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "0",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 1;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Illustrator CC 2020 MasterClass Drawing Course',
                'slug' => Str::slug('Illustrator CC 2020 MasterClass', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-11")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-11")->id,
                'category_id' => 6,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "1",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 1;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'After Effects CC 2020: Complete Expert Course',
                'slug' => Str::slug('After Effects CC 2020: Complete Expert Course', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-12")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-12")->id,
                'category_id' => 6,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "0",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 2;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Ultimate Photoshop Training: From Beginner to Pro',
                'slug' => Str::slug('Ultimate Photoshop Training: From Beginner to Pro', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-13")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-13")->id,
                'category_id' => 7,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "0",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 2;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Character Art School: Complete Painting Course',
                'slug' => Str::slug('Character Art School: Complete Painting Course', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-14")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-14")->id,
                'category_id' => 7,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "0",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 3;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Creating 3D environments in Blender',
                'slug' => Str::slug('Creating 3D environments in Blender', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-15")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-15")->id,
                'category_id' => 8,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "1",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        $IDs_vendor[] = $create_user = 3;
        $IDs[] = DB::table('bravo_courses')->insertGetId(
            [
                'title' => 'Wordpress for Beginners - Master Wordpress Quickly',
                'slug' => Str::slug('Wordpress for Beginners - Master Wordpress Quickly', '-'),
                'content' => "<h4 class=\"subtitle\">Course Description</h4><p class=\"mb30\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p><p class=\"mb20\">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h4 class=\"subtitle\">What you'll learn</h4><ul class=\"cs_course_syslebus\"><li><p>Become a UX designer.</p></li><li><p>You will be able to add UX designer to your CV</p></li><li><p>Become a UI designer.</p></li><li><p>Build &amp; test a full website design.</p></li><li><p>Build &amp; test a full mobile app.</p></li></ul><ul class=\"cs_course_syslebus2\"><li><p>Learn to design websites &amp; mobile phone apps.</p></li> <li><p>You'll learn how to choose colors.</p></li><li><p>Prototype your designs with interactions.</p></li><li><p>Export production ready assets.</p></li><li><p>All the techniques used by UX professionals</p></li></ul><h4 class=\"subtitle\">Requirements</h4><ul class=\"list_requiremetn\"><li><p>You will need a copy of Adobe XD 2019 or above. A free trial can be downloaded from Adobe.</p>                                </li>                                <li><p>No previous design experience is needed.</p></li><li><p>No previous Adobe XD skills are needed.</p></li></ul>",
                'image_id' => MediaFile::findMediaByName("course-16")->id,
                'banner_image_id' => MediaFile::findMediaByName("banner-course-16")->id,
                'category_id' => 8,
                'short_desc' => "<h5 class=\"subtitle text-left\">Includes</h5>                                 <ul class=\"price_quere_list text-left\">                                     <li><a href=\"#\"><span class=\"flaticon-play-button-1\"></span> 11 hours on-demand video</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-download\"></span> 69 downloadable resources</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-key-1\"></span> Full lifetime access</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-responsive\"></span> Access on mobile and TV</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-flash\"></span> Assignments</a></li>                                     <li><a href=\"#\"><span class=\"flaticon-award\"></span> Certificate of Completion</a></li>                                 </ul>",
                'is_featured' => "0",
                'gallery' => implode(",", $list_gallery),
                'video' => "//www.youtube.com/embed/57LQI8DKwec",
                'price' => rand(200, 400),
                'sale_price' => rand(100, 200),
                'duration' => 1360,
                'faqs' => null,
                'status' => "publish",
                'create_user' => $create_user,
                'created_at' => date("Y-m-d H:i:s"),
            ]);


        // Add meta for course
        foreach ($IDs as $numer_key => $course) {
            $vendor_id = $IDs_vendor[$numer_key];
            DB::table('bravo_course_meta')->insertGetId(
                [
                    'course_id' => $course,
                    'enable_person_types' => '1',
                    'person_types' => '[{"name":"Adult","desc":"Age 18+","min":"1","max":"10","price":"1000"},{"name":"Child","desc":"Age 6-17","min":"0","max":"10","price":"300"}]',
                    'enable_extra_price' => '1',
                    'extra_price' => '[{"name":"Clean","price":"100","type":"one_time"}]',
                ]
            );
            for ($i = 1; $i <= 5; $i++) {
                if (rand(1, 5) == $i) continue;
                if (rand(1, 5) == $i) continue;
                $metaReview = [];
                $list_meta = [
                    "Service",
                    "Organization",
                    "Friendliness",
                    "Area Expert",
                    "Safety",
                ];
                $total_point = 0;
                foreach ($list_meta as $key => $value) {
                    $point = rand(4, 5);
                    $total_point += $point;
                    $metaReview[] = [
                        "object_id" => $course,
                        "object_model" => "course",
                        "name" => $value,
                        "val" => $point,
                        "create_user" => "1",
                    ];
                }
                $rate = round($total_point / count($list_meta), 1);
                if ($rate > 5) $rate = 5;
                $titles = ["Great Trip", "Good Trip", "Trip was great", "Easy way to discover the city"];
                $review = new Review([
                    "object_id" => $course,
                    "object_model" => "course",
                    "title" => $titles[rand(0, 3)],
                    "content" => "Eum eu sumo albucius perfecto, commodo torquatos consequuntur pro ut, id posse splendide ius. Cu nisl putent omittantur usu, mutat atomorum ex pro, ius nibh nonumy id. Nam at eius dissentias disputando, molestie mnesarchum complectitur per te",
                    "rate_number" => $rate,
                    "author_ip" => "127.0.0.1",
                    "status" => "approved",
                    "publish_date" => date("Y-m-d H:i:s"),
                    'create_user' => rand(7, 16),
                    'vendor_id' => $vendor_id,
                ]);
                if ($review->save()) {
                    if (!empty($metaReview)) {
                        foreach ($metaReview as $meta) {
                            $meta['review_id'] = $review->id;
                            $reviewMeta = new ReviewMeta($meta);
                            $reviewMeta->save();
                        }
                    }
                }
            }
        }

        // Settings Tour
        DB::table('core_settings')->insert(
            [
                [
                    'name' => 'course_page_search_title',
                    'val' => 'Search for course',
                    'group' => "course",
                ],
                [
                    'name' => 'course_page_search_banner',
                    'val' => MediaFile::findMediaByName("inner-pagebg")->id,
                    'group' => "course",
                ],
                [
                    'name' => 'course_layout_search',
                    'val' => 'normal',
                    'group' => "course",
                ],
                [
                    'name' => 'course_enable_review',
                    'val' => '1',
                    'group' => "course",
                ],
                [
                    'name' => 'course_review_approved',
                    'val' => '0',
                    'group' => "course",
                ],
                [
                    'name' => 'course_review_stats',
                    'val' => '',
                    'group' => "course",
                ],
                [
                    'name' => 'course_booking_buyer_fees',
                    'val' => '[{"name":"Service fee","desc":"This helps us run our platform and offer services like 24\/7 support on your trip.","name_ja":"\u30b5\u30fc\u30d3\u30b9\u6599","desc_ja":"\u3053\u308c\u306b\u3088\u308a\u3001\u5f53\u793e\u306e\u30d7\u30e9\u30c3\u30c8\u30d5\u30a9\u30fc\u30e0\u3092\u5b9f\u884c\u3057\u3001\u65c5\u884c\u4e2d\u306b","price":"100","type":"one_time"}]',
                    'group' => "course",
                ]
            ]
        );

        $a = new \Modules\Core\Models\Attributes([
            'name' => 'Skill level',
            'service' => 'course'
        ]);
        $a->save();
        $term_ids = [];
        foreach (['Beginner', 'Intermediate', 'Advanced', 'Appropriate for all'] as $term) {
            $t = new \Modules\Core\Models\Terms([
                'name' => $term,
                'attr_id' => $a->id
            ]);

            $t->save();
            $term_ids[] = $t->id;
        }
        foreach ($IDs as $course_id) {
            foreach ($term_ids as $k => $term_id) {
                if (rand(0, count($term_ids)) == $k) continue;
                if (rand(0, count($term_ids)) == $k) continue;
                if (rand(0, count($term_ids)) == $k) continue;
                \Modules\Course\Models\CourseTerm::firstOrCreate([
                    'term_id' => $term_id,
                    'course_id' => $course_id
                ]);
            }
        }



        $a = new \Modules\Core\Models\Attributes([
            'name' => 'Language',
            'service' => 'course'
        ]);
        $a->save();
        $term_ids = [];
        foreach (['English', 'Vietnamese', 'French'] as $term) {
            $t = new \Modules\Core\Models\Terms([
                'name' => $term,
                'attr_id' => $a->id
            ]);
            $t->save();
            $term_ids[] = $t->id;
        }
        foreach ($IDs as $course_id) {
            foreach ($term_ids as $k => $term_id) {
                if (rand(0, count($term_ids)) == $k) continue;
                if (rand(0, count($term_ids)) == $k) continue;
                if (rand(0, count($term_ids)) == $k) continue;
                \Modules\Course\Models\CourseTerm::firstOrCreate([
                    'term_id' => $term_id,
                    'course_id' => $course_id
                ]);
            }
        }


        $a = new \Modules\Core\Models\Attributes([
            'name' => 'Assessments',
            'service' => 'course'
        ]);
        $a->save();
        $term_ids = [];
        foreach (['Yes', 'No'] as $term) {
            $t = new \Modules\Core\Models\Terms([
                'name' => $term,
                'attr_id' => $a->id
            ]);
            $t->save();
            $term_ids[] = $t->id;
        }
        foreach ($IDs as $course_id) {
            foreach ($term_ids as $k => $term_id) {
                if (rand(0, count($term_ids)) == $k) continue;
                if (rand(0, count($term_ids)) == $k) continue;
                if (rand(0, count($term_ids)) == $k) continue;
                \Modules\Course\Models\CourseTerm::firstOrCreate([
                    'term_id' => $term_id,
                    'course_id' => $course_id
                ]);
            }
        }


        // Sections and Lesson
        $sections = [
            ['name' => 'Getting Started', 'service' => 'course'],
            ['name' => 'The Brief', 'service' => 'course'],
            ['name' => 'Wireframing Low Fidelity', 'service' => 'course'],
            ['name' => 'Type, Color & Icon Introduction', 'service' => 'course'],
        ];

        $lessons = [
            ['name' => 'Lecture1.1 Introduction to the User Experience Course', 'duration' => 60],
            ['name' => 'Lecture1.2 Exercise: Your first design challenge', 'duration' => 90],
            ['name' => 'Lecture1.3 How to solve the previous exercise', 'duration' => 60],
            ['name' => 'Lecture1.4 Find out why smart objects are amazing', 'duration' => 40],
            ['name' => 'Lecture1.5 How to use text layers effectively', 'duration' => 90],
        ];

        $videos  = [
            'https://www.youtube.com/watch?v=RK1K2bCg4J8',
            'https://www.youtube.com/watch?v=5V_FQa363Y0',
            'https://www.youtube.com/watch?v=Bey4XXJAqS8',
            'https://www.youtube.com/watch?v=HSsqzzuGTPo',
            'https://www.youtube.com/watch?v=zBKei6Ji_WI',
            'https://www.youtube.com/watch?v=tO01J-M3g0U'
        ];
        foreach ($IDs as $course_id) {
            foreach ($sections as $k => $oneSection) {
                $oneSection['course_id'] = $course_id;
                $oneSection['active'] = 1;
                $oneSection['display_order'] = $k;
                $section  = new \Modules\Course\Models\Sections($oneSection);
                $section->save();

                foreach ($lessons as $i=>$oneLesson) {
                    $oneLesson['course_id'] = $course_id;
                    $oneLesson['section_id'] = $section->id;
                    $oneLesson['active'] = 1;
                    $oneLesson['type'] = 'video';
                    $oneLesson['url'] = $videos[rand(0,5)];
                    $oneLesson['display_order'] = $i;
                    if($i == 0){
                        $oneLesson['preview_url'] = 'https://youtu.be/nOCXXHGMezU';
                    }

                    $row = new \Modules\Course\Models\Lessons($oneLesson);
                    $row->save();
                }
            }
        }
    }
}
