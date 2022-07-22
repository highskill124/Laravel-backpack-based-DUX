<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-25 13:50:41',
                'updated_at' => '2022-03-25 13:50:41',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'user',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-25 13:50:48',
                'updated_at' => '2022-03-25 13:50:48',
            ),
        ));
        
        
    }
}