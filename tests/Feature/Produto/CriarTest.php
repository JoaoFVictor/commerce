<?php

namespace Tests\Feature\Produto;

use App\Models\Produto;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CriarTest extends TestCase
{
    private const ROTA = 'produtos.store';

    private Usuario $usuario;

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
    }

    public function testFalhaUsuarioNaoLogado()
    {
        $response = $this->postJson(route(self::ROTA));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function testFalhaValoresGrandes()
    {
        $valoresGrandes = str_pad('', 300, 'A');

        $novosDadosIncorreto = [
            'produtos' => [
                [
                    'codigo_barras' => $valoresGrandes,
                    'nome' => $valoresGrandes,
                    'marca' => $valoresGrandes,
                    'validade' => $valoresGrandes,
                ],
            ],
        ];

        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), $novosDadosIncorreto);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'produtos.0.codigo_barras' => ['O campo produtos.0.codigo_barras não pode ser superior a 128 caracteres.'],
                    'produtos.0.nome' => ['O campo produtos.0.nome não pode ser superior a 60 caracteres.'],
                    'produtos.0.marca' => ['O campo produtos.0.marca não pode ser superior a 25 caracteres.'],
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $novosDadosIncorreto = [
            'produtos' => [
                [
                    'codigo_barras' => null,
                    'nome' => null,
                    'marca' => null,
                ],
            ],
        ];

        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), $novosDadosIncorreto);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'produtos.0.codigo_barras' => ['O campo produtos.0.codigo_barras é obrigatório.'],
                    'produtos.0.nome' => ['O campo produtos.0.nome é obrigatório.'],
                    'produtos.0.marca' => ['O campo produtos.0.marca é obrigatório.'],
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $novosDadosIncorreto = [
            'produtos' => [
                [
                    'codigo_barras' => 24.69,
                    'nome' => 24.69,
                    'marca' => 24.69,
                    'validade' => 24.69,
                ],
            ],
        ];

        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), $novosDadosIncorreto);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'produtos.0.codigo_barras' => ['O campo produtos.0.codigo_barras deve ser uma string.'],
                    'produtos.0.nome' => ['O campo produtos.0.nome deve ser uma string.'],
                    'produtos.0.marca' => ['O campo produtos.0.marca deve ser uma string.'],
                    'produtos.0.validade' => ['O campo produtos.0.validade não corresponde ao formato d-m-Y.'],
                ],
            ]);
    }

    public function testFalhaCodigoBarraEmUso()
    {
        $produto = Produto::factory()->create(['usuario_id' => $this->usuario])->toArray();

        $novosDadosIncorreto = [
            'produtos' => [$produto],
        ];
        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), $novosDadosIncorreto);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'produtos' => ["Um produto possui um código de barras em uso. Produto: {$produto['nome']}"],
                ],
            ]);
    }

    public function testSucesso()
    {
        $produtos = Produto::factory()->count(3)->make()->toArray();
        $novosDados = [
            'produtos' => $produtos,
        ];

        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'data' => [
                    [
                        'nome' => $produtos[0]['nome'],
                        'codigo_barras' => $produtos[0]['codigo_barras'],
                        'marca' => $produtos[0]['marca'],
                        'preco_venda' => 0,
                        'preco_custo' => 0,
                        'validade' => $produtos[0]['validade'],
                    ],
                ],
            ]);
    }
}
