<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditClient extends FormRequest
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
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'address'    => 'required|max:255',
            'nit'        => 'required|max:20',
            'phone'      => 'required|digits_between:8,10|max:10'
        ];
    }
}
