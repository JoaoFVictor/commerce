<?php

namespace Tests\Feature\Password;

use App\Models\Usuario;
use Tests\TestCase;

class ResetarSenhaLinkTest extends TestCase
{
    private const ROTA = 'password.email';

    public function testFalhaValoresGrandes()
    {
        $valoresGrandes = str_pad('', 101, 'A');
        $novosDados = [
            'senha' => $valoresGrandes,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $novosDados = [
            'email' => null,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $novosDados = [
            'email' => 12,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ],
            ]);
    }

    public function testSucesso()
    {
        $usuarioRegistrado = Usuario::factory()->create();

        $novosDados = [
            'email' => $usuarioRegistrado->email,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
