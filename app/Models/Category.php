<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use CrudTrait, HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'categories';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $appends = array('status');

    // protected $fillable = [];
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
    public function category_gallery()
    {
        return $this->hasOne(CategoryGallery::class);
    }

    public function location()
    {
        return $this->belongsToMany(Location::class, 'location_category', 'category_id', 'business_locations_id');
    }

    /**
     * getFormatted returns data to mobile
     * @return mixed
     */
    static public function getFormatted()
    {
        $galleryPath = env('GALLERY_PATH');//get gallery path so we can prepend it to api output for mobile app
        //get categories
        $categories = Category::select('id', 'category_name', 'category_description')->with('galleries:id as image_id,category_image as image_path,category_id')->where('id', 1)->get();
        //iterate through each category so we can format outout
        $categories->each(function (&$category) use ($galleryPath) {
            $galleries = $category->galleries;
//            $galleries->each(function(&$gallery,$key) use($galleries, $galleryPath){
//                $gallery->image_path =  $galleryPath.$gallery->image_path; //prepend image_path for mobile consumption
//                unset($gallery['category_id']);//not needed in api output, but required for with statement, so have to unset
//            });
//            $firstGallery = $galleries[0];//only return first, as required by origional api
//            $category['category_gallery'] = $firstGallery; //change name of key to match origional api
            unset($category['galleries']);//unset name of relation because we replaced this with category_gallery to match origional api
        });
        return $categories;
    }

    public function getLocations($location_id = null)
    {
        $result = array();

        $loc_cats = Category::with('location')->get();


        foreach ($loc_cats as $cat) {
            if (count($cat->location->where('id', $location_id)) > 0)
                array_push($result, array('id' => $cat->id, 'value' => $cat->category_name, 'lid' => 1));
            else
                array_push($result, array('id' => $cat->id, 'value' => $cat->category_name, 'lid' => 0));
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
    public function getStatusAttribute()
    {
        if ($this->is_active == 1)
            return '<span class="text-success" style="font-size:50px;margin-top: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;●</span>';
        else
            return '<span class="text-danger" style="font-size:50px;margin-top: 15px;"">&nbsp;&nbsp;&nbsp;&nbsp;●</span>';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setCategoryImageAttribute($value)
    {
        $attribute_name = "category_image";
        $disk = "public";
        $destination_path = "category";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

}
