<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'create-user',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-25 14:38:01',
                'updated_at' => '2022-03-25 14:38:01',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'edit-user',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-25 14:38:05',
                'updated_at' => '2022-03-25 14:38:05',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'list-user',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-25 14:38:10',
                'updated_at' => '2022-03-25 14:38:10',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'delete-user',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-25 14:38:15',
                'updated_at' => '2022-03-25 14:38:15',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'create-permission',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-27 13:38:15',
                'updated_at' => '2022-03-27 13:38:15',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'edit-permission',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-27 13:38:26',
                'updated_at' => '2022-03-27 13:38:26',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'list-permission',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-27 13:38:43',
                'updated_at' => '2022-03-27 13:38:43',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'delete-permission',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-27 13:38:57',
                'updated_at' => '2022-03-27 13:38:57',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'create-promotion',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-27 13:39:30',
                'updated_at' => '2022-03-27 13:39:30',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'edit-promotion',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-27 13:39:38',
                'updated_at' => '2022-03-27 13:39:38',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'delete-promotion',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-27 13:39:47',
                'updated_at' => '2022-03-27 13:39:47',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'list-promotion',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-27 13:40:00',
                'updated_at' => '2022-03-27 13:40:00',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'create-location',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-30 16:36:27',
                'updated_at' => '2022-03-30 16:36:27',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'edit-location',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-30 16:37:30',
                'updated_at' => '2022-03-30 16:37:30',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'delete-location',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-30 16:37:45',
                'updated_at' => '2022-03-30 16:37:45',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'list-location',
                'guard_name' => 'backpack',
                'created_at' => '2022-03-30 16:38:16',
                'updated_at' => '2022-03-30 16:38:16',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'create-category',
                'guard_name' => 'backpack',
                'created_at' => '2022-04-04 15:09:06',
                'updated_at' => '2022-04-04 15:09:27',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'edit-category',
                'guard_name' => 'backpack',
                'created_at' => '2022-04-04 15:09:57',
                'updated_at' => '2022-04-04 15:10:47',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'delete-category',
                'guard_name' => 'backpack',
                'created_at' => '2022-04-04 15:10:56',
                'updated_at' => '2022-04-04 15:10:56',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'list-category',
                'guard_name' => 'backpack',
                'created_at' => '2022-04-04 15:11:18',
                'updated_at' => '2022-04-04 15:11:18',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'create-role',
                'guard_name' => 'backpack',
                'created_at' => '2022-04-07 06:19:28',
                'updated_at' => '2022-04-07 06:19:28',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'edit-role',
                'guard_name' => 'backpack',
                'created_at' => '2022-04-07 06:19:36',
                'updated_at' => '2022-04-07 06:19:36',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'delete-role',
                'guard_name' => 'backpack',
                'created_at' => '2022-04-07 06:19:44',
                'updated_at' => '2022-04-07 06:19:44',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'list-role',
                'guard_name' => 'backpack',
                'created_at' => '2022-04-07 06:19:50',
                'updated_at' => '2022-04-07 06:19:50',
            ),
        ));
        
        
    }
}