<?php

namespace App\Services\Import;

// Helpers
use App\Helpers\CommonHelper;
use App\Helpers\Import\GeneralImportHelper;

class LocationImportService
{
    // Checking If header is in the correct order
    public static function verifyHeader($spreadsheet)
    {
        $header = [
            'NAME','LATITUDE','LONGITUDE'
        ];

        for ($i = 0; $i < count($header); $i++) {
            if($spreadsheet['0'][$i] !==  $header[$i]) {
                throw new \Exception('Erro no Cabeçalho da Planilha de Localizações', 422);
            }
        }
    }

    // Creating a array with the data from the spreadsheet
    public static function formatSpreedsheetToArray($spreadsheet)
    {
        $i = 0;

        $formattedSpreedsheet = [];

        foreach($spreadsheet as $key => $value)
        {
            // Skipping header
            if ($i === 0) {
                $i++;
                continue;
            }

            // Skipping empty lines
            if (GeneralImportHelper::hasEmptyLine($value, 3))
                continue;

            // If column contains empty fields then it does not apply
            if (GeneralImportHelper::hasEmptyFields($value, 3))
                throw new \Exception('Existem campos em branco na planilha de Localizações', 422);

            $formattedSpreedsheet[$i]['name'] = $value[0];
            $formattedSpreedsheet[$i]['latitude'] = CommonHelper::verifyLatitude($value[1], 'LATITUDE', 'localizações');
            $formattedSpreedsheet[$i]['longitude'] = CommonHelper::verifyLongitude($value[2], 'LONGITUDE', 'localizações');
            $i++;
        }

        return $formattedSpreedsheet;
    }
}
