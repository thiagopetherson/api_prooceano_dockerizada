<?php

namespace App\Http\Controllers;

// Importing Laravel Excel Library
use Maatwebsite\Excel\Facades\Excel;

// Import Class
use App\Imports\LocationImport;

// Form Request
use App\Http\Requests\File\FileSpreadsheetImportRequest;

// Models
use App\Models\Locations;

class FileController extends Controller
{
    public function spreadsheetImport (FileSpreadsheetImportRequest $request)
    {
        $file = $request->file('archive');

        try {
            $fileImport = new LocationImport();

            Excel::import($fileImport, $file);
            return response()->json(['message' => 'Os dados da planilha foram importados e serão processados! Dentro de alguns minutos você receberá um email com a confirmação.'], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['error' => 'Os dados da planilha não foram importados. Por favor, tente novamente'], 404);
    }
}
