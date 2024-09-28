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
            'device_id' => 'required|exists:devices,id',       
            'latitude' => 'required|min:3|max:50',
            'longitude' => 'required|min:3|max:50',
            'temperature' => 'required_without:salinity|nullable|numeric|max:50',
            'salinity' => 'required_without:temperature|nullable|numeric|max:50',
        ];
    }

    // Mensagens de resposta das validações da requisição
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'required_without' => 'Pelo menos um dos campos :attributes deve ser preenchido.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'max' => 'O campo :attribute deve ter no máximo :max.',
            'exists' => 'O equipamento não existe'
        ];
    }
}