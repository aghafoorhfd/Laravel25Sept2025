<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $customer = [
            ['Customer', '01', '6'],
            ['William','Diana', '7'],
            ['Sarah','Violet', '8'],
            ['Paul','Amora', '9'],
            ['Richard','Davina', '10'],
            ['Shushi','Yashashree', '11'],
            ['Anne','Nami', '12'],
            ['Bush','Elise', '13'],
            ['Elizabeth','Norah', '14'],
            ['James','Alia', '15'],
            ['John','Dakshi', '16'],
        ];

        $IDs = [];
        foreach ($customer as $k=>$v){
            $customer_id = rand(6,16);
            $IDs[] = DB::table('bravo_bookings')->insertGetId(
                [
                    'code' => md5(uniqid() . rand(0, 99999)),
                    'customer_id' => $customer_id,
                    'gateway' => "offline_payment",
                    'total' => 154.00,
                    'status' => 'paid',
                    'email' => 'customer'.rand(1, 8).'@dev.com',
                    'first_name' => $v[0],
                    'last_name' => $v[1],
                    'phone' => '888 999 777',
                    'address' => "Test 1234",
                    'city' => 'Metropolis',
                    'state' => 'New York',
                    'zip_code' => '973',
                    'country' => 'US',
                    'create_user' => $v[2],
                    'created_at' => date("Y-m-d H:i:s"),
                ]);
        }

        foreach ($IDs as $k=>$booking) {
            $course = \Modules\Course\Models\Course::where('id', rand(1,16))->first();
            DB::table('bravo_booking_items')->insertGetId(
                [
                    'booking_id' => $booking,
                    'vendor_id' => $course->create_user,
                    'object_id' => $course->id,
                    'object_model' => 'course',
                    'qty' => 1,
                    'price' => 154.00,
                    'subtotal' => 154.00,
                    'commission' => 15.40,
                    'commission_type' => '{"amount":"10","type":"percent"}',
                    'create_user' => $customer[$k][2],
                    'created_at' => date("Y-m-d H:i:s"),
                ]
            );
            $check = \Modules\Course\Models\Course2User::query()->where([
                'course_id'=>$course->id,
                'user_id'=>$customer_id,
            ])->first();

            if(!$check) {
                $a = new \Modules\Course\Models\Course2User();
                $a->course_id = $course->id;
                $a->user_id = $customer_id;
                $a->order_id = $booking;
                $a->active = 1;
                $a->save();
            }
        }

        $a = new \Modules\Course\Models\Course2User();
        $a->course_id = 1;
        $a->user_id = 1;
        $a->active = 1;
        $a->save();
    }
}
