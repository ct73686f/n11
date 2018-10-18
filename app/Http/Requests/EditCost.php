<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCost extends FormRequest
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
            'product'         => 'required',
            'unit_price'      => 'required|numeric|min:1',
            'unit_cost'       => 'required|numeric|min:1',
            'wholesale_price' => 'required|numeric|min:1'
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
