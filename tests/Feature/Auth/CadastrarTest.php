<?php

namespace Tests\Feature\Auth;

use App\Models\Usuario;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CadastrarTest extends TestCase
{
    private const ROTA = 'auth.cadastro';

    public function testFalhaValoresGrandes()
    {
        $valoresGrandes = str_pad('', 101, 'A');
        $novosDados = [
            'nome' => $valoresGrandes,
            'email' => $valoresGrandes,
            'telefone' => $valoresGrandes,
            'senha' => $valoresGrandes,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                    'email',
                    'telefone',
                    'senha',
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $novosDados = [
            'nome' => null,
            'email' => null,
            'telefone' => null,
            'senha' => null,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                    'email',
                    'telefone',
                    'senha',
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $novosDados = [
            'nome' => 12,
            'email' => 12,
            'telefone' => 12,
            'senha' => 12,
            'lembrar' => 12,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                    'email',
                    'telefone',
                    'senha',
                    'lembrar',
                ],
            ]);
    }

    public function testFalhaEmailRegistrado()
    {
        $usuarioRegistrado = Usuario::factory()->create();
        $novosDados = [
            'email' => $usuarioRegistrado->email,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ],
            ]);
    }

    public function testFalhaTelefoneInvalido()
    {
        $novosDados = [
            'telefone' => '3832152201',
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ],
            ]);
    }

    public function testSucesso()
    {
        $email = Factory::create()->unique()->safeEmail();
        $novosDados = [
            'nome' => 'teste conta',
            'email' => $email,
            'telefone' => '(38)3215-2201',
            'senha' => '123abc@@',
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
