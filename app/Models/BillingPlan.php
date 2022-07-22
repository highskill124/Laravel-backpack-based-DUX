<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\Subscriptions;

class BillingPlan extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'billing_plans';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['title','description','product_id','tenure_type','frequency_interval_unit','interval_count','total_cycles','paypal_plan_link','paypal_plan_id','status','taxes_percentage','taxes_inclusive','price','tax','currency','created_at','updated_at'];
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
    public function productlist()
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }

    public function copyLink($crud = false)
    {
        return '<a class="btn btn-sm btn-link" id="copylink" href="javascript:void(0);" onclick="myFunction()" data-route="'.env('APP_URL').'/checkout/'.$this->paypal_plan_id.'" data-toggle="tooltip" title="Copy link paypal plan"><i class="la la-link"></i>Copy Paypal Link</a>';
    }
}
