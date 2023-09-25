<?php

namespace App\Http\Requests\DeviceLocation;

use Illuminate\Foundation\Http\FormRequest;

class DeviceLocationStoreRequest extends FormRequest
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
            'device_id' => 'required|exists:App\Models\Device,id',       
            'latitude' => 'required|min:3|max:50',
            'longitude' => 'required|min:3|max:50',
            'temperature' => 'max:50',
            'salinity' => 'max:50'
        ];
    }

    // Mensagens de resposta das validações da requisição
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'min' => 'O campo :attribute deve ter no mínimo 3 caracteres',           
            'max' => 'O campo :attribute deve ter no máximo 50 caracteres',
            'exists' => 'O equipamento não existe'  
        ];
    }
}