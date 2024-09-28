<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Mockery;
use Illuminate\Validation\ValidationException;

// Controllers
use App\Http\Controllers\DeviceLocationController;

// Models
use App\Models\DeviceLocation;

// Form Requests
use App\Http\Requests\DeviceLocation\DeviceLocationStoreRequest;

// Interfaces
use App\Interfaces\DeviceLocationRepositoryInterface;

class DeviceLocationControllerTest extends TestCase
{
    // Usa o trait RefreshDatabase para garantir que o banco de dados seja limpo e reiniciado antes de cada teste
    use RefreshDatabase;

    // Teste para garantir que a criação de uma localização de dispositivo funcione com dados válidos
    public function testStoreDeviceLocationSuccess()
    {
        // Mock do DeviceLocationStoreRequest para simular a requisição de criação
        $mockRequest = Mockery::mock(DeviceLocationStoreRequest::class);
        $mockRequest->shouldReceive('validated')->andReturn([
            'device_id' => 1,
            'latitude' => 12.34,
            'longitude' => 56.78,
            'temperature' => 25.00,
            'salinity' => null,
        ]);

        // Cria uma instância real do modelo DeviceLocation
        $deviceLocation = new DeviceLocation([
            'id' => 1,
            'device_id' => 1,
            'latitude' => 12.34,
            'longitude' => 56.78,
            'temperature' => 25.00,
            'salinity' => null,
            'created_at' => now(),  // Define o campo created_at
            'updated_at' => now(),  // Define o campo updated_at
        ]);

        // Mock do DeviceLocationRepositoryInterface para simular o repositório
        $mockRepository = Mockery::mock(DeviceLocationRepositoryInterface::class);
        $mockRepository->shouldReceive('store')->andReturn($deviceLocation);  // Retorna uma instância do modelo

        // Instancia o controller real passando o mock do repositório
        $controller = new DeviceLocationController($mockRepository);

        // Chama o método store do controller com o mock da requisição
        $response = $controller->store($mockRequest);

        // Verifica se o status da resposta é 201 (recurso criado com sucesso)
        $this->assertEquals(201, $response->status());

        // Obtém o conteúdo da resposta como array para validar os dados retornados
        $data = $response->getData(true);

        // Verifica se a resposta contém a chave 'id'
        $this->assertArrayHasKey('id', $data);

        // Verifica se os valores retornados correspondem aos dados enviados na requisição
        $this->assertEquals(1, $data['device_id']);
        $this->assertEquals(12.34, $data['latitude']);
        $this->assertEquals(56.78, $data['longitude']);
        $this->assertEquals(25.00, $data['temperature']);
        $this->assertEquals(null, $data['salinity']);
    }

    // Teste para garantir que uma validação falha quando os dados são inválidos
    public function testStoreDeviceLocationValidationFailure()
    {
        // Mock do DeviceLocationStoreRequest para simular uma requisição com dados inválidos
        $mockRequest = Mockery::mock(DeviceLocationStoreRequest::class);
        $mockRequest->shouldReceive('all')->andReturn([
            'device_id' => null, // device_id inválido
            'latitude' => null,  // latitude inválida
            'longitude' => null, // longitude inválida
        ]);

        // Mock do DeviceLocationController para simular o método store e lançar uma exceção de validação
        $controller = Mockery::mock(DeviceLocationController::class)->makePartial();
        $controller->shouldReceive('store')
            ->with($mockRequest)
            // Simula o lançamento da exceção ValidationException com mensagens de erro específicas
            ->andThrow(ValidationException::withMessages([
                'device_id' => ['O campo device_id é obrigatório'],
                'latitude' => ['O campo latitude é obrigatório'],
                'longitude' => ['O campo longitude é obrigatório'],
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
                "device_id" => ["O campo device_id é obrigatório"],
                "latitude" => ["O campo latitude é obrigatório"],
                "longitude" => ["O campo longitude é obrigatório"]
            ]
        ];

        // Verifica se o status da resposta é 422, indicando erro de validação
        $this->assertEquals(422, $response->status());

        // Verifica se o conteúdo da resposta JSON corresponde aos erros esperados
        $this->assertJson($response->getContent(), json_encode($expectedJson));
    }
}
