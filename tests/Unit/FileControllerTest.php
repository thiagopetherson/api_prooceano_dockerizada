<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

// Controllers
use App\Http\Controllers\FileController;

// Interfaces
use App\Interfaces\FileRepositoryInterface;

// Form Requests
use App\Http\Requests\File\FileSpreadsheetImportRequest;

/**
 * Testes unitários
 */
class FileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a importação de uma planilha com sucesso.
     *
     * @return void
     */
    public function testSpreadsheetImportSuccess()
    {
        // Mock do FileSpreadsheetImportRequest
        $mockRequest = Mockery::mock(FileSpreadsheetImportRequest::class);
        $mockRequest->shouldReceive('file')->with('archive')->andReturn('fakefile.xlsx');

        // Mock do FileRepositoryInterface
        $mockRepository = Mockery::mock(FileRepositoryInterface::class);
        $mockRepository->shouldReceive('spreadsheetImport')->once();  // Corrigido para usar o método correto

        // Instancia o controller passando o mock do repositório
        $controller = new FileController($mockRepository);

        // Chama o método spreadsheetImport do controller
        $response = $controller->spreadsheetImport($mockRequest);

        // Verifica se o status da resposta é 200 (OK)
        $this->assertEquals(200, $response->status()); // Alterado para 200
        $this->assertJson($response->getContent(), json_encode(['message' => 'Os dados da planilha foram importados e serão processados! Dentro de alguns minutos você receberá um email com a confirmação!']));
    }

    /**
     * Testa a falha na importação de uma planilha.
     *
     * @return void
     */
    public function testSpreadsheetImportFailure()
    {
        // Mock do FileSpreadsheetImportRequest
        $mockRequest = Mockery::mock(FileSpreadsheetImportRequest::class);
        $mockRequest->shouldReceive('file')->with('archive')->andReturn('fakefile.xlsx');

        // Mock do FileRepositoryInterface
        $mockRepository = Mockery::mock(FileRepositoryInterface::class);
        $mockRepository->shouldReceive('spreadsheetImport')->andThrow(new \Exception('Erro ao importar a planilha'));

        // Instancia o controller passando o mock do repositório
        $controller = new FileController($mockRepository);

        // Chama o método spreadsheetImport do controller
        $response = $controller->spreadsheetImport($mockRequest);

        // Verifica se o status da resposta é 500, indicando erro no servidor
        $this->assertEquals(500, $response->status());
        $this->assertJson($response->getContent(), json_encode(['error' => 'Erro ao importar a planilha']));
    }
}
