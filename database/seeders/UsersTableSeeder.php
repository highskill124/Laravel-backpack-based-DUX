<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();


        $path = 'storage/app/public/database/dux_users.sql';
        DB::unprepared(file_get_contents($path));
        \DB::table('users')->insert(array(
            0 =>
                array(
                    'name' => 'admin',
                    'email' => 'admin@dux.com',
                    'email_verified_at' => NULL,
                    'password' => '$2y$10$FWTKI0Nl/s1cv3PATC52KOhuPQHDRkhMD5gzYLYvjRMcE5xDRQst6',
                    'remember_token' => NULL,
                    'business_address' => NULL,
                    'your_position' => NULL,
                    'city' => NULL,
                    'state_name' => NULL,
                    'zip_code' => NULL,
                    'country' => NULL,
                    'phone' => NULL,
                    'business_name' => 'test',
                    'business_logo' => NULL,
                    'is_active' => 1,
                    'profile_image' => NULL,
                    'last_login' => NULL,
                    'login_ip_address' => NULL,
                    'created_at' => '2022-03-25 11:49:22',
                    'updated_at' => '2022-03-30 16:56:10',
                ),

        ));
        $this->command->info('User Table Import done!');
        $this->command->info('You may login using admin@dux.com');


    }
}
