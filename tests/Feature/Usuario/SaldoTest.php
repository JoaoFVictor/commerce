<?php

namespace Tests\Feature\Usuario;

use App\Models\Transacao;
use App\Models\Usuario;
use Tests\TestCase;

class SaldoTest extends TestCase
{
    private const ROTA = 'buscar.saldo';

    private Usuario $usuario;

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
    }

    public function testeUsuarioNaoLogado()
    {
        $response = $this->getJson(route(self::ROTA));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        Transacao::factory()->count(2)->create(['usuario_id' => $this->usuario->getKey()]);
        $response = $this->actingAs($this->usuario)->getJson(route(self::ROTA));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'valor_total',
            ]);
    }
}
