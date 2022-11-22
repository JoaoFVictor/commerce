<?php

namespace Tests\Feature\Usuario;

use App\Models\Usuario;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AtualizarTest extends TestCase
{
    private const ROTA = 'usuarios.update';

    private Usuario $usuario;

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
    }

    public function testFalhaFalhaUsuarioNaoLogado()
    {
        $response = $this->postJson(route(self::ROTA));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testFalhaCamposObrigatorios()
    {
        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'nome',
                'email',
                'telefone',
                'plano',
            ]);
    }

    public function testFalhaCamposTipos()
    {
        $dados = [
            'nome' => true,
            'email' => true,
            'telefone' => true,
            'imagem' => true,
            'plano' => true,
        ];

        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), $dados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'nome',
                'email',
                'telefone',
                'imagem',
                'plano',
            ]);
    }

    public function testFalhaCamposTamanhoMaximo()
    {
        $dados = Usuario::factory()->make()->toArray();
        $valoresGrandes = str_pad('', 101, 'A');
        $dados['nome'] = $valoresGrandes;
        $dados['telefone'] = $valoresGrandes;
        $dados['plano'] = $valoresGrandes;

        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), $dados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'nome',
                'telefone',
                'plano',
            ]);
    }

    public function testFalhaCamposFormatos()
    {
        $dados = Usuario::factory()->make()->toArray();
        Storage::fake('local');
        $imagem = UploadedFile::fake()->create('arquivo.exe');
        $dados = [
            'email' => 'emailfake.com',
            'telefone' => '999999999',
            'imagem' => $imagem,
        ];

        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), $dados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'email',
                'telefone',
                'imagem',
            ]);
    }

    public function testSucesso()
    {
        Storage::fake('local');
        $imagem = UploadedFile::fake()->create('imagem.png');
        $dados = Usuario::factory()->make()->toArray();
        $dados['imagem'] = $imagem;

        $response = $this->actingAs($this->usuario)->postJson(route(self::ROTA), $dados);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nome',
                    'email',
                    'status',
                    'telefone',
                    'plano',
                    'imagem',
                ],
            ]);
    }
}
