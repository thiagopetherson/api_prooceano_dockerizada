<?php

namespace App\Helpers;

class CommonHelper
{
    // Checking if latitude is valid
    public static function verifyLatitude($lat, $column, $sheet) {
      // Check if the latitude is within the allowed range
      if ($lat < -90 || $lat > 90)
          throw new \Exception("Erro na coluna {$column} na planilha de {$sheet}", 422);

      return $lat;
    }

    // Checking if longitude is valid
    public static function verifyLongitude($lon, $column, $sheet) {
        // Check if the longitude is within the allowed range
        if ($lon < -180 || $lon > 180)
            throw new \Exception("Erro na coluna {$column} na planilha de {$sheet}", 422);

        return $lon;
    }
}
