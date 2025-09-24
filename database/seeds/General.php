<?php

    use Illuminate\Support\Str;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Modules\Media\Models\MediaFile;

    class General extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

            //Setting header,footer
            $menu_items_en = array(
                array(
                    'name'       => 'Home',
                    'url'        => '/',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                ),
                array(
                    'name'       => 'Courses',
                    'url'        => '#',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'Courses List',
                            'url'        => '/course',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Courses Detail',
                            'url'        => '/course/designing-a-responsive-mobile-website-with-muse',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Instructors List',
                            'url'        => '/instructor',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Instructors Detail',
                            'url'        => '/instructor/1',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        )
                    ),
                ),
                array(
                    'name'       => 'Pages',
                    'url'        => '#',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'News List',
                            'url'        => '/news',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'News Detail',
                            'url'        => '/news/morning-in-the-northern-sea',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        )
                    ),
                ),
                array(
                    'name'       => 'About Us',
                    'url'        => '/page/about-us',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(),
                ),
                array(
                    'name'       => 'Contact',
                    'url'        => '/contact',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(),
                ),
            );
            DB::table('core_menus')->insert([
                'name'        => 'Main Menu',
                'items'       => json_encode($menu_items_en),
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            $menu_items_ja = array(
                array(
                    'name'       => 'Home',
                    'url'        => '/',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                ),
                array(
                    'name'       => 'Courses',
                    'url'        => '#',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'Courses List',
                            'url'        => '/course',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Courses Detail',
                            'url'        => '/course/designing-a-responsive-mobile-website-with-muse',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Instructors List',
                            'url'        => '/instructor',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Instructors Detail',
                            'url'        => '/instructor/1',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        )
                    ),
                ),
                array(
                    'name'       => 'Pages',
                    'url'        => '#',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(
                        array(
                            'name'       => 'News List',
                            'url'        => '/news',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'News Detail',
                            'url'        => '/news/morning-in-the-northern-sea',
                            'item_model' => 'custom',
                            'model_name' => 'Custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Location Detail',
                            'url'        => '/location/paris',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                        array(
                            'name'       => 'Become a instructor',
                            'url'        => '/page/become-a-instructor',
                            'item_model' => 'custom',
                            'children'   => array(),
                        ),
                    ),
                ),
                array(
                    'name'       => 'About Us',
                    'url'        => '/page/about-us',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(),
                ),
                array(
                    'name'       => 'Contact',
                    'url'        => '/contact',
                    'item_model' => 'custom',
                    'model_name' => 'Custom',
                    'children'   => array(),
                ),
            );
            DB::table('core_menu_translations')->insert([
                'origin_id'   => '1',
                'locale'      => 'ja',
                'items'       =>json_encode($menu_items_ja),
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);

            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => 'menu_locations',
                        'val'   => '{"primary":1}',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'admin_email',
                        'val'   => 'contact@yourdomain.com',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'email_from_name',
                        'val'   => 'Edumy',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'email_from_address',
                        'val'   => 'contact@yourdomain.com',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'contact_phone',
                        'val'   => '(+096) 468 235',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'contact_fax',
                        'val'   => '(+096) 468 235',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'contact_location',
                        'val'   => 'Collin Street West, Victor 8007, Australia.',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'map_lat',
                        'val'   => '51.483304288080205',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'map_lng',
                        'val'   => '-0.11647876739500962',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'map_zoom',
                        'val'   => '8',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'logo_id',
                        'val'   => MediaFile::findMediaByName("header-logo")->id,
                        'group' => "general",
                    ],
                    [
                        'name'  => 'logo_sub_id',
                        'val'   => MediaFile::findMediaByName("header-logo2")->id,
                        'group' => "general",
                    ],
                    [
                        'name'  => 'site_favicon',
                        'val'   => MediaFile::findMediaByName("favicon")->id,
                        'group' => "general",
                    ],
                    [
                        'name'  => 'topbar_left_text',
                        'val'   => '<div class="socials">
    <a href="#"><i class="fa fa-facebook"></i></a>
    <a href="#"><i class="fa fa-linkedin"></i></a>
    <a href="#"><i class="fa fa-google-plus"></i></a>
</div>
<span class="line"></span>
<a href="mailto:contact@yourdomain.com">contact@yourdomain.com</a>',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'footer_text_left',
                        'val'   => '<ul>
	<li class="list-inline-item"><a href="#">Home</a></li>
	<li class="list-inline-item"><a href="#">Privacy</a></li>
	<li class="list-inline-item"><a href="#">Terms</a></li>
	<li class="list-inline-item"><a href="#">Sitemap</a></li>
	<li class="list-inline-item"><a href="#">Purchase</a></li>
</ul>',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'footer_text_right',
                        'val'   => '<ul>
	<li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
	<li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
	<li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
	<li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
	<li class="list-inline-item"><a href="#"><i class="fa fa-dribbble"></i></a></li>
	<li class="list-inline-item"><a href="#"><i class="fa fa-google"></i></a></li>
</ul>',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'list_widget_footer',
                        'val'   => '[{"title":"CONTACT","size":"3","content":"<p>329 Queensberry Street, North Melbourne <\/p>\r\n\t\t\t\t\t\t<p>VIC 3051, Australia.<\/p>\r\n\t\t\t\t\t\t<p>123 456 7890<\/p>\r\n\t\t\t\t\t\t<p>support@edumy.com<\/p>"},{"title":"COMPANY","size":"2","content":"<ul class=\"list-unstyled\">\r\n\t\t\t\t\t\t\t<li><a href=\"#\">About Us<\/a><\/li>\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Blog<\/a><\/li>\r\n\t\t\t\t\t\t\t<li><a href=\"page-contact.html\">Contact<\/a><\/li>\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Become a Teacher<\/a><\/li>\r\n\t\t\t\t\t\t<\/ul>"},{"title":"PROGRAMS","size":"2","content":"<ul class=\"list-unstyled\">\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Nanodegree Plus<\/a><\/li>\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Veterans<\/a><\/li>\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Georgia<\/a><\/li>\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Self-Driving Car<\/a><\/li>\r\n\t\t\t\t\t\t<\/ul>"},{"title":"SUPPORT","size":"2","content":"<ul class=\"list-unstyled\">\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Documentation<\/a><\/li>\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Forums<\/a><\/li>\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Language Packs<\/a><\/li>\r\n\t\t\t\t\t\t\t<li><a href=\"#\">Release Status<\/a><\/li>\r\n\t\t\t\t\t\t<\/ul>"},{"title":"MOBILE","size":"3","content":"<div class=\"app_grid\">\r\n\t\t\t\t\t\t\t<button class=\"apple_btn btn-dark\">\r\n\t\t\t\t\t\t\t\t<span class=\"icon\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"flaticon-apple\"><\/span>\r\n\t\t\t\t\t\t\t\t<\/span>\r\n\t\t\t\t\t\t\t\t<span class=\"title\">App Store<\/span>\r\n\t\t\t\t\t\t\t\t<span class=\"subtitle\">Available now on the<\/span>\r\n\t\t\t\t\t\t\t<\/button>\r\n\t\t\t\t\t\t\t<button class=\"play_store_btn btn-dark\">\r\n\t\t\t\t\t\t\t\t<span class=\"icon\">\r\n\t\t\t\t\t\t\t\t\t<span class=\"flaticon-google-play\"><\/span>\r\n\t\t\t\t\t\t\t\t<\/span>\r\n\t\t\t\t\t\t\t\t<span class=\"title\">Google Play<\/span>\r\n\t\t\t\t\t\t\t\t<span class=\"subtitle\">Get in on<\/span>\r\n\t\t\t\t\t\t\t<\/button>\r\n\t\t\t\t\t\t<\/div>"}]',
                        'group' => "general",
                    ],
                    [
                        'name'  => 'list_widget_footer_ja',
                        'val'   => '[{"title":"\u52a9\u3051\u304c\u5fc5\u8981\uff1f","size":"3","content":"<div class=\"contact\">\r\n        <div class=\"c-title\">\r\n            \u304a\u96fb\u8a71\u304f\u3060\u3055\u3044\r\n        <\/div>\r\n        <div class=\"sub\">\r\n            + 00 222 44 5678\r\n        <\/div>\r\n    <\/div>\r\n    <div class=\"contact\">\r\n        <div class=\"c-title\">\r\n            \u90f5\u4fbf\u7269\r\n        <\/div>\r\n        <div class=\"sub\">\r\n            hello@yoursite.com\r\n        <\/div>\r\n    <\/div>\r\n    <div class=\"contact\">\r\n        <div class=\"c-title\">\r\n            \u30d5\u30a9\u30ed\u30fc\u3059\u308b\r\n        <\/div>\r\n        <div class=\"sub\">\r\n            <a href=\"#\">\r\n                <i class=\"icofont-facebook\"><\/i>\r\n            <\/a>\r\n            <a href=\"#\">\r\n                <i class=\"icofont-twitter\"><\/i>\r\n            <\/a>\r\n            <a href=\"#\">\r\n                <i class=\"icofont-youtube-play\"><\/i>\r\n            <\/a>\r\n        <\/div>\r\n    <\/div>"},{"title":"\u4f1a\u793e","size":"3","content":"<ul>\r\n    <li><a href=\"#\">\u7d04, \u7565<\/a><\/li>\r\n    <li><a href=\"#\">\u30b3\u30df\u30e5\u30cb\u30c6\u30a3\u30d6\u30ed\u30b0<\/a><\/li>\r\n    <li><a href=\"#\">\u5831\u916c<\/a><\/li>\r\n    <li><a href=\"#\">\u3068\u9023\u643a<\/a><\/li>\r\n    <li><a href=\"#\">\u30c1\u30fc\u30e0\u306b\u4f1a\u3046<\/a><\/li>\r\n<\/ul>"},{"title":"\u30b5\u30dd\u30fc\u30c8","size":"3","content":"<ul>\r\n    <li><a href=\"#\">\u30a2\u30ab\u30a6\u30f3\u30c8<\/a><\/li>\r\n    <li><a href=\"#\">\u6cd5\u7684<\/a><\/li>\r\n    <li><a href=\"#\">\u63a5\u89e6<\/a><\/li>\r\n    <li><a href=\"#\">\u30a2\u30d5\u30a3\u30ea\u30a8\u30a4\u30c8\u30d7\u30ed\u30b0\u30e9\u30e0<\/a><\/li>\r\n    <li><a href=\"#\">\u500b\u4eba\u60c5\u5831\u4fdd\u8b77\u65b9\u91dd<\/a><\/li>\r\n<\/ul>"},{"title":"\u8a2d\u5b9a","size":"3","content":"<ul>\r\n<li><a href=\"#\">\u8a2d\u5b9a1<\/a><\/li>\r\n<li><a href=\"#\">\u8a2d\u5b9a2<\/a><\/li>\r\n<\/ul>"}]',
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_title',
                        'val' => "We'd love to hear from you",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_sub_title',
                        'val' => "Send us a message and we'll respond as soon as possible",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_desc',
                        'val' => "<!DOCTYPE html><html><head></head><body><h3>Edumy</h3><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Tell. + 00 222 444 33</p><p>Email. hello@yoursite.com</p><p>1355 Market St, Suite 900San, Francisco, CA 94103 United States</p></body></html>",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_image',
                        'val' => MediaFile::findMediaByName("inner-pagebg")->id,
                        'group' => "general",
                    ],
                    [
                        'name' => 'copyright_text',
                        'val' => 'Copyright Edumy © 2019. All Rights Reserved.',
                        'group' => "general",
                    ]

                ]
            );

            $banner_image = MediaFile::findMediaByName("banner-search")->id;
            $banner_home_mix = MediaFile::findMediaByName("home-mix")->id;
            $image_home_mix_1 = MediaFile::findMediaByName("image_home_mix_1")->id;
            $image_home_mix_2 = MediaFile::findMediaByName("image_home_mix_2")->id;
            $image_home_mix_3 = MediaFile::findMediaByName("image_home_mix_3")->id;
            $icon_about_1 = MediaFile::findMediaByName("ico_localguide")->id;
            $icon_about_2 = MediaFile::findMediaByName("ico_adventurous")->id;
            $icon_about_3 = MediaFile::findMediaByName("ico_maps")->id;
            $avatar = MediaFile::findMediaByName("avatar")->id;
            $avatar_2 = MediaFile::findMediaByName("avatar-2")->id;
            $avatar_3 = MediaFile::findMediaByName("avatar-3")->id;


            $home_slide = MediaFile::findMediaByName("slide-home-1")->id;
            $home_slide_2 = MediaFile::findMediaByName("slide-home-2")->id;
            $home_slide_3 = MediaFile::findMediaByName("slide-home-3")->id;

            $slide_icon = MediaFile::findMediaByName("slide-hicon-1")->id;
            $slide_icon_2 = MediaFile::findMediaByName("slide-hicon-2")->id;
            $slide_icon_3 = MediaFile::findMediaByName("slide-hicon-3")->id;
            $slide_icon_4 = MediaFile::findMediaByName("slide-hicon-4")->id;

            $partners = MediaFile::findMediaByName("partners-1")->id;
            $partners_2 = MediaFile::findMediaByName("partners-2")->id;
            $partners_3 = MediaFile::findMediaByName("partners-3")->id;
            $partners_4 = MediaFile::findMediaByName("partners-4")->id;
            $partners_5 = MediaFile::findMediaByName("partners-5")->id;

            $background_1 = MediaFile::findMediaByName("background-1")->id;
            $background_3 = MediaFile::findMediaByName("background-3")->id;
            $phone_home = MediaFile::findMediaByName("phone_home")->id;

            $testimonial = MediaFile::findMediaByName("testimonial-1")->id;
            $testimonial_2 = MediaFile::findMediaByName("testimonial-2")->id;
            $testimonial_3 = MediaFile::findMediaByName("testimonial-3")->id;
            $testimonial_4 = MediaFile::findMediaByName("testimonial-4")->id;
            $testimonial_5 = MediaFile::findMediaByName("testimonial-5")->id;

            // Setting Home Page
            DB::table('core_templates')->insert([
                'title'       => 'Home Page',
                'content'     => '[{"type":"slide","name":"Slide","model":{"list_item":[{"_active":true,"title":"Self EducatIon Resources and Infos","sub_title":"Technology is brining a massive wave of evolution on learning things on different ways.","icon_image":'.$home_slide.',"order":null},{"_active":true,"title":"Self EducatIon Resources and Infos","sub_title":"Technology is brining a massive wave of evolution on learning things on different ways.","icon_image":'.$home_slide_2.',"order":null},{"_active":true,"title":"Self EducatIon Resources and Infos","sub_title":"Technology is brining a massive wave of evolution on learning things on different ways.","icon_image":'.$home_slide_3.',"order":null}],"style":"","list_sub":[{"_active":true,"title":"Learn From The Experts","icon_image":'.$slide_icon.',"order":null},{"_active":true,"title":"Book Library & Store","icon_image":'.$slide_icon_2.',"order":null},{"_active":true,"title":"Worldwide Recognize","icon_image":'.$slide_icon_3.',"order":null},{"_active":true,"title":"Best Industry Leaders","icon_image":'.$slide_icon_4.',"order":null}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_categories","name":"Course: List Categories","model":{"list_item":[{"_active":true,"category_id":"7","icon_image":215,"order":null},{"_active":true,"category_id":"6","icon_image":217,"order":null},{"_active":true,"category_id":"5","icon_image":218,"order":null},{"_active":true,"category_id":"4","icon_image":216,"order":null},{"_active":true,"category_id":"3","icon_image":214,"order":null},{"_active":true,"category_id":"2","icon_image":222,"order":null},{"_active":true,"category_id":"1","icon_image":219,"order":null},{"_active":true,"category_id":"8","icon_image":221,"order":null}],"title":"Via School Categories Courses","sub_title":"Cum doctus civibus efficiantur in imperdiet deterruisset."},"component":"RegularBlock","open":true,"is_container":false},{"type":"parallax","name":"Parallax Text","model":{"title":"STARTING ONLINE LEARNING","sub_title":"Enhance your skIlls wIth best OnlIne courses","icon_image":'.$background_1.',"link":"/course","text_btn":"Get Started Now"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_courses","name":"Course: List Items","model":{"title":"Students Are Viewing","desc":"Cum doctus civibus efficiantur in imperdiet deterruisset.","number":10,"style":"carousel","category_id":"","location_id":"","order":"","order_by":"","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"categories_with_items","name":"Course: Categories With Items","model":{"title":"Browse Our Top Courses","sub_title":"Cum doctus civibus efficiantur in imperdiet deterruisset.","list_item":[{"_active":true,"category_id":"7","number":2,"is_featured":null,"order":1},{"_active":true,"category_id":"6","number":2,"is_featured":null,"order":2}, {"_active":true,"category_id":"1","number":2,"is_featured":null,"order":3}, {"_active":true,"category_id":"4","number":2,"is_featured":null,"order":4}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"testimonial","name":"List Testimonial","model":{"title":"What People Say","list_item":[{"_active":true,"name":"Eva Hicks","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ", "job":"Client", "avatar":'.$testimonial.'},{"_active":true,"name":"Donald Wolf","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","job":"Client","avatar":'.$testimonial_2.'},{"_active":true,"name":"Charlie Harrington","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","job":"Client","avatar":'.$testimonial_3.'},{"_active":true,"name":"Ali Tufan","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","job":"Client","avatar":'.$testimonial_4.'}],"sub_title":"Cum doctus civibus efficiantur in imperdiet deterruisset."},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_news","name":"News: List Items","model":{"title":"Latest News And Events","desc":"Cum doctus civibus efficiantur in imperdiet deterruisset.","number":8,"category_id":"","order":"id","order_by":"asc","link":"/news","text_btn":"See more posts"},"component":"RegularBlock","open":true,"is_container":false},{"type":"app_download","name":"App Download","model":{"title":"Download & Enjoy","sub_title":"Access your courses anywhere, anytime & prepare with practice tests.","icon_image":'.$background_3.',"icon_capture":'.$phone_home.',"link_apple":"https://www.google.com/","link_google":"https://www.google.com/"},"component":"RegularBlock","open":true,"is_container":false},{"type":"partner","name":"Partner","model":{"title":"Need To Train Your Team?","sub_title":"Cum doctus civibus efficiantur in imperdiet deterruisset.","list_item":[{"_active":true,"title":"Acrevis","link":"http://www.acrevis.com","icon_image":'.$partners.'},{"_active":true,"title":"Ancasta","link":"http://www.ancasta.com","icon_image":'.$partners_2.'},{"_active":true,"title":"AbuGarcia","link":"http://www.abugarcia.com","icon_image":'.$partners_3.'},{"_active":true,"title":"Aquiire","link":"http://www.aquiire.com","icon_image":'.$partners_4.'},{"_active":true,"title":"Sauter","link":"http://www.sauter.com","icon_image":'.$partners_5.'}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"offer_block","name":"Offer Block","model":{"list_item":[{"_active":true,"title":"Get Newsletter","desc":"Your download should start automatically, if not Click here. Should I give up, huh?.","link_title":"Get it now","link_more":"/register","featured_text":"Email address","featured_icon":""}]},"component":"RegularBlock","open":true}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_template_translations')->insert([
                'origin_id'   => '1',
                'locale'      => 'ja',
                'title'       => 'Home Page',
                'content'     => '[{"type":"form_search_all_service","name":"Form Search All Service","model":{"service_types":["hotel","space","tour","car"],"title":"こんにちは！","sub_title":"どこに行きたい？","bg_image":'.$banner_home_mix.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"offer_block","name":"Offer Block","model":{"list_item":[{"_active":true,"title":"特別オファー","desc":"最適なホテルを探す<br>\n20,000以上の物件の価格<br>\n上の最高の価格","background_image":'.$image_home_mix_1.',"link_title":"取引","link_more":"#","featured_text":"ホリデーセール"},{"_active":true,"title":"ニュースレター","desc":"無料で参加して取得 <br>\nに合わせたニュースレター<br>\nホット旅行情報。","background_image":'.$image_home_mix_2.',"link_title":"サインアップ","link_more":"/register","featured_icon":"icofont-email"},{"_active":true,"title":"旅行のヒント","desc":"旅行の専門家からのヒント <br>\nあなたの次の<br>\nより良い。","background_image":'.$image_home_mix_3.',"link_title":"サインアップ","link_more":"/register","featured_text":null,"featured_icon":"icofont-island-alt"}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_hotel","name":"Hotel: List Items","model":{"title":"ベストセラーリスト","desc":"思慮深いデザインで高い評価を得ているホテル","number":4,"style":"normal","location_id":"","order":"id","order_by":"asc","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_locations","name":"List Locations","model":{"service_type":["space","hotel","tour"],"title":"人気の目的地","desc":"読者が","number":6,"layout":"style_4","order":"id","order_by":"asc","to_location_detail":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_tours","name":"Tour: List Items","model":{"title":"最高のプロモーションツアー","number":6,"style":"box_shadow","category_id":"","location_id":"","order":"id","order_by":"asc","is_featured":"","desc":"最も人気のある目的地"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_space","name":"Space: List Items","model":{"title":"賃貸物件","desc":"思慮深いデザインで高い評価を受けている家","number":4,"style":"normal","location_id":"","order":"id","order_by":"desc","is_featured":""},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_car","name":"Car: List Items","model":{"title":"Car Trending","desc":"Book incredible things to do around the world.","number":8,"style":"normal","location_id":"","order":"id","order_by":"desc","is_featured":""},"component":"RegularBlock","open":true},{"type": "list_news", "name": "News: List Items", "model": {"title": "Read the latest from blog", "desc": "Contrary to popular belief", "number": 6, "category_id": null, "order": "id", "order_by": "asc"}, "component": "RegularBlock", "open": true, "is_container": false},{"type":"call_to_action","name":"Call To Action","model":{"title":"あなたの街を知？","sub_title":"3000以上の都市から2000人以上の地元民と","link_title":"ローカルエ","link_more":"#"},"component":"RegularBlock","open":true,"is_container":false},{"type":"testimonial","name":"List Testimonial","model":{"title":"私たちの幸せなクライアント","list_item":[{"_active":false,"name":"Eva Hicks","desc":"右ずへやん間申ゃ投法けゃイ仙一もと政情ルた食的て代下ずせに丈律ルラモト聞探チト棋90績ム的社ず置攻景リフノケ内兼唱堅ゃフぼ。場ルアハ美","job":"Client","avatar":' . $avatar . '},{"_active":false,"name":"Donald Wolf","desc":"右ずへやん間申ゃ投法けゃイ仙一もと政情ルた食的て代下ずせに丈律ルラモト聞探チト棋90績ム的社ず置攻景リフノケ内兼唱堅ゃフぼ。場ルアハ美","job":"Client","avatar":' . $avatar_2 . '},{"_active":true,"name":"Charlie Harrington","desc":"右ずへやん間申ゃ投法けゃイ仙一もと政情ルた食的て代下ずせに丈律ルラモト聞探チト棋90績ム的社ず置攻景リフノケ内兼唱堅ゃフぼ。場ルアハ美","job":"Client","avatar":' . $avatar_3 . '}]},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);

            //Page About
            DB::table('core_templates')->insert([
                'title'       => 'About Us',
                'content'     => '[{"type":"text","name":"Text","model":{"content":"<h3 class=\"fz26\" style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 0.5rem; font-family: Nunito, sans-serif; line-height: 1.42857; color: #0a0a0a; font-size: 26px; background-color: #ffffff; text-align: left;\"><strong>Our Story</strong></h3>","class":"text-center pt-3"},"component":"RegularBlock","open":true,"is_container":false},{"type":"counter","name":"Counter Number","model":{"list_item":[{"_active":true,"title":"FOREIGN FOLLOWERS","counter":88000},{"_active":true,"title":"CERTIFIED TEACHERS","counter":96},{"_active":true,"title":"STUDENTS ENROLLED","counter":4789},{"_active":true,"title":"COMPLETE COURSES","counter":488}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":true,"title":"Who We Are","sub_title":"<p class=\"mt25\" style=\"box-sizing: border-box; font-size: 15px; color: #6f7074; font-family: \'Open Sans\', sans-serif; background-color: #ffffff; margin: 25px !important 0px 0px 0px;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis,et quasi architecto beatae vitae dicta sunt explicabo.</p>\n<p class=\"mt25\" style=\"box-sizing: border-box; font-size: 15px; color: #6f7074; font-family: \'Open Sans\', sans-serif; background-color: #ffffff; margin: 25px !important 0px 0px 0px;\">&nbsp;</p>\n<p class=\"mt25\" style=\"box-sizing: border-box; font-size: 15px; color: #6f7074; font-family: \'Open Sans\', sans-serif; background-color: #ffffff; margin: 25px !important 0px 0px 0px;\">Nemo enim ipsam,voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia,consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.,Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, adipisci velit, sed quia non numquam eius modi tempora</p>","icon_image":null,"order":null},{"_active":true,"title":"What We Do","sub_title":"<p class=\"mt25\" style=\"box-sizing: border-box; font-size: 15px; color: #6f7074; font-family: \'Open Sans\', sans-serif; background-color: #ffffff; margin: 25px !important 0px 0px 0px;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis,et quasi architecto beatae vitae dicta sunt explicabo.</p>\n<p class=\"mt25\" style=\"box-sizing: border-box; font-size: 15px; color: #6f7074; font-family: \'Open Sans\', sans-serif; background-color: #ffffff; margin: 25px !important 0px 0px 0px;\">&nbsp;</p>\n<p class=\"mt25\" style=\"box-sizing: border-box; font-size: 15px; color: #6f7074; font-family: \'Open Sans\', sans-serif; background-color: #ffffff; margin: 25px !important 0px 0px 0px;\">Nemo enim ipsam,voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia,consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.,Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, adipisci velit, sed quia non numquam eius modi tempora</p>","icon_image":null,"order":null}],"style":"style4"},"component":"RegularBlock","open":true,"is_container":false},{"type":"parallax","name":"Parallax Text","model":{"title":"STARTING ONLINE LEARNING","sub_title":"Enhance your skIlls wIth best OnlIne courses","icon_image":'.$background_1.',"link":"/course","text_btn":"Get Started Now"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_instructors","name":"Instructors: List Items","model":{"title":"Popular Instructors","desc":"","number":15,"style":"carousel","order":"","order_by":""},"component":"RegularBlock","open":true}, {"type":"testimonial","name":"List Testimonial","model":{"title":"What People Say","list_item":[{"_active":true,"name":"Eva Hicks","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","job":"Client","avatar":'.$testimonial.'},{"_active":true,"name":"Donald Wolf","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","job":"Client","avatar":'.$testimonial_2.'},{"_active":true,"name":"Charlie Harrington","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","job":"Client","avatar":'.$testimonial_3.'},{"_active":true,"name":"Ali Tufan","desc":"Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui. ","job":"Client","avatar":'.$testimonial_4.'}],"sub_title":"Cum doctus civibus efficiantur in imperdiet deterruisset."},"component":"RegularBlock","open":true,"is_container":false},{"type":"partner","name":"Partner","model":{"title":"Need To Train Your Team?","sub_title":"Cum doctus civibus efficiantur in imperdiet deterruisset.","list_item":[{"_active":true,"title":"Acrevis","link":"http://www.acrevis.com","icon_image":'.$partners.'},{"_active":true,"title":"Ancasta","link":"http://www.ancasta.com","icon_image":'.$partners_2.'},{"_active":true,"title":"AbuGarcia","link":"http://www.abugarcia.com","icon_image":'.$partners_3.'},{"_active":true,"title":"Aquiire","link":"http://www.aquiire.com","icon_image":'.$partners_4.'},{"_active":true,"title":"Sauter","link":"http://www.sauter.com","icon_image":'.$partners_5.'}]},"component":"RegularBlock","open":true,"is_container":false},{"type":"offer_block","name":"Offer Block","model":{"list_item":[{"_active":true,"title":"Get Newsletter","desc":"Your download should start automatically, if not Click here. Should I give up, huh?.","link_title":"Get it now","link_more":"/register","featured_text":"Email address","featured_icon":""}]},"component":"RegularBlock","open":true}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);

            //Page Instructor
            $banner_image_vendor_register = MediaFile::findMediaByName("thumb-vendor-register")->id;
            $video_bg = MediaFile::findMediaByName("bg-video-vendor-register1")->id;
            $ico_chat_1 = MediaFile::findMediaByName("ico_chat_1")->id;
            $ico_friendship_1 = MediaFile::findMediaByName("ico_friendship_1")->id;
            $ico_piggy_bank_1 = MediaFile::findMediaByName("ico_piggy-bank_1")->id;
            DB::table('core_templates')->insert([
                'title'       => 'Become a instructor',
                'content'     => '[{"type":"vendor_register_form","name":"Instructor Register Form","model":{"title":"Become a instructor","desc":"Join our community to unlock your greatest asset and welcome paying guests into your home.","youtube":"https://www.youtube.com/watch?v=AmZ0WrEaf34","bg_image":'.$banner_image_vendor_register.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"text","name":"Text","model":{"content":"<h3><strong>How does it work?</strong></h3>","class":"text-center"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":false,"title":"Sign up","sub_title":"Click edit button to change this text  to change this text","icon_image":null,"order":null},{"_active":false,"title":" Add your services","sub_title":" Click edit button to change this text  to change this text","icon_image":null,"order":null},{"_active":true,"title":"Get bookings","sub_title":" Click edit button to change this text  to change this text","icon_image":null,"order":null}],"style":"style2"},"component":"RegularBlock","open":true,"is_container":false},{"type":"video_player","name":"Video Player","model":{"title":"Share the beauty of your city","youtube":"https://www.youtube.com/watch?v=hHUbLv4ThOo","bg_image":'.$video_bg.'},"component":"RegularBlock","open":true,"is_container":false},{"type":"text","name":"Text","model":{"content":"<h3><strong>Why be a Local Expert</strong></h3>","class":"text-center ptb60"},"component":"RegularBlock","open":true,"is_container":false},{"type":"list_featured_item","name":"List Featured Item","model":{"list_item":[{"_active":false,"title":"Earn an additional income","sub_title":" Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_piggy_bank_1.',"order":null},{"_active":true,"title":"Open your network","sub_title":" Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_friendship_1.',"order":null},{"_active":true,"title":"Practice your language","sub_title":" Ut elit tellus, luctus nec ullamcorper mattis","icon_image":'.$ico_chat_1.',"order":null}],"style":"style3"},"component":"RegularBlock","open":true,"is_container":false},{"type":"faqs","name":"FAQ List","model":{"title":"FAQs","list_item":[{"_active":false,"title":"How will I receive my payment?","sub_title":" Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."},{"_active":true,"title":"How do I upload products?","sub_title":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."},{"_active":true,"title":"How do I update or extend my availabilities?","sub_title":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.\n"},{"_active":true,"title":"How do I increase conversion rate?","sub_title":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."}]},"component":"RegularBlock","open":true,"is_container":false}]',
                'create_user' => '1',
                'created_at'  => date("Y-m-d H:i:s")
            ]);


            DB::table('core_pages')->insert([
                'title'       => 'Home Page',
                'slug'        => 'home-page',
                'template_id' => '1',
                'create_user' => '1',
                'hide_bc' => '1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ]);
            DB::table('core_pages')->insert([
                'title'       => 'About Us',
                'slug'        => 'about-us',
                'template_id' => '2',
                'create_user' => '1',
                'status'      => 'publish',
                'image_id'    => MediaFile::findMediaByName("inner-pagebg")->id,
                'created_at'  => date("Y-m-d H:i:s")
            ]);

            DB::table('core_pages')->insert([
                'title'       => 'Become a instructor',
                'slug'        => 'become-a-instructor',
                'template_id' => '3',
                'create_user' => '1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ]);


            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => 'home_page_id',
                        'val'   => '1',
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_title',
                        'val' => "We'd love to hear from you",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_title_ja',
                        'val' => "あなたからの御一報をお待ち",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_sub_title',
                        'val' => "Send us a message and we'll respond as soon as possible",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_sub_title_ja',
                        'val' => "私たちにメッセージを送ってください、私たちはできるだ",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_desc',
                        'val' => "<!DOCTYPE html><html><head></head><body><h3>Edumy</h3><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>Tell. + 00 222 444 33</p><p>Email. hello@yoursite.com</p><p>1355 Market St, Suite 900San, Francisco, CA 94103 United States</p></body></html>",
                        'group' => "general",
                    ],
                    [
                        'name' => 'page_contact_image',
                        'val' => MediaFile::findMediaByName("inner-pagebg")->id,
                        'group' => "general",
                    ]
                ]
            );


            // Setting Currency
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => "currency_main",
                        'val'   => "usd",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "currency_format",
                        'val'   => "left",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "currency_decimal",
                        'val'   => ",",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "currency_thousand",
                        'val'   => ".",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "currency_no_decimal",
                        'val'   => "0",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "extra_currency",
                        'val'   => '[{"currency_main":"eur","currency_format":"left","currency_thousand":".","currency_decimal":",","currency_no_decimal":"2","rate":"0.902807"},{"currency_main":"jpy","currency_format":"right_space","currency_thousand":".","currency_decimal":",","currency_no_decimal":"0","rate":"0.00917113"}]',
                        'group' => "payment",
                    ]
                ]
            );

            //MAP
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => 'map_provider',
                        'val'   => 'gmap',
                        'group' => "advance",
                    ],
                    [
                        'name'  => 'map_gmap_key',
                        'val'   => '',
                        'group' => "advance",
                    ]
                ]
            );

            // Payment Gateways
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => "g_offline_payment_enable",
                        'val'   => "1",
                        'group' => "payment",
                    ],
                    [
                        'name'  => "g_offline_payment_name",
                        'val'   => "Offline Payment",
                        'group' => "payment",
                    ]
                ]
            );

            // Settings general
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => "date_format",
                        'val'   => "m/d/Y",
                        'group' => "general",
                    ],
                    [
                        'name'  => "site_title",
                        'val'   => "Edumy",
                        'group' => "general",
                    ],
                ]
            );

            // Email general
            DB::table('core_settings')->insert(
			[
                [
                    'name' => "site_timezone",
                    'val' => "UTC",
                    'group' => "general",
                ],
                [
                    'name' => "site_title",
                    'val' => "Edumy",
                    'group' => "general",
				],
				[
					'name'  => "email_header",
					'val'   => '<h1 class="site-title" style="text-align: center">Edumy</h1>',
					'group' => "general",
				],
				[
					'name'  => "email_footer",
					'val'   => '<p class="" style="text-align: center">&copy; 2019 Edumy. All rights reserved</p>',
					'group' => "general",
				],
				[
					'name'  => "enable_mail_user_registered",
					'val'   => 1,
					'group' => "user",
				],
                [
                    'name' => 'users_page_list_banner',
                    'val' => MediaFile::findMediaByName("inner-pagebg")->id,
                    'group' => "user",
                ],
				[
					'name'  => "user_content_email_registered",
					'val'   => '<h1 style="text-align: center">Welcome!</h1>
						<h3>Hello [first_name] [last_name]</h3>
						<p>Thank you for signing up with Edumy! We hope you enjoy your time with us.</p>
						<p>Regards,</p>
						<p>Edumy</p>',
					'group' => "user",
				],
				[
					'name'  => "admin_enable_mail_user_registered",
					'val'   => 1,
					'group' => "user",
				],
				[
					'name'  => "admin_content_email_user_registered",
					'val'   => '<h3>Hello Administrator</h3>
						<p>We have new registration</p>
						<p>Full name: [first_name] [last_name]</p>
						<p>Email: [email]</p>
						<p>Regards,</p>
						<p>Edumy</p>',
					'group' => "user",
				],
				[
					'name' => "user_content_email_forget_password",
					'val'  => '<h1>Hello!</h1>
						<p>You are receiving this email because we received a password reset request for your account.</p>
						<p style="text-align: center">[button_reset_password]</p>
						<p>This password reset link expire in 60 minutes.</p>
						<p>If you did not request a password reset, no further action is required.
						</p>
						<p>Regards,</p>
						<p>Edumy</p>',
					'group' => "user",
				]
            ]
        );

            // Email Setting
            DB::table('core_settings')->insert(
			[
				[
					'name'  => "email_driver",
					'val'   => "log",
					'group' => "email",
				],
				[
					'name'  => "email_host",
					'val'   => "smtp.mailgun.org",
					'group' => "email",
				],
				[
					'name'  => "email_port",
					'val'   => "587",
					'group' => "email",
				],
				[
					'name'  => "email_encryption",
					'val'   => "tls",
					'group' => "email",
				],
				[
					'name'  => "email_username",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_password",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_mailgun_domain",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_mailgun_secret",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_mailgun_endpoint",
					'val'   => "api.mailgun.net",
					'group' => "email",
				],
				[
					'name'  => "email_postmark_token",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_ses_key",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_ses_secret",
					'val'   => "",
					'group' => "email",
				],
				[
					'name'  => "email_ses_region",
					'val'   => "us-east-1",
					'group' => "email",
				],
				[
					'name'  => "email_sparkpost_secret",
					'val'   => "",
					'group' => "email",
				],
			]
		);

            // Instructor setting
            DB::table('core_settings')->insert(
                [
                    [
                        'name'  => "vendor_enable",
                        'val'   => "1",
                        'group' => "vendor",
                    ],
                    [
                        'name'  => "vendor_commission_type",
                        'val'   => "percent",
                        'group' => "vendor",
                    ],
                    [
                        'name'  => "vendor_commission_amount",
                        'val'   => "10",
                        'group' => "vendor",
                    ],
                    [
                        'name'  => "vendor_role",
                        'val'   => "1",
                        'group' => "vendor",
                    ],
                    [
                        'name'  => "role_verify_fields",
                        'val'   => '{"phone":{"name":"Phone","type":"text","roles":["1","2","3"],"required":null,"order":null,"icon":"fa fa-phone"},"id_card":{"name":"ID Card","type":"file","roles":["1","2","3"],"required":"1","order":"0","icon":"fa fa-id-card"},"trade_license":{"name":"Trade License","type":"multi_files","roles":["1","3"],"required":"1","order":"0","icon":"fa fa-copyright"}}',
                        'group' => "vendor",
                    ],
                ]
            );

        }
}
