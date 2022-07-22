<?php

use App\Http\Controllers\MobileEndpointController;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PromotionResource;
use App\Models\Category;
use App\Models\Location;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('/mobile', function () {
        return [
            'message' => 'MobileMasterList',
            'data' => [
                "categories" => CategoryResource::collection(Category::all()),
                "locations" => LocationResource::collection(Location::all()),
                "deals" => PromotionResource::collection(Promotion::all()),
            ]
        ];
    });
});

Route::group(['prefix' => 'v2'], function () {
    Route::get('/mobile', [MobileEndpointController::class, 'apiMobileV2']);
    Route::get('/mobile/categories', [MobileEndpointController::class, 'apiCategories']);
    Route::get('/mobile/locations', [MobileEndpointController::class, 'apiLocations']);
    Route::get('/mobile/deals', [MobileEndpointController::class, 'apiDeals']);
});
