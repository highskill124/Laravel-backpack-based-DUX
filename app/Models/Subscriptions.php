<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\BillingPlan;
use App\Models\User;

class Subscriptions extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'subscriptions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
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
    public function plans()
    {
        return $this->belongsTo(BillingPlan::class,'plan_id','id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function subscriptionCancel($crud = false)
    {
        if($this->status!='Cancelled'){
            $billingDatestr = '';
            if(!empty($this->next_billing_date)){
                $billingDate = date('d F Y',strtotime($this->next_billing_date));
                $billingDatestr = ', your subscription will end on ('.$billingDate.')';
            }
            return '<a class="btn btn-sm btn-link" onclick="return confirm(\'If you cancel your subscription '.$billingDatestr.'?\')"  href="'.env('APP_URL').'/admin/subscription/cancel/'.$this->subscription_id.'" data-toggle="tooltip" title="Subscription Cancel"><i class="la la-link"></i>Cancel</a>';
        }
    }

    public function subscriptionOnOff($crud = false)
    {
        if($this->status=='ACTIVE'){
            return '<a class="btn btn-sm btn-link" onclick="return confirm(\'Do you want to turn Auto-renew off?\')"  href="'.env('APP_URL').'/admin/subscription/suspend/'.$this->subscription_id.'" data-toggle="tooltip" title="Turn Auto Renew off"><i class="la la-link"></i>Turn Auto Renew off</a>';
        }else if($this->status=='SUSPEND'){
            return '<a class="btn btn-sm btn-link" onclick="return confirm(\'Do you want to turn Auto-renew on?\')"  href="'.env('APP_URL').'/admin/subscription/active/'.$this->subscription_id.'" data-toggle="tooltip" title="Turn Auto Renew on"><i class="la la-link"></i>Turn Auto Renew on</a>';
        }
    }
}
