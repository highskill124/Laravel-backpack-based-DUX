<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);

        $this->call(BusinessLocationsImportSeeder::class);
        $this->call(CategoriesImportSeeder::class);
        $this->call(CategoryGalleryImportSeeder::class);
        $this->call(PromotionLocationImportSeeder::class);
        $this->call(LocationGallerySeeder::class);
        $this->call(LocationGalleryImageSeeder::class);
    }
}
