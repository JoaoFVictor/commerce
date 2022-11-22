<?php

namespace Tests\Feature\Produto;

use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Usuario;
use Tests\TestCase;

class ListarTest extends TestCase
{
    private const ROTA = 'produtos.index';

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
    }

    public function testFalhaUsuarioNaoLogado()
    {
        $response = $this->getJson(route(self::ROTA));

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testSucesso()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);

        $response = $this->actingAs($this->usuario)->getJson(route(self::ROTA));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'codigo_barras' => $produto->codigo_barras,
                        'nome' => $produto->nome,
                        'preco_venda' => $produto->preco_venda,
                        'preco_custo' => $produto->preco_custo,
                        'marca' => $produto->marca,
                        'validade' => $produto->validade,
                    ],
                ],
            ]);
    }
}
