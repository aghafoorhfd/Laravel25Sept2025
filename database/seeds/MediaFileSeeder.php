<?php

use Illuminate\Database\Seeder;

class MediaFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //general
        DB::table('media_files')->insert([

            ['file_name' => 'logo2', 'file_path' => 'demo/logo2.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'footer-logo-h8', 'file_path' => 'demo/footer-logo-h8.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'close', 'file_path' => 'demo/close.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'header-logo', 'file_path' => 'demo/header-logo.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'header-logo2', 'file_path' => 'demo/header-logo2.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'header-logo3', 'file_path' => 'demo/header-logo3.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'header-logo4', 'file_path' => 'demo/header-logo4.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'header-logo4', 'file_path' => 'demo/header-logo4.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'preloader', 'file_path' => 'demo/preloader.gif', 'file_type' => 'image/gif', 'file_extension' => 'gif'],
            ['file_name' => 'banner-search', 'file_path' => 'demo/banner-search.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],

            ['file_name' => 'avatar', 'file_path' => 'demo/general/avatar.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'avatar-2', 'file_path' => 'demo/general/avatar-2.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'avatar-3', 'file_path' => 'demo/general/avatar-3.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'ico_adventurous', 'file_path' => 'demo/general/ico_adventurous.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'ico_localguide', 'file_path' => 'demo/general/ico_localguide.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'ico_maps', 'file_path' => 'demo/general/ico_maps.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'ico_paymethod', 'file_path' => 'demo/general/ico_paymethod.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'logo', 'file_path' => 'demo/general/logo.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg'],
            ['file_name' => 'bg_contact', 'file_path' => 'demo/general/bg-contact.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'favicon', 'file_path' => 'demo/favicon.ico', 'file_type' => 'image/x-icon', 'file_extension' => 'ico'],
            ['file_name' => 'thumb-vendor-register', 'file_path' => 'demo/general/thumb-vendor-register.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'bg-video-vendor-register1', 'file_path' => 'demo/general/bg-video-vendor-register1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'ico_chat_1', 'file_path' => 'demo/general/ico_chat_1.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg'],
            ['file_name' => 'ico_friendship_1', 'file_path' => 'demo/general/ico_friendship_1.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg'],
            ['file_name' => 'ico_piggy-bank_1', 'file_path' => 'demo/general/ico_piggy-bank_1.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg'],
            ['file_name' => 'home-mix', 'file_path' => 'demo/general/home-mix.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'image_home_mix_1', 'file_path' => 'demo/general/image_home_mix_1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'image_home_mix_2', 'file_path' => 'demo/general/image_home_mix_2.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'image_home_mix_3', 'file_path' => 'demo/general/image_home_mix_3.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],

            ['file_name' => 'phone_home', 'file_path' => 'demo/resource/phone_home.png', 'file_type' => 'image/png', 'file_extension' => 'png'],

        ]);



        // about
        for ($i=1 ; $i <= 8 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'about-'.$i, 'file_path' => 'demo/about/'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }
        for ($i=1 ; $i <= 4 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'icon-'.$i, 'file_path' => 'demo/about/icon'.$i.'.jpg', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ]);
        }
        for ($i=1 ; $i <= 6 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'shape-'.$i, 'file_path' => 'demo/about/shape'.$i.'.jpg', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ]);
        }
        DB::table('media_files')->insert([
            ['file_name' => 'c1', 'file_path' => 'demo/about/c1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'es1', 'file_path' => 'demo/about/es1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'wave', 'file_path' => 'demo/about/wave.jpg', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'wave-1', 'file_path' => 'demo/about/wave.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg'],
        ]);

        // background
        for ($i=1 ; $i <= 8 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'background-'.$i, 'file_path' => 'demo/background/'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }

        DB::table('media_files')->insert([
            ['file_name' => 'bg-1', 'file_path' => 'demo/background/1.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bg-3', 'file_path' => 'demo/background/3.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'banner1', 'file_path' => 'demo/background/banner1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'inner-pagebg', 'file_path' => 'demo/background/inner-pagebg.jpg', 'file_type' => 'image/jpg', 'file_extension' => 'jpg'],
        ]);

        for ($i=1 ; $i <= 8 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'gallery-'.$i, 'file_path' => 'demo/gallery/'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }

        for ($i=1 ; $i <= 8 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'category-'.$i, 'file_path' => 'demo/courses/course-'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }

        for ($i=1 ; $i <= 16 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'course-'.$i, 'file_path' => 'demo/courses/course-'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
                ['file_name' => 'banner-course-'.$i, 'file_path' => 'demo/courses/banner-course-'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg']
            ]);
        }

        for ($i=1 ; $i <= 5 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'partners-'.$i, 'file_path' => 'demo/partners/'.$i.'.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ]);
        }

        for ($i=1 ; $i <= 8 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'slide-home-'.$i, 'file_path' => 'demo/home/'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }

        for ($i=1 ; $i <= 8 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'slide-hicon-'.$i, 'file_path' => 'demo/home/hicon'.$i.'.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ]);
        }

        for ($i=1 ; $i <= 5 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'testimonial-'.$i, 'file_path' => 'demo/testimonial/'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }

        for ($i=1 ; $i <= 13 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'team-'.$i, 'file_path' => 'demo/team/'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }

        for ($i=1 ; $i <= 6 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'team-c'.$i, 'file_path' => 'demo/team/c'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }

        for ($i=1 ; $i <= 8 ; $i++){
            DB::table('media_files')->insert([
                ['file_name' => 'team-s'.$i, 'file_path' => 'demo/team/s'.$i.'.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ]);
        }

        //News
        DB::table('media_files')->insert([
            ['file_name' => 'news-1', 'file_path' => 'demo/blog/12.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-2', 'file_path' => 'demo/blog/13.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-3', 'file_path' => 'demo/blog/14.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-4', 'file_path' => 'demo/background/1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-5', 'file_path' => 'demo/background/2.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-6', 'file_path' => 'demo/background/3.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-7', 'file_path' => 'demo/background/4.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-banner', 'file_path' => 'demo/news/news-banner.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
        ]);
//
    }
}
