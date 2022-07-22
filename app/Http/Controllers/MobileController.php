<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\DuxCategoryCrudController;
use App\Models\Category;
use App\Models\DuxBusinessLocation;
use App\Models\DuxCategory;
use App\Models\Location;
use App\Repositories\DuxBusinessLocationRepository;
use App\Repositories\DuxCategoryRepository;
use App\Repositories\DuxPromotionsRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Collection\Collection;
use Illuminate\Support\Facades\Http;

use GuzzleHttp;

class MobileController extends Controller
{
    public $galleryPath;

    public function __construct()
    {

    }

    /**
     * Index function will replicate the Old Dux server response
     *  Format must be:
     * [ "message": "Mobile Master List",
     *          "data": {
     *              "categories": [
     *                  {
     *                      "id": 52,
     *                      "category_name": "Counselling",
     *                      "category_description": "Providing a shoulder when needed.",
     *                      "category_gallery": {
     *                      "image_id": 82,
     *                      "image_path": "some_url.png"
     *                  }
     *              ],
     *              "locations":[
     *                  {
     *                      "location_ids": "8",
     *                       "id": 7,
     *                       "promotion_title": "A title",
     *                       "promotion_description": "description",
     *                       "vip_promotion": 0,
     *                       "vip_promotion_description": "",
     *                       "promotion_fineprint": "fineprint"",
     *                       "is_ongoing_promotion": 1,
     *                       "is_active": 1,
     *                       "start_date": "2021-06-25T04:00:00.000Z",
     *                       "end_date": "2021-06-25T04:00:00.000Z",
     *                       "location_id": 8,
     *                       "location_name": "Robusta",
     *                       "location_address": "address",
     *                       "website": "http://robusta-cafe.com",
     *                       "phone_number": "519-265-2655",
     *                       "email_id": "info@robusta-cafe.com",
     *                       "facebook_url": "fburl",
     *                       "twitter_url": "https://twitter.com/caferobusta",
     *                       "instagram_url": "https://www.instagram.com/caferobusta/",
     *                       "youtube_url": "",
     *                       "latitude": 43.546856,
     *                        "longitude": -80.244672,
     *                       "location_gallery": [
     *                          {
     *                              "image_id": "1014",
     *                              "image_path": "https://url/img.jpg"
     *                          }
     *                        ]
     *                     }
     *                  ]
     *                  }
     *                  ]
     *
     * @return Response
     */
    public function index()
    {

        //get category with galleries and only display specific fields

        $response = collect();
        $response->put('message', "MobileMasterList");
        $response->put('data', [
            "categories" => Category::getFormatted(),
            "locations" => Location::getFormatted(),
            //    "deals"=>$deals
        ]);

        return $response;


    }

    public function oldApi(Request $request)
    {
        $response = Http::withToken(env('DUX_BEARER_TOKEN'))->get('https://dux.city/duxapi/mobiledata');

        return $response;
    }

}
