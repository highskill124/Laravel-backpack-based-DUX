<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryGallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryGalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = Category::with('category_gallery')->get();

        /**
         * @var $locations Collection
         * var[]/class
         */
        $locations->each(function ($loc) {
            $gallery = $loc->category_gallery;
            if(!empty($gallery)){
                $gallery->each(function ($image) {
                    if(!empty($image->category_image)){
                        $image_file = $image->category_image;
                        $path = 'storage/app/public/category/';
                        $filename = $path . $image_file;
                        if (!file_exists($filename)) {
                            $fp = fopen($filename, 'w+');              // open file handle
                            $image_url = "https://dux.city/duxapi/category/$image_file";
                            echo "Scraping $image_url\n";
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
                            echo "$filename  already scraped\n";
                        }
                    }
                });
            }
        });
    }
}
