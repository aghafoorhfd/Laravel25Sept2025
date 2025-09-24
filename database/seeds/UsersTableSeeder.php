<?php

use Illuminate\Database\Seeder;
use Modules\Media\Models\MediaFile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@dev.com',
            'password' => bcrypt('admin123@@'),
            'phone'   => '112 666 888',
            'status'   => 'publish',
            'created_at' =>  date("Y-m-d H:i:s"),
            'avatar_id' => MediaFile::findMediaByName("team-1")->id,
            'bio'=> '<h4>Hello! This is my story.</h4>
								<p>Hello! I am a Seattle/Tacoma, Washington area graphic designer with over 6 years of graphic design experience. I specialize in designing infographics, icons, brochures, and flyers.</p>
								<ul class="instructor_estimate">
									<li>Included in my estimate:</li>
									<li>Custom illustrations</li>
									<li>Stock images</li>
									<li>Any final files you need</li>
								</ul>
								<p>If you have a specific budget or deadline, let me know and I will work with you!</p>',
            'education' => '[{"from":"2015","to":"2019","location":"Harvard University","reward":"MBA from Harvard Business School"},{"from":"2011","to":"2015","location":"Tomms College","reward":"Bachlors in Fine Arts"}]',
            'experience' => '[{"from":"2015","to":"2019","location":"Google","position":"Web Designer"},{"from":"2011","to":"2015","location":"Facebook","position":"CEO Founder"},{"from":"2011","to":"2015","location":"Tomms College","position":"CEO Founder"}]',
            'social_media' => '{"skype":"bookingcore.org","facebook":"https:\/\/bookingcore.org\/","twitter":"https:\/\/bookingcore.org\/","instagram":"https:\/\/bookingcore.org\/","pinterest":"https:\/\/bookingcore.org\/","dribbble":"https:\/\/bookingcore.org\/","google":"https:\/\/bookingcore.org\/"}'
        ]);
        $user = \App\User::where('email','admin@dev.com')->first();
        $user->assignRole('administrator');

        DB::table('users')->insert([
            'first_name' => 'Vendor',
            'last_name' => '01',
            'email' => 'vendor1@dev.com',
            'password' => bcrypt('123456Aa@@'),
            'phone'   => '112 666 888',
            'status'   => 'publish',
            'created_at' =>  date("Y-m-d H:i:s"),
            'avatar_id' => MediaFile::findMediaByName("team-2")->id,
            'bio'=> '<h4>Hello! This is my story.</h4>
								<p>Hello! I am a Seattle/Tacoma, Washington area graphic designer with over 6 years of graphic design experience. I specialize in designing infographics, icons, brochures, and flyers.</p>
								<ul class="instructor_estimate">
									<li>Included in my estimate:</li>
									<li>Custom illustrations</li>
									<li>Stock images</li>
									<li>Any final files you need</li>
								</ul>
								<p>If you have a specific budget or deadline, let me know and I will work with you!</p>',
            'education' => '[{"from":"2015","to":"2019","location":"Harvard University","reward":"MBA from Harvard Business School"},{"from":"2011","to":"2015","location":"Tomms College","reward":"Bachlors in Fine Arts"}]',
            'experience' => '[{"from":"2015","to":"2019","location":"Google","position":"Web Designer"},{"from":"2011","to":"2015","location":"Facebook","position":"CEO Founder"},{"from":"2011","to":"2015","location":"Tomms College","position":"CEO Founder"}]',
            'social_media' => '{"skype":"bookingcore.org","facebook":"https:\/\/bookingcore.org\/","twitter":"https:\/\/bookingcore.org\/","instagram":"https:\/\/bookingcore.org\/","pinterest":"https:\/\/bookingcore.org\/","dribbble":"https:\/\/bookingcore.org\/","google":"https:\/\/bookingcore.org\/"}'
        ]);
        $user = \App\User::where('email','vendor1@dev.com')->first();
        $user->assignRole('vendor');

        $vendor= [
            ['Elise','Aarohi'],
            ['Kaytlyn','Alvapriya'],
            ['Lynne','Victoria']
        ];
        foreach ($vendor as $k=>$v){
            DB::table('users')->insert([
                'first_name' => $v[0],
                'last_name' => $v[1],
                'email' =>  $v[1].'@dev.com',
                'password' => bcrypt('123456Aa@@'),
                'phone'   => '112 666 888',
                'status'   => 'publish',
                'created_at' =>  date("Y-m-d H:i:s"),
                'avatar_id' => MediaFile::findMediaByName("team-".($k+3))->id,
                'bio'=> '<h4>Hello! This is my story.</h4>
								<p>Hello! I am a Seattle/Tacoma, Washington area graphic designer with over 6 years of graphic design experience. I specialize in designing infographics, icons, brochures, and flyers.</p>
								<ul class="instructor_estimate">
									<li>Included in my estimate:</li>
									<li>Custom illustrations</li>
									<li>Stock images</li>
									<li>Any final files you need</li>
								</ul>
								<p>If you have a specific budget or deadline, let me know and I will work with you!</p>',
                'education' => '[{"from":"2015","to":"2019","location":"Harvard University","reward":"MBA from Harvard Business School"},{"from":"2011","to":"2015","location":"Tomms College","reward":"Bachlors in Fine Arts"}]',
                'experience' => '[{"from":"2015","to":"2019","location":"Google","position":"Web Designer"},{"from":"2011","to":"2015","location":"Facebook","position":"CEO Founder"},{"from":"2011","to":"2015","location":"Tomms College","position":"CEO Founder"}]',
                'social_media' => '{"skype":"bookingcore.org","facebook":"https:\/\/bookingcore.org\/","twitter":"https:\/\/bookingcore.org\/","instagram":"https:\/\/bookingcore.org\/","pinterest":"https:\/\/bookingcore.org\/","dribbble":"https:\/\/bookingcore.org\/","google":"https:\/\/bookingcore.org\/"}'
            ]);
            $user = \App\User::where('email',$v[1].'@dev.com')->first();
            $user->assignRole('vendor');
        }

        DB::table('users')->insert([
            'first_name' => 'Customer',
            'last_name' => '01',
            'email' => 'customer1@dev.com',
            'password' => bcrypt('123456Aa@@'),
            'phone'   => '112 666 888',
            'status'   => 'publish',
            'created_at' =>  date("Y-m-d H:i:s"),
            'avatar_id' => MediaFile::findMediaByName("team-6")->id,
            'bio'=> '<h4>Hello! This is my story.</h4>
								<p>Hello! I am a Seattle/Tacoma, Washington area graphic designer with over 6 years of graphic design experience. I specialize in designing infographics, icons, brochures, and flyers.</p>
								<ul class="instructor_estimate">
									<li>Included in my estimate:</li>
									<li>Custom illustrations</li>
									<li>Stock images</li>
									<li>Any final files you need</li>
								</ul>
								<p>If you have a specific budget or deadline, let me know and I will work with you!</p>',
            'education' => '[{"from":"2015","to":"2019","location":"Harvard University","reward":"MBA from Harvard Business School"},{"from":"2011","to":"2015","location":"Tomms College","reward":"Bachlors in Fine Arts"}]',
            'experience' => '[{"from":"2015","to":"2019","location":"Google","position":"Web Designer"},{"from":"2011","to":"2015","location":"Facebook","position":"CEO Founder"},{"from":"2011","to":"2015","location":"Tomms College","position":"CEO Founder"}]',
            'social_media' => '{"skype":"bookingcore.org","facebook":"https:\/\/bookingcore.org\/","twitter":"https:\/\/bookingcore.org\/","instagram":"https:\/\/bookingcore.org\/","pinterest":"https:\/\/bookingcore.org\/","dribbble":"https:\/\/bookingcore.org\/","google":"https:\/\/bookingcore.org\/"}'
        ]);
        $user = \App\User::where('email','customer1@dev.com')->first();
        $user->assignRole('customer');


        $customer = [
            ['William','Diana'],
            ['Sarah','Violet'],
            ['Paul','Amora'],
            ['Richard','Davina'],
            ['Shushi','Yashashree'],
            ['Anne','Nami'],
            ['Bush','Elise'],
            ['Elizabeth','Norah'],
            ['James','Alia'],
            ['John','Dakshi'],
        ];
        foreach ($customer as $k=>$v){
            DB::table('users')->insert([
                'first_name' => $v[0],
                'last_name' => $v[1],
                'email' =>  $v[1].'@dev.com',
                'password' => bcrypt('123456Aa@@'),
                'phone'   => '888 999 777',
                'status'   => 'publish',
                'created_at' =>  date("Y-m-d H:i:s"),
                'avatar_id' => MediaFile::findMediaByName("team-".rand(7,13))->id,
                'bio'=> '<h4>Hello! This is my story.</h4>
								<p>Hello! I am a Seattle/Tacoma, Washington area graphic designer with over 6 years of graphic design experience. I specialize in designing infographics, icons, brochures, and flyers.</p>
								<ul class="instructor_estimate">
									<li>Included in my estimate:</li>
									<li>Custom illustrations</li>
									<li>Stock images</li>
									<li>Any final files you need</li>
								</ul>
								<p>If you have a specific budget or deadline, let me know and I will work with you!</p>',
                'education' => '[{"from":"2015","to":"2019","location":"Harvard University","reward":"MBA from Harvard Business School"},{"from":"2011","to":"2015","location":"Tomms College","reward":"Bachlors in Fine Arts"}]',
                'experience' => '[{"from":"2015","to":"2019","location":"Google","position":"Web Designer"},{"from":"2011","to":"2015","location":"Facebook","position":"CEO Founder"},{"from":"2011","to":"2015","location":"Tomms College","position":"CEO Founder"}]',
                'social_media' => '{"skype":"bookingcore.org","facebook":"https:\/\/bookingcore.org\/","twitter":"https:\/\/bookingcore.org\/","instagram":"https:\/\/bookingcore.org\/","pinterest":"https:\/\/bookingcore.org\/","dribbble":"https:\/\/bookingcore.org\/","google":"https:\/\/bookingcore.org\/"}'

            ]);
            $user = \App\User::where('email',$v[1].'@dev.com')->first();
            $user->assignRole('customer');
        }
    }
}
