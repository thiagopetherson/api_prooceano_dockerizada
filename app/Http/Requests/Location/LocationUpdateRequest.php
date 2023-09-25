<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:200',
            'latitude' => 'required|string|min:3|max:50',
            'longitude' => 'required|string|min:3|max:50'
        ];
    }

    // Mensagens de resposta das validações da requisição
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute deve ter no mínimo 3 caracteres',
            'name.max' => 'O campo nome deve ter no máximo 200 caracteres',
            'latitude.max' => 'O campo latitude deve ter no máximo 50 caracteres',
            'longitude.max' => 'O campo longitude deve ter no máximo 50 caracteres',
            'string' => 'O campo :attribute deve ser do tipo string'
        ];
    }
}