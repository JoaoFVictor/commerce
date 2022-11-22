<?php

namespace Tests\Feature\Produto;

use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Usuario;
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

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testFalhaProdutoDonoIncorreto()
    {
        Estoque::factory()->create(['produto_id' => $this->produto->getKey()]);

        $response = $this->actingAs($this->usuario2)->deleteJson(route(self::ROTA, $this->produto->getKey()));

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Você não tem permissão nesse produto!',
            ]);
    }

    public function testFalhaProdutoNaoEncontrado()
    {
        Estoque::factory()->create(['produto_id' => $this->produto->getKey()]);

        $idInvalido = '0';

        $response = $this->actingAs($this->usuario)->deleteJson(route(self::ROTA, $idInvalido));

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Produto não encontrado!',
            ]);
    }

    public function testSucesso()
    {
        Estoque::factory()->create(['produto_id' => $this->produto->getKey()]);

        $response = $this->actingAs($this->usuario)->deleteJson(route(self::ROTA, $this->produto->getKey()));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Produto excluído com sucesso.',
            ]);
    }
}
