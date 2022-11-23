<?php

namespace Tests\Feature\Notificacao\Topico;

use App\Models\Usuario;
use Tests\TestCase;

class CriarTest extends TestCase
{
    private const ROTA = 'notificacao.topico.store';

    public function testFalhaValoresGrandes()
    {
        $usuario = Usuario::factory()->create();
        $valoresGrandes = str_pad('', 101, 'A');
        $novosDados = [
            'nome' => $valoresGrandes,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $usuario = Usuario::factory()->create();
        $novosDados = [
            'nome' => null,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $usuario = Usuario::factory()->create();
        $dadosIncorreto = [
            'nome' => 13,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                ],
            ]);
    }

    public function testFalhaUsuarioInvalido()
    {
        $dadosIncorreto = [
            'nome' => 'titulo',
        ];

        $response = $this->postJson(route(self::ROTA), $dadosIncorreto);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $dadosCorretos = [
            'nome' => 'titulo',
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosCorretos);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nome',
                ],
            ]);
    }
}
