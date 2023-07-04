<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Repositories\DespesasRepository;
use App\Http\Requests\DespesasFormRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

class DespesasRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $despesaAgua = resolve(DespesasRepository::class);
        $requestAgua = new DespesasFormRequest(
            ["descricao" => "Agua",
            "valor" => 320,
            "data" => "10/06/1998",
            "categorias" => "Saúde"
            ]);
        $despesaAgua->add($requestAgua);

        $despesaComida = resolve(DespesasRepository::class);
        $requestComida = new DespesasFormRequest(
            ["descricao" => "Comida",
            "valor" => 2000,
            "data" => "10/06/1998"
            ]);
        $despesaComida->add($requestComida);
    }

    public function test_verificandoSeADespesaEstaCorretaJuntoDasCategorias(): void
    {
        // Assert
        $this->assertDatabaseHas('despesas', [
            'descricao' => "Agua",
            'valor' => 320,
            'data' => "10/06/1998",
        ]);

        $this->assertDatabaseHas('categorias', [
            'despesas_id' => 1,
            'categorias' => 'Saúde'
        ]);

        //------------------------------------------------------ SEGUNDA DESPESA

        $this->assertDatabaseHas('despesas', [
            'descricao' => 'Comida',
            'valor' => 2000,
            'data' => "10/06/1998",
        ]);

        $this->assertDatabaseHas('categorias', [
            'despesas_id' => 2,
            'categorias' => 'Outras'
        ]);
    }

    public function testGetDespesas()
    {
        // Executa a requisição GET /despesas
        $response = $this->get('/api/despesas');

        // Verifica se a resposta contém a descrição "Agua"
        $response->assertJsonFragment(['descricao' => 'Agua']);

        // Verifica se a resposta contém a descrição "Comida"
        $response->assertJsonFragment(['descricao' => 'Comida']);

        // Verifica se a resposta contém o valor 320
        $response->assertJsonFragment(['valor' => 320]);

        // Verifica se a resposta contém o valor 2000
        $response->assertJsonFragment(['valor' => 2000]);
    }
}
