<?php

namespace App\Helpers\Import;

class GeneralImportHelper
{
    // Checking if all fields are blank
    public static function hasEmptyLine($fields, $numberOfFields)
    {
        $count = 0;
        for ($i = 0; $i < $numberOfFields; $i++) {
          if(empty(trim($fields[$i])) || !isset($fields[$i]))
            $count++;
        }

        return $count === $numberOfFields ? true : false;
    }

    // Checking If exists empty fields
    public static function hasEmptyFields($fields, $numberOfFields)
    {
        for ($i = 0; $i < $numberOfFields; $i++) {
            if ( (!isset($fields[$i]) || empty($fields[$i])) && $fields[$i] !== 0 )
                return true;
        }

        return false;
    }
}
