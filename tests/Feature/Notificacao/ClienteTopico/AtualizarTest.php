<?php

namespace Tests\Feature\Notificacao\ClienteTopico;

use App\Models\Cliente;
use App\Models\Notificacao\NotificacaoClienteTopico;
use App\Models\Notificacao\NotificacaoMensagem;
use App\Models\Notificacao\NotificacaoTopico;
use App\Models\Usuario;
use Tests\TestCase;

class AtualizarTest extends TestCase
{
    private const ROTA = 'notificacao.clientes.topicos.update';

    private const ID_INVALIDO = 0;

    public function testUsuarioInvalido()
    {
        $mensagem = NotificacaoMensagem::factory()->create();
        $response = $this->putJson(route(self::ROTA, $mensagem->getKey()));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testCampoClienteInvalido()
    {
        $usuario = Usuario::factory()->create();
        $clienteTopico = NotificacaoClienteTopico::factory()->create();
        $dadosIncorreto = [
            'cliente_id' => self::ID_INVALIDO,
            'topico_id' => NotificacaoTopico::factory()->create(),
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $clienteTopico->getKey()), $dadosIncorreto);

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
        $clienteTopico = NotificacaoClienteTopico::factory()->create();
        $dadosIncorreto = [
            'cliente_id' => Cliente::factory()->create(),
            'topico_id' => self::ID_INVALIDO,
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $clienteTopico->getKey()), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'topico_id',
                ],
            ]);
    }

    public function testFalhaClienteTopicoNaoEncontrado()
    {
        $usuario = Usuario::factory()->create();
        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, self::ID_INVALIDO));

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $clienteTopico = NotificacaoClienteTopico::factory()->create();
        $dadosCorretos = [
            'cliente_id' => Cliente::factory()->create()->getKey(),
            'topico_id' => NotificacaoTopico::factory()->create()->getKey(),
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $clienteTopico->getKey()), $dadosCorretos);

        $response->assertStatus(200)
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
