<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotation extends FormRequest
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
            'credit'          => 'required_without_all:cash,card,check,deposit|numeric|min:1',
            'cash'            => 'required_without_all:credit,card,check,deposit|numeric|min:1',
            'card'            => 'required_without_all:credit,cash,check,deposit|numeric|min:1',
            'check'           => 'required_without_all:credit,cash,card,deposit|numeric|min:1',
            'deposit'         => 'required_without_all:credit,cash,card,check|numeric|min:1',
            'discount'        => 'required|numeric',
            'client'          => 'required',
            'nit'             => 'required|max:20',
            'description'     => 'max:255',
            'product'         => 'required|array|min:1',
            'wholesale_apply' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product.required' => 'Debe ingresar por lo menos un producto'
        ];
    }
}
