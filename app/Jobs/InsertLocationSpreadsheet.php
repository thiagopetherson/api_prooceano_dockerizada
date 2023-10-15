<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// Models
use App\Models\Location;

class InsertLocationSpreadsheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $spreadsheetFile;
    protected $enterpriseSheetErrors = 0; // Error counter on each line

    public function __construct($spreadsheetFile)
    {
        $this->spreadsheetFile = $spreadsheetFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Creating from data
        foreach($this->spreadsheetFile as $row)
        {
            try{
                $data = [
                    'name' => $row['name']
                ];

                $newData = [
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude']
                ];

                if(!Location::updateOrCreate($data, $newData))
                    $this->enterpriseSheetErrors++;

            } catch(\Exception $e) {
                throw new \Exception('Erro na criação dos dados da planilha de localizações: ' . $e->getMessage());
            }
        }

        if ($this->enterpriseSheetErrors === 0) logger('Dados da planilha inseridos com sucesso');
        else throw new \Exception('Não foram inseridas todas as linhas da planilha. Verifique!');
    }

     // return number of error found
     public function getEnterpriseSheetErrors(): int
     {
        return $this->enterpriseSheetErrors;
     }
}
