<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
        return [
             'location_name' => 'required',
             'location_description' => 'required',
             'location_address' => 'required',
             'phone_number' => 'required',
             'email_id' => 'required|email',
             'latitude' => 'required',
             'longitude' => 'required',
             'is_active' => 'required',
             'category' => 'required',
//             'from_sun_hr' =>  'required_if:is_open_sunday,==,1|digits_between:0,12',
//             'to_sun_hr' =>  'required_if:is_open_sunday,==,1|digits_between:0,12',
//             'from_sun_min' =>  'required_if:is_open_sunday,==,1|digits_between:0,59',
//             'to_sun_min' =>  'required_if:is_open_sunday,==,1|digits_between:0,59',
//             'from_mon_hr' =>  'required_if:is_open_monday,==,1|digits_between:0,12',
//             'to_mon_hr' =>  'required_if:is_open_monday,==,1|digits_between:0,12',
//             'from_mon_min' =>  'required_if:is_open_monday,==,1|digits_between:0,59',
//             'to_mon_min' =>  'required_if:is_open_monday,==,1|digits_between:0,59',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
