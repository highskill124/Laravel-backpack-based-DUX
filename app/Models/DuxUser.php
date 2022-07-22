<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Class duxUser
 * @package App\Models
 * @version April 21, 2022, 9:24 pm UTC
 *
 * @property Collection $duxPaypalPayments
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string|Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string $business_address
 * @property string $business_address2
 * @property string $your_position
 * @property string $city
 * @property string $state_name
 * @property string $zip_code
 * @property string $country
 * @property string $phone
 * @property string $business_name
 * @property string $business_logo
 * @property boolean $is_active
 * @property string $profile_image
 * @property string|Carbon $last_login
 * @property string $login_ip_address
 */
class DuxUser extends Model
{


    public $table = 'dux_user';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'username',
        'full_name',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'business_address',
        'business_address2',
        'your_position',
        'city',
        'state_name',
        'zip_code',
        'country',
        'phone',
        'business_name',
        'business_logo',
        'is_active',
        'profile_image',
        'last_login',
        'login_ip_address'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string',
        'business_address' => 'string',
        'business_address2' => 'string',
        'your_position' => 'string',
        'city' => 'string',
        'state_name' => 'string',
        'zip_code' => 'string',
        'country' => 'string',
        'phone' => 'string',
        'business_name' => 'string',
        'business_logo' => 'string',
        'is_active' => 'boolean',
        'profile_image' => 'string',
        'last_login' => 'datetime',
        'login_ip_address' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'username' => 'nullable|string|max:30',
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'email_verified_at' => 'nullable',
        'password' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'business_address' => 'nullable|string|max:200',
        'business_address2' => 'nullable|string',
        'your_position' => 'nullable|string|max:200',
        'city' => 'nullable|string|max:200',
        'state_name' => 'nullable|string|max:200',
        'zip_code' => 'nullable|string|max:200',
        'country' => 'nullable|string|max:200',
        'phone' => 'nullable|string|max:200',
        'business_name' => 'nullable|string|max:200',
        'business_logo' => 'nullable|string|max:200',
        'is_active' => 'nullable|boolean',
        'profile_image' => 'nullable|string|max:200',
        'last_login' => 'nullable',
        'login_ip_address' => 'nullable|string|max:20'
    ];

    /**
     * @return HasMany
     **/
    public function duxPaypalPayments()
    {
        return $this->hasMany(DuxPaypalPayment::class, 'user_id');
    }
}
