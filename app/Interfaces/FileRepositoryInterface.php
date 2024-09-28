<?php

namespace App\Interfaces;

interface FileRepositoryInterface
{
    /**
     * Importa uma planilha.
     *
     * @param mixed $file O arquivo da planilha a ser importada.
     * @return void
     */
    public function spreadsheetImport($file);
}
