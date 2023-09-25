<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthResetPasswordRequest extends FormRequest
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

    // Regras de validações das requisições
    public function rules() {
        return [                         
            'email' => 'required|email|max:100',                      
        ];
    }

    // Mensagens de resposta das validações da requisição
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',                   
            'email.max' => 'O campo de :attribute deve ter no máximo 100 caracteres',           
            'email.email' => 'O campo de :attribute deve ter um endereço válido'    
        ];
    }
}