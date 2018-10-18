<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EditProduct extends FormRequest
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
        $vars = Request::segments();
        $product_id = $vars[3];

        return [
            'description'     => 'required|max:200',
            'image'           => 'mimes:jpeg,bmp,png|max:1200',
            'provider'        => 'required|array|min:1',
            'category'        => 'required|array|min:1',
            'bar_code'        => 'required|required|unique_csv_ed:bar_codes,code,product_id,' . $product_id,
            'unit_price'      => 'required|numeric|min:1',
            'unit_cost'       => 'required|numeric|min:1',
            'wholesale_price' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
