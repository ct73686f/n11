<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->hasRole('admin')) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(4);

        return [
            'name'  => 'required|max:255',
            'email' => "required|email|unique:users,email,$id|max:255",
            'password' => 'required_with:password_confirmation|confirmed|min:8'
        ];
    }

    public function messages()
    {
        return [
            'name.max' => 'El nombre no debe ser mayor que 255 caracteres.',
            'email.email' => 'Este correo no es válido.',
            'email.unique' => 'Este correo ya ha sido registrado.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.'
        ];
    }
}
