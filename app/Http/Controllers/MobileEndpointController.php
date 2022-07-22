<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PromotionResource;
use App\Models\Category;
use App\Models\Location;
use App\Models\Promotion;
use Illuminate\Http\Request;

class MobileEndpointController extends Controller
{

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function apiMobileV2(Request $request)
    {
        if ($request->bearerToken()) {
            if (env('DUX_BEARER_TOKEN') === $request->bearerToken()) {
                $domain = env('APP_URL');
                $perPage = 10;

                $category = Category::paginate($perPage);
                $location = Location::paginate($perPage);
                $promotion = Promotion::paginate($perPage);

                $category_count = Category::count();
                $location_count = Location::count();
                $promotion_count = Promotion::count();

                $totalRecode = max($category_count, $location_count, $promotion_count);

                $lastPage = ceil($totalRecode / $perPage);
                $currentPage = $request->page ?? 1;

                $prevPage = $currentPage != 1 ? $currentPage - 1 : null;
                $nextPage = $currentPage != $lastPage ? $currentPage + 1 : null;

                return [
                    'message' => 'MobileMasterList',
                    'data' => [
                        "categories" => CategoryResource::collection($category),
                        "locations" => LocationResource::collection($location),
                        "deals" => PromotionResource::collection($promotion),
                    ],
                    "links" => [
                        "first" => $domain . "/api/v2/mobile?page=1",
                        "last" => $domain . "/api/v2/mobile?page=" . $lastPage,
                        "prev" => $prevPage !== null ? $domain . "/api/v2/mobile?page=" . $prevPage : null,
                        "next" => $nextPage !== null ? $domain . "/api/v2/mobile?page=" . $nextPage : null
                    ],
                ];
            } else {
                return response()->json(['error' => ['message' => 'Invalid Authorization Token!']], 404);
            }
        } else {
            return response()->json(['error' => ['message' => 'Please Provide Authorization Token']], 404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function apiCategories(Request $request)
    {
        if ($request->bearerToken()) {
            if (env('DUX_BEARER_TOKEN') === $request->bearerToken()) {
                $category = Category::paginate(10);
                return CategoryResource::collection($category);
            } else {
                return response()->json(['error' => ['message' => 'Invalid Authorization Token!']], 404);
            }
        } else {
            return response()->json(['error' => ['message' => 'Please Provide Authorization Token']], 404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function apiLocations(Request $request)
    {
        if ($request->bearerToken()) {
            if (env('DUX_BEARER_TOKEN') === $request->bearerToken()) {
                $location = Location::paginate(10);
                return LocationResource::collection($location);
            } else {
                return response()->json(['error' => ['message' => 'Invalid Authorization Token!']], 404);
            }
        } else {
            return response()->json(['error' => ['message' => 'Please Provide Authorization Token']], 404);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function apiDeals(Request $request)
    {
        if ($request->bearerToken()) {
            if (env('DUX_BEARER_TOKEN') === $request->bearerToken()) {
                $promotion = Promotion::paginate(10);
                return PromotionResource::collection($promotion);
            } else {
                return response()->json(['error' => ['message' => 'Invalid Authorization Token!']], 404);
            }
        } else {
            return response()->json(['error' => ['message' => 'Please Provide Authorization Token']], 404);
        }
    }
}
