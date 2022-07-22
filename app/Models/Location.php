<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use CrudTrait, HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'business_locations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['location_name', 'by_line', 'location_address', 'location_description', 'location_address',
        'website', 'email_id', 'phone_number', 'facebook_url', 'twitter_url', 'notes', 'user_id',
        'instagram_url', 'youtube_url', 'latitude', 'longitude', 'is_active', 'map_changed', 'updated_by', 'created_by',
        'is_open_sunday', 'is_open_monday', 'is_open_tuesday', 'is_open_wednesday', 'is_open_thrusday', 'is_open_friday', 'is_open_saturday',
        'start_time_sunday', 'end_time_sunday', 'start_time_monday', 'end_time_monday', 'start_time_tuesday', 'end_time_tuesday', 'start_time_wednesday',
        'end_time_wednesday', 'start_time_thrusday', 'start_time_friday', 'end_time_friday', 'start_time_saturday', 'end_time_saturday'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'location_category', 'business_locations_id', 'category_id');
    }

    public function location_gallery()
    {
        return $this->hasMany(LocationGallery::class, 'location_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * getFormatted returns data for mobile app
     * @return mixed
     */
    static public function getFormatted()
    {

        //get categories
        $locations = Location::all();

        //iterate through each category so we can format outout
        $locations->each(function (&$location, $key) {
            //remove days that location is not open according to original api
            $categories = $location->categories();
            $locationCategories = collect();
            $categories->each(function ($category) use ($locationCategories) {
                $locationCategories->add($category->category_name);
            });
            $location['categories'] = [];
            $location['opening_hours'] = $locationCategories;
            //sunday
            if ($location['is_open_sunday'] === 1) {
                $location['opening_hours']["sunday"] = [
                    "is_open" => 1,
                    "open" => $location["start_time_sunday"],
                    "close" => $location["close_time_sunday"]
                ];
            } else {
                unset($location['is_open_sunday']);
            }
            //monday
            if ($location['is_open_monday'] === 1) {
                $location['opening_hours']["monday"] = [
                    "is_open" => 1,
                    "open" => $location["start_time_monday"],
                    "close" => $location["close_time_monday"]
                ];
            } else {
                unset($location['is_open_monday']);
            }
            //tuesday
            if ($location['is_open_tuesday'] === 1) {
                $location['opening_hours']["tuesday"] = [
                    "is_open" => 1,
                    "open" => $location["start_time_tuesday"],
                    "close" => $location["close_time_tuesday"]
                ];
            } else {
                unset($location['is_open_tuesday']);
            }
            //wednesday
            if ($location['is_open_wednesday'] === 1) {
                $location['opening_hours']["wednesday"] = [
                    "is_open" => 1,
                    "open" => $location["start_time_wednesday"],
                    "close" => $location["close_time_wednesday"]
                ];
            } else {
                unset($location['is_open_wednesday']);
            }
            //thrusday
            if ($location['is_open_thrusday'] === 1) {
                $location['opening_hours']["thrusday"] = [
                    "is_open" => 1,
                    "open" => $location["start_time_thrusday"],
                    "close" => $location["close_time_thrusday"]
                ];
            } else {
                unset($location['is_open_thrusday']);
            }
            //friday
            if ($location['is_open_friday'] === 1) {
                $location['opening_hours']["friday"] = [
                    "is_open" => 1,
                    "open" => $location["start_time_friday"],
                    "close" => $location["close_time_friday"]
                ];
            } else {
                unset($location['is_open_friday']);
            }
            //saturday
            if ($location['is_open_saturday'] === 1) {
                $location['opening_hours']["saturday"] = [
                    "is_open" => 1,
                    "open" => $location["start_time_saturday"],
                    "close" => $location["close_time_saturday"]
                ];
            } else {
                unset($location['is_open_saturday']);
            }
            unset($location['start_time_sunday']);
            unset($location['end_time_sunday']);
            unset($location['start_time_monday']);
            unset($location['end_time_monday']);
            unset($location['start_time_tuesday']);
            unset($location['end_time_tuesday']);
            unset($location['start_time_wednesday']);
            unset($location['end_time_wednesday']);
            unset($location['start_time_thrusday']);
            unset($location['end_time_thrusday']);
            unset($location['start_time_friday']);
            unset($location['end_time_friday']);
            unset($location['start_time_saturday']);
            unset($location['end_time_saturday']);


        });

        return $locations;
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_location', 'location_id', 'promotion_id');
    }


    public function getPromotions($promotion_id = null)
    {
        $result = array();

        $loc_cats = Location::with('promotions')->where('user_id', backpack_user()->id)->get();


        foreach ($loc_cats as $cat) {
            if (count($cat->promotions->where('id', $promotion_id)) > 0)
                array_push($result, array('id' => $cat->id, 'location_name' => $cat->location_name, 'lid' => 1));
            else
                array_push($result, array('id' => $cat->id, 'location_name' => $cat->location_name, 'lid' => 0));
        }

        return $result;
    }




    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
