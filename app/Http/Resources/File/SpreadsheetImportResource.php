<?php

namespace App\Http\Resources\File;

use Illuminate\Http\Resources\Json\JsonResource;

class SpreadsheetImportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Aqui você pode definir a estrutura da resposta
        return [
            'message' => $this->resource['message'], // Acessa a mensagem passada para o resource
        ];
    }
}

