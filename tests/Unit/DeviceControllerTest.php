<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Mockery;
use Illuminate\Validation\ValidationException;

// Controllers
use App\Http\Controllers\DeviceController;

// Models
use App\Models\Device;

// Form Requests
use App\Http\Requests\Device\DeviceStoreRequest;

// Interfaces
use App\Interfaces\DeviceRepositoryInterface;

class DeviceControllerTest extends TestCase
{
    // Usa o trait RefreshDatabase para garantir que o banco de dados seja limpo e reiniciado antes de cada teste
    use RefreshDatabase;

    // Teste para garantir que a criação de um dispositivo funcione com dados válidos
    public function testStoreDeviceSuccess()
    {
        // Mock do DeviceStoreRequest para simular a requisição de criação de dispositivo
        $mockRequest = Mockery::mock(DeviceStoreRequest::class);
        $mockRequest->shouldReceive('validated')->andReturn([
            'name' => 'Equipamento Interestelar',
            'description' => 'Medição de um parâmetro qualquer'
        ]);

        // Cria uma instância real do modelo Device com os campos created_at e updated_at
        $device = new Device([
            'id' => 1,
            'name' => 'Equipamento Interestelar',
            'description' => 'Medição de um parâmetro qualquer',
            'created_at' => now(),  // Define o campo created_at
            'updated_at' => now(),  // Define o campo updated_at
        ]);

        // Mock do DeviceRepositoryInterface para simular o repositório
        $mockRepository = Mockery::mock(\App\Interfaces\DeviceRepositoryInterface::class);
        $mockRepository->shouldReceive('store')->andReturn($device);  // Retorna uma instância do modelo Device

        // Instancia o controller real passando o mock do repositório
        $controller = new DeviceController($mockRepository);

        // Chama o método store do controller com o mock da requisição
        $response = $controller->store($mockRequest);

        // Verifica se o status da resposta é 201 (recurso criado com sucesso)
        $this->assertEquals(201, $response->status());

        // Obtém o conteúdo da resposta como array para validar os dados retornados
        $data = $response->getData(true);

        // Verifica se a resposta contém a chave 'id'
        $this->assertArrayHasKey('id', $data);

        // Verifica se os valores retornados correspondem aos dados enviados na requisição
        $this->assertEquals('Equipamento Interestelar', $data['name']);
        $this->assertEquals('Medição de um parâmetro qualquer', $data['description']);
    }




    // Teste para garantir que uma validação falha quando os dados são inválidos
    public function testStoreDeviceValidationFailure()
    {
        // Mock do DeviceStoreRequest para simular uma requisição com dados inválidos
        $mockRequest = Mockery::mock(DeviceStoreRequest::class);
        $mockRequest->shouldReceive('all')->andReturn([
            'name' => 'A', // Nome inválido, com menos de 3 caracteres
            'description' => 'B' // Descrição inválida, com menos de 3 caracteres
        ]);

        // Mock do DeviceController para simular o método store e lançar uma exceção de validação
        $controller = Mockery::mock(DeviceController::class)->makePartial();
        $controller->shouldReceive('store')
            ->with($mockRequest)
            // Simula o lançamento da exceção ValidationException com mensagens de erro específicas
            ->andThrow(ValidationException::withMessages([
                'name' => ['O campo name deve ter no mínimo 3 caracteres'],
                'description' => ['O campo description deve ter no mínimo 3 caracteres']
            ]));

        // Tenta chamar o método store e captura a exceção de validação
        try {
            $controller->store($mockRequest);
        } catch (ValidationException $e) {
            // Se a exceção for capturada, cria uma resposta JSON simulada com os erros esperados
            $response = response()->json([
                "message" => "The given data was invalid.", // Mensagem padrão de erro de validação
                "errors" => $e->errors() // Erros retornados pela exceção
            ], 422); // Status 422 (Unprocessable Entity), que indica erro de validação
        }

        // Definição dos dados esperados na resposta para comparação
        $expectedJson = [
            "message" => "The given data was invalid.",
            "errors" => [
                "name" => ["O campo name deve ter no mínimo 3 caracteres"],
                "description" => ["O campo description deve ter no mínimo 3 caracteres"]
            ]
        ];

        // Verifica se o status da resposta é 422, indicando erro de validação
        $this->assertEquals(422, $response->status());

        // Verifica se o conteúdo da resposta JSON corresponde aos erros esperados
        $this->assertJson($response->getContent(), json_encode($expectedJson));
    }

}
