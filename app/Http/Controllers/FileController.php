<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

// Interfaces
use App\Interfaces\FileRepositoryInterface;

// Form Requests
use App\Http\Requests\File\FileSpreadsheetImportRequest;

class FileController extends Controller
{
    protected $fileRepositoryInterface;

    /**
     * Construtor
     *
     * @param FileRepositoryInterface $fileRepositoryInterface
     */
    public function __construct(FileRepositoryInterface $fileRepositoryInterface)
    {
        $this->fileRepositoryInterface = $fileRepositoryInterface;
    }

    /**
     * Armazena um arquivo.
     *
     * @param FileSpreadsheetImportRequest $request
     * @return \Illuminate\Http\Response
     */
    public function spreadsheetImport(FileSpreadsheetImportRequest $request)
    {
        $file = $request->file('archive');

        try {
            $this->fileRepositoryInterface->spreadsheetImport($file);
            return response()->json(['message' => 'Os dados da planilha foram importados e serão processados! Dentro de alguns minutos você receberá um email com a confirmação!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Erro ao importar a planilha: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Este retorno nunca deve ser alcançado, mas pode ser deixado como fallback
        return response()->json(['error' => 'Os dados da planilha não foram importados. Por favor, tente novamente'], Response::HTTP_BAD_REQUEST);
    }
}
