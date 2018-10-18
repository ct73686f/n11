<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditInvoice extends FormRequest
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
            'payment_method' => 'required',
            'credit_type'    => 'required',
            'term'           => 'required|integer',
            'amount'         => 'required|numeric',
            'nit'            => 'required|max:20',
            'description'    => 'max:255',
            'total'          => 'required|numeric',
            'start_date'     => 'required|date_format:"d/m/Y"',
            'end_date'       => 'required|date_format:"d/m/Y"'
        ];
    }
}
