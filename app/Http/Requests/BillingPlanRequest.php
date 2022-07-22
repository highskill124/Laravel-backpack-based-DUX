<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillingPlanRequest extends FormRequest
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
                'product_id'=>'required',
                'title'=>'required|unique:billing_plans,title,'.$id,
                'description'=>'required|max:1024',
                'price'=>'required|numeric',
                'currency'=>'required|in:CAD,USD',
                'status'=>'required|in:Active,Inactive',
                'tenure_type'=>'required|in:Regular,Trial',
                'frequency_interval_unit'=>'required|in:day,week,month,year',
                'interval_count'=>'required|numeric'
            ];
        }else{
            return [
                'product_id'=>'required',
                'title'=>'required|unique:billing_plans,title',
                'description'=>'required|max:1024',
                'price'=>'required|numeric',
                'currency'=>'required|in:CAD,USD',
                'status'=>'required|in:Active,Inactive',
                'tenure_type'=>'required|in:Regular,Trial',
                'frequency_interval_unit'=>'required|in:day,week,month,year',
                'interval_count'=>'required|numeric'
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
