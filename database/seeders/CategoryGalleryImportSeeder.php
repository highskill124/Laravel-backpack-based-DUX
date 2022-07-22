<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryGalleryImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'storage/app/public/database/dux_category_gallery.sql';
        $filesize = filesize($path);
        if($filesize>0){
            DB::unprepared(file_get_contents($path));
            $this->command->info('Category Gallery Table Import done!');
        }
    }
}
