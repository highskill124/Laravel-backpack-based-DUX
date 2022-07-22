<?php

namespace Database\Seeders;

use App\Models\LocationGallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = LocationGallery::all()->count();
        $this->command->info("There are $num Location Galleries already");
        $this->command->info("Deleting LocationGalleries table");
        \DB::table('location_gallery')->delete();
        $path = 'storage/app/public/database/dux_location_gallery.sql';
        $filesize = filesize($path);
        if ($filesize > 0) {
            DB::unprepared(file_get_contents($path));
            $this->command->info("Recreating Location Galleries table and starting import");
            $num = LocationGallery::all()->count();
            $this->command->info("$num Location Galleries imported");
        }
    }
}
