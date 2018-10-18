<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProvider extends FormRequest
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
            'name'            => 'required|max:100',
            'phone'           => 'required|digits_between:8,10|max:10',
            'address'         => 'required|max:100',
            'email'           => 'email|max:100',
            'contact'         => 'max:100',
            'website'         => 'active_url|max:100',
            'additional_info' => 'max:200'
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Este correo no es válido.',
        ];
    }
}
