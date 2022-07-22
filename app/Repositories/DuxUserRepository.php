<?php

namespace App\Repositories;

use App\Models\DuxUser;
use App\Repositories\BaseRepository;

/**
 * Class dux_usersRepository
 * @package App\Repositories
 * @version April 21, 2022, 9:24 pm UTC
*/

class DuxUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'username',
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
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DuxUser::class;
    }
}
