<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Models
use App\Models\User;

// Importação do Laravel Excel para simular o comportamento da importação
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Imports
use App\Imports\LocationImport;

class FileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function file_method_spreadsheet_import_success()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        // Configura o usuário como logado
        $this->actingAs($user);

        // Criando um arquivo de teste com cabeçalho e dados válidos
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NAME');
        $sheet->setCellValue('B1', 'LATITUDE');
        $sheet->setCellValue('C1', 'LONGITUDE');
        $sheet->setCellValue('A2', 'Local de Teste');
        $sheet->setCellValue('B2', '12.456552');
        $sheet->setCellValue('C2', '65.321474');

        $writer = new Xlsx($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'test') . '.xlsx';
        $writer->save($tempFilePath);

        $file = new \Illuminate\Http\UploadedFile($tempFilePath, 'test.xlsx', null, null, true);

        // Simulando a importação
        $response = $this->postJson('api/spreadsheet-import', [
            'archive' => $file
        ]);

        // Verificando se a resposta é 200 (OK) e contém a mensagem esperada
        $response->assertStatus(200)
                ->assertJson(['message' => 'Os dados da planilha foram importados e serão processados! Dentro de alguns minutos você receberá um email com a confirmação!']);
        
        // Verificando se os dados foram inseridos no banco de dados
        $this->assertDatabaseHas('locations', [
            'name' => 'Local de Teste',
            'latitude' => '12.456552',
            'longitude' => '65.321474',
        ]);
    }

    /** @test */
    public function file_method_spreadsheet_import_failure()
    {        
        // Criando um usuário fictício
        $user = User::factory()->create();

        // Configura o usuário como logado
        $this->actingAs($user);

        // Criando um arquivo de teste que causará erro durante a importação
        $file = \Illuminate\Http\UploadedFile::fake()->create('error_file.xlsx', 100); // O tamanho do arquivo é 100 KB

        // Aqui, você pode simular o erro no repositório ou usar Mockery para lançar uma exceção
        Excel::shouldReceive('import')->andThrow(new \Exception('Erro ao importar a planilha'));

        // Simulando a importação
        $response = $this->postJson('api/spreadsheet-import', [
            'archive' => $file
        ]);

        // Verificando se a resposta contém o erro esperado
        $response->assertStatus(500)
                 ->assertJson(['error' => 'Erro ao importar a planilha']);
    }
}
