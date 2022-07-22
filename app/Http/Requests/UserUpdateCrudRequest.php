<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->get('id') ?? request()->route('id');

        return [
            'email'    => 'required|unique:'.config('permission.table_names.users', 'users').',email,'.$id,
            'name'     => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'password' => 'confirmed',
            'phone' => 'required|min:6',
            'business_address' => 'required|min:5',
            'your_position' => 'required|min:5',
            'city' => 'required|min:4',
            'state_name' => 'required|min:4',
            'country' => 'required|min:4',
            'business_name' => 'required|min:4',
            'is_active' => 'required|min:1',
            'zip_code' => 'required|min:3',
        ];
    }
}
