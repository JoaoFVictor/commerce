<?php

namespace Tests\Feature\Auth;

use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private const ROTA = 'auth.login';

    public function testFalhaValoresGrandes()
    {
        $valoresGrandes = str_pad('', 101, 'A');
        $novosDados = [
            'email' => $valoresGrandes,
            'senha' => $valoresGrandes,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'senha',
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $novosDados = [
            'email' => null,
            'senha' => null,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'senha',
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $novosDados = [
            'email' => 12,
            'senha' => 12,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'senha',
                ],
            ]);
    }

    public function testSucesso()
    {
        $usuarioRegistrado = Usuario::factory()->create();

        $novosDados = [
            'email' => $usuarioRegistrado->email,
            'senha' => '123abc@@',
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'token',
            ]);
    }
}
