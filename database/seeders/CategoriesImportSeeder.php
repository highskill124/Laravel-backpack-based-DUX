<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'storage/app/public/database/dux_categories.sql';
        $filesize = filesize($path);
        if($filesize>0){
            DB::unprepared(file_get_contents($path));
            $this->command->info('Categories Table Import done!');
        }
    }
}
