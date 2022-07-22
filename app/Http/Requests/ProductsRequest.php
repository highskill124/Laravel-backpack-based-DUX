<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
        if($this->get('id')){
            $id = request()->route('id');

            return [
                'title' => 'required|min:5|max:255|unique:products,title,'.$id,
                'description' => 'required|min:5',
                //'image_url' => 'required|mimes:jpg,jpeg,png',
                //'home_url' => 'required',
            ];
        }else{
            return [
                'title' => 'required|min:5|max:255|unique:products,title',
                'description' => 'required|min:5',
                //'image_url' => 'required|mimes:jpg,jpeg,png',
                //'home_url' => 'required',
            ];
        }
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
