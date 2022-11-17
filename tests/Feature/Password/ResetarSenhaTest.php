<?php

namespace Tests\Feature\Password;

use App\Actions\Usuario\GerarTokenSenhaUsuarioAction;
use App\Models\Usuario;
use Tests\TestCase;

class ResetarSenhaTest extends TestCase
{
    private const ROTA = 'password.update';

    public function testFalhaValoresGrandes()
    {
        $valoresGrandes = str_pad('', 300, 'A');
        $novosDados = [
            'email' => $valoresGrandes,
            'password' => $valoresGrandes,
            'password_confirmation' => $valoresGrandes,
            'token' => $valoresGrandes,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'password',
                    'password_confirmation',
                    'token',
                ],
            ]);
    }

    public function testFalhaValoresPequenos()
    {
        $ValoresPequenos = str_pad('', 5, 'A');
        $novosDados = [
            'password' => $ValoresPequenos,
            'password_confirmation' => $ValoresPequenos,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'password',
                    'password_confirmation',
                    'token',
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $novosDados = [
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
            'token' => null,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'password',
                    'password_confirmation',
                    'token',
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $novosDados = [
            'email' => 123,
            'password' => 123,
            'password_confirmation' => 123,
            'token' => 123,
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'password',
                    'password_confirmation',
                    'token',
                ],
            ]);
    }

    public function testFalhaSenhasDesiguais()
    {
        $novosDados = [
            'password' => '123abc@@',
            'password_confirmation' => 'abc123@@',
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'password',
                ],
            ]);
    }

    public function testSucesso()
    {
        $usuarioRegistrado = Usuario::factory()->create();
        $infoUsuario = app(GerarTokenSenhaUsuarioAction::class)->execute($usuarioRegistrado->email);

        $novosDados = [
            'email' => $infoUsuario[0]->email,
            'password' => '123abc@@',
            'password_confirmation' => '123abc@@',
            'token' => $infoUsuario[1],
        ];

        $response = $this->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(200);
    }
}
