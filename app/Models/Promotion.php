<?php

namespace App\Models;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'promotions';
    //     protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $appends = array('status');
    // protected $fillable = ['updated_by','created_by'];
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

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'promotion_location','promotion_id','location_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        if($this->is_active==1)
            return '<span class="text-success" style="font-size:50px;margin-top: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;●</span>';
        else
            return '<span class="text-danger" style="font-size:50px;margin-top: 15px;"">&nbsp;&nbsp;&nbsp;&nbsp;●</span>';;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
