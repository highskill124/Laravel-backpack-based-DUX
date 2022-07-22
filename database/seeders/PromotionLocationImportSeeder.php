<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionLocationImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'storage/app/public/database/dux_promotion_location.sql';
        $filesize = filesize($path);
        if($filesize>0){
            DB::unprepared(file_get_contents($path));
            $this->command->info('Promotion Location Table Import done!');
        }
    }
}
