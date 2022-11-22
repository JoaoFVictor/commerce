<?php

namespace Tests\Feature\Produto;

use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AtualizarTest extends TestCase
{
    private const ROTA = 'produtos.update';

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
        $this->usuario2 = Usuario::factory()->create();
    }

    public function testFalhaUsuarioNaoLogado()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);

        $response = $this->putJson(route(self::ROTA, $produto->getKey()));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testFalhaValoresGrandes()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);

        $valoresGrandes = str_pad('', 300, 'A');

        $dadosIncorretos = [
            'codigo_barras' => $valoresGrandes,
            'nome' => $valoresGrandes,
            'preco_venda' => 24.69,
            'marca' => $valoresGrandes,
            'validade' => '01/01/2050',
        ];

        $response = $this->actingAs($this->usuario)->putJson(route(self::ROTA, $produto->getKey()), $dadosIncorretos);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'codigo_barras' => ['O campo codigo barras não pode ser superior a 128 caracteres.'],
                    'nome' => ['O campo nome não pode ser superior a 60 caracteres.'],
                    'marca' => ['O campo marca não pode ser superior a 25 caracteres.'],
                ],
            ]);
    }

    public function testFalhaProdutoDonoIncorreto()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);

        $response = $this->actingAs($this->usuario2)->putJson(route(self::ROTA, $produto->getKey()));

        $response->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJson([
                'message' => 'Você não tem permissão nesse produto!',
            ]);
    }

    public function testFalhaProdutoUsuarioIdInvalido()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);

        $idInvalido = '0';

        $response = $this->actingAs($this->usuario)->putJson(route(self::ROTA, $idInvalido));

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'message' => 'Produto não encontrado!',
            ]);
    }

    public function testFalhaTiposValores()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);

        $dadosIncorretos = [
            'codigo_barras' => 13,
            'nome' => 13,
            'preco_venda' => 'teste',
            'marca' => 12,
            'validade' => 'amanha',
        ];

        $response = $this->actingAs($this->usuario)->putJson(route(self::ROTA, $produto->getKey()), $dadosIncorretos);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'codigo_barras' => ['O campo codigo barras deve ser uma string.'],
                    'nome' => ['O campo nome deve ser uma string.'],
                    'marca' => ['O campo marca deve ser uma string.'],
                    'preco_venda' => ['O campo preco venda deve ser um número.'],
                    'validade' => ['O campo validade não corresponde ao formato d-m-Y.'],
                ],
            ]);
    }

    public function testFalhaCodigoBarraEmUso()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario]);
        $produto2 = Produto::factory()->create(['usuario_id' => $this->usuario])->toArray();

        $novosDadosIncorreto = $produto2;

        $response = $this->actingAs($this->usuario)->putJson(route(self::ROTA, $produto->getKey()), $novosDadosIncorreto);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'codigo_barras' => ["Um produto possui um código de barras em uso. Produto: {$produto2['nome']}"],
                ],
            ]);
    }

    public function testSucesso()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario->getKey()]);
        Estoque::factory()->create(['produto_id' => $produto->getKey()]);
        $response = $this->actingAs($this->usuario)->putJson(route(self::ROTA, $produto->getKey()));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'codigo_barras' => $produto->codigo_barras,
                    'nome' => $produto->nome,
                    'preco_venda' => $produto->preco_venda,
                    'marca' => $produto->marca,
                    'validade' => $produto->validade,
                ],
            ]);
    }
}
