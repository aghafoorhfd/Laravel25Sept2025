<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Cache::flush();
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(Language::class);
        $this->call(MediaFileSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(General::class);
        $this->call(News::class);
        $this->call(CourseSeeder::class);
        $this->call(BookingItemSeeder::class);
    }
}

