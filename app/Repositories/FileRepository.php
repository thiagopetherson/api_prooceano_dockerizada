<?php

namespace App\Repositories;

use Maatwebsite\Excel\Facades\Excel;

// Interfaces
use App\Interfaces\FileRepositoryInterface;

// Imports
use App\Imports\LocationImport;

class FileRepository implements FileRepositoryInterface
{
    /**
     * Importa uma planilha.
     *
     * @param mixed $file
     * @return void
     */
    public function spreadsheetImport($file)
    {
        $fileImport = new LocationImport();
        Excel::import($fileImport, $file);
    }
}
