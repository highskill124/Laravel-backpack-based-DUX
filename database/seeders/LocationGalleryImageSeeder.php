<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\LocationGallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LocationGalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = Location::all();
        $numLocations = $locations->count();
        $this->command->info("There are $numLocations existing Locations");
        $numGalleries = LocationGallery::all()->count();
        $this->command->info("There are $numGalleries existing gallery images");

        /**
         * @var $locations Collection
         * var[]/class
         */
        $this->command->info("Importing images");
        $locations->each(function ($loc) {
            /**
             * @var $loc LocationGallery
             * var[]/class
             */

            $gallery = $loc->location_gallery;
            $gallery->each(function ($image) use ($loc) {
                /**
                 * @var $image LocationGallery
                 * var[]/class
                 */
                $filename = $image->location_image;
                $id = $loc->id;
                $newPath = "public/location/$id";
                $response = Storage::makeDirectory($newPath);
                if (Storage::exists("public/location/$id/$filename")) {
                    if (!Storage::exists("$newPath/$filename")){
                        $this->command->info("Found $filename in storage/app/public/location/$filename, moving to $newPath/$filename");
                        Storage::move("public/location/$filename", "$newPath/$filename");
                    }else{
                        $this->command->info("skipping, $filename already moved to correct location $newPath/$filename");
                    }
                } else
                    if (file_exists("/tmp/$filename")) {
                        if (!file_exists("$newPath/$filename")){
                            $this->command->info("Found $filename in /storage/tmp, moving to $newPath/$filename");
                            Storage::move("/tmp/$filename", "public/location/$id/$filename");
                        }else{
                            $this->command->info("skipping, $filename already moved to correct location $newPath/$filename");
                        }
                    }else{
                        $this->command->info(" $filename not found, so scraping");
                        $filename = $image->location_image;
                        if (!Storage::exists("$newPath/$filename")) {
                            $response = Storage::makeDirectory($newPath);
                            $fp = fopen("storage/app/$newPath/$filename", 'w+');              // open file handle
                            $image_url = "https://dux.city/duxapi/locations/$filename";
                            $this->command->info("Scraping $image_url and saving into $newPath/$filename");
                            $ch = curl_init($image_url);
                            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // enable if you want
                            curl_setopt($ch, CURLOPT_FILE, $fp);          // output to file
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 1000);      // some large value to allow curl to run for a long time
                            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
                            // curl_setopt($ch, CURLOPT_VERBOSE, true);   // Enable this line to see debug prints
                            curl_exec($ch);

                            curl_close($ch);                              // closing curl handle
                            fclose($fp);
                        } else {
                            $this->command->info("Skipping $newPath . $filename, already exists");
                        }
                    }



            });


        });
    }
}
