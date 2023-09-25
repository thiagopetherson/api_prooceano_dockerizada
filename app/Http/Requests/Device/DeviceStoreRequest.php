<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class DeviceStoreRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:3|max:100'          
        ];
    }

    // Mensagens de resposta das validações da requisição
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute deve ter no mínimo 3 caracteres',
            'max' => 'O campo :attribute deve ter no máximo 100 caracteres',           
            'string' => 'O campo :attribute deve ser do tipo string'
        ];
    }
}