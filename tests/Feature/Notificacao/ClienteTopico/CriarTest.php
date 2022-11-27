<?php

namespace Tests\Feature\Notificacao\ClienteTopico;

use App\Models\Cliente;
use App\Models\Notificacao\NotificacaoTopico;
use App\Models\Usuario;
use Tests\TestCase;

class CriarTest extends TestCase
{
    private const ROTA = 'notificacao.clientes.topicos.store';

    private const ID_INVALIDO = 0;

    public function testUsuarioInvalido()
    {
        $response = $this->postJson(route(self::ROTA));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testCampoClienteInvalido()
    {
        $usuario = Usuario::factory()->create();
        $dadosIncorreto = [
            'cliente_id' => self::ID_INVALIDO,
            'topico_id' => NotificacaoTopico::factory()->create(),
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'cliente_id',
                ],
            ]);
    }

    public function testCampoTopicoInvalido()
    {
        $usuario = Usuario::factory()->create();
        $dadosIncorreto = [
            'cliente_id' => Cliente::factory()->create(),
            'topico_id' => self::ID_INVALIDO,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'topico_id',
                ],
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $dadosCorreto = [
            'cliente_id' => Cliente::factory()->create()->getKey(),
            'topico_id' => NotificacaoTopico::factory()->create()->getKey(),
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosCorreto);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'cliente_id',
                    'cliente_nome',
                    'topico_id',
                    'topico_nome',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
