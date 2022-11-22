<?php

namespace Tests\Feature\Produto;

use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ValorTotalTest extends TestCase
{
    private const ROTA = 'produtos.total.valor';

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
    }

    public function testFalhaUsuarioNaoLogado()
    {
        $response = $this->getJson(route(self::ROTA));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testSucesso()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);
        $valorTotal = $produto->preco_venda * $produto->estoque->quantidade;

        $response = $this->actingAs($this->usuario)->getJson(route(self::ROTA, $produto->getKey()));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'valor_total' => $valorTotal,
            ]);
    }
}
