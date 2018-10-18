<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description'      => 'required|max:200',
            'image'            => 'required|mimes:jpeg,bmp,png|max:1200',
            'provider'         => 'required|array|min:1',
            'category'         => 'required|array|min:1',
            'bar_code'         => 'required|unique_csv:bar_codes,code',
            'unit_price'       => 'required|numeric|min:1',
            'unit_cost'        => 'required|numeric|min:1',
            'wholesale_price'  => 'required|numeric|min:1',
            'quantity'         => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'bar_code.unique_csv ' => 'Este :attribute asdasd',
        ];
    }
}
