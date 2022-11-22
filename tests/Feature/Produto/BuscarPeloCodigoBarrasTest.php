<?php

namespace Tests\Feature\Produto;

use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BuscarPeloCodigoBarrasTest extends TestCase
{
    private const ROTA = 'produtos.buscar.codigo-barras';

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
    }

    public function testFalhaUsuarioNaoLogado()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);

        $response = $this->getJson(route(self::ROTA, $produto->codigo_barras));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testSucessoEstoque()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);

        $response = $this->actingAs($this->usuario)->getJson(route(self::ROTA, $produto->codigo_barras, ['has_estoque' => 1]));

        $response->assertStatus(Response::HTTP_OK)
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

    public function testSucesso()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);

        $response = $this->actingAs($this->usuario)->getJson(route(self::ROTA, $produto->codigo_barras));

        $response->assertStatus(Response::HTTP_OK)
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
