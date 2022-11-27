<?php

namespace Tests\Feature\Notificacao\Mensagem;

use App\Models\Notificacao\NotificacaoTopico;
use App\Models\Usuario;
use Tests\TestCase;

class CriarTest extends TestCase
{
    private const ROTA = 'notificacao.mensagem.store';

    private const ID_INVALIDO = 0;

    public function testFalhaValoresGrandes()
    {
        $usuario = Usuario::factory()->create();
        $valoresGrandes = str_pad('', 101, 'A');
        $novosDados = [
            'titulo' => $valoresGrandes,
            'conteudo' => $valoresGrandes,
            'topico_id' => NotificacaoTopico::factory()->create(),
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'titulo',
                    'conteudo',
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $usuario = Usuario::factory()->create();
        $novosDados = [
            'titulo' => null,
            'conteudo' => null,
            'topico_id' => null,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'titulo',
                    'conteudo',
                    'topico_id',
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $usuario = Usuario::factory()->create();
        $dadosIncorreto = [
            'titulo' => 13,
            'conteudo' => 13,
            'topico_id' => 'valor',
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'titulo',
                    'conteudo',
                    'topico_id',
                ],
            ]);
    }

    public function testFalhaTopicoInvalido()
    {
        $usuario = Usuario::factory()->create();
        $dadosIncorreto = [
            'titulo' => 'titulo',
            'conteudo' => 'conteudo',
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

    public function testUsuarioInvalido()
    {
        $dadosIncorreto = [
            'titulo' => 'titulo',
            'conteudo' => 'conteudo',
            'topico_id' => self::ID_INVALIDO,
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
            'titulo' => 'titulo',
            'conteudo' => 'conteudo',
            'topico_id' => NotificacaoTopico::factory()->create()->getKey(),
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $dadosCorretos);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'titulo',
                    'conteudo',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
