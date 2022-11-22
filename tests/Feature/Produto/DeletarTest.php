<?php

namespace Tests\Feature\Produto;

use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeletarTest extends TestCase
{
    private const ROTA = 'produtos.destroy';

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
        $this->usuario2 = Usuario::factory()->create();
        $this->produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
    }

    public function testFalhaUsuarioNaoLogado()
    {
        Estoque::factory()->create(['produto_id' => $this->produto->getKey()]);

        $response = $this->deleteJson(route(self::ROTA, $this->produto->getKey()));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testFalhaProdutoDonoIncorreto()
    {
        Estoque::factory()->create(['produto_id' => $this->produto->getKey()]);

        $response = $this->actingAs($this->usuario2)->deleteJson(route(self::ROTA, $this->produto->getKey()));

        $response->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJson([
                'message' => 'Você não tem permissão nesse produto!',
            ]);
    }

    public function testFalhaProdutoNaoEncontrado()
    {
        Estoque::factory()->create(['produto_id' => $this->produto->getKey()]);

        $idInvalido = '0';

        $response = $this->actingAs($this->usuario)->deleteJson(route(self::ROTA, $idInvalido));

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'message' => 'Produto não encontrado!',
            ]);
    }

    public function testSucesso()
    {
        Estoque::factory()->create(['produto_id' => $this->produto->getKey()]);

        $response = $this->actingAs($this->usuario)->deleteJson(route(self::ROTA, $this->produto->getKey()));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Produto excluído com sucesso.',
            ]);
    }
}
