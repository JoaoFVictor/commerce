<?php

namespace Tests\Feature\Notificacao\ClienteMensagem;

use App\Models\Cliente;
use App\Models\Notificacao\NotificacaoMensagem;
use App\Models\Usuario;
use Tests\TestCase;

class CriarTest extends TestCase
{
    private const ROTA = 'notificacao.clientes.mensagem.store';

    private const ID_INVALIDO = 0;

    public function testFalhaValoresGrandes()
    {
        $usuario = Usuario::factory()->create();
        $valoresGrandes = str_pad('', 101, 'A');
        $novosDados = [
            'visualizada' => $valoresGrandes,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'visualizada',
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $usuario = Usuario::factory()->create();
        $novosDados = [
            'visualizada' => null,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'visualizada',
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $usuario = Usuario::factory()->create();
        $dadosIncorreto = [
            'visualizada' => 13,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'visualizada',
                ],
            ]);
    }

    public function testUsuarioInvalido()
    {
        $dadosIncorreto = [
            'visualizada' => true,
        ];

        $response = $this->postJson(route(self::ROTA), $dadosIncorreto);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testCampoClienteInvalido()
    {
        $usuario = Usuario::factory()->create();
        $dadosCorretos = [
            'visualizada' => true,
            'cliente_id' => self::ID_INVALIDO,
            'mensagem_id' => NotificacaoMensagem::factory()->create()->getKey(),
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosCorretos);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'cliente_id',
                ],
            ]);
    }

    public function testCampoMensagemInvalido()
    {
        $usuario = Usuario::factory()->create();
        $dadosCorretos = [
            'visualizada' => true,
            'cliente_id' => Cliente::factory()->create()->getKey(),
            'mensagem_id' => self::ID_INVALIDO,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosCorretos);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'mensagem_id',
                ],
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $dadosCorretos = [
            'visualizada' => true,
            'cliente_id' => Cliente::factory()->create()->getKey(),
            'mensagem_id' => NotificacaoMensagem::factory()->create()->getKey(),
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosCorretos);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'visualizada',
                    'cliente_id',
                    'cliente_nome',
                    'mensagem_id',
                    'mensagem_titulo',
                    'mensagem_conteudo',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
