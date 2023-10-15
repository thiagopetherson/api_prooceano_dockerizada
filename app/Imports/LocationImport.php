<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

// Services
use App\Services\Import\LocationImportService;

// Job
use App\Jobs\InsertLocationSpreadsheet;

class LocationImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Checking If header is in the correct order
        LocationImportService::verifyHeader($rows);

        // Creating a array with the data from the spreadsheet
        $formatedSpreadsheet = LocationImportService::formatSpreedsheetToArray($rows);

        // Calling Job
        InsertLocationSpreadsheet::dispatch($formatedSpreadsheet);
    }
}
