<?php

namespace Tests\Feature\Email;

use App\Models\Usuario;
use Tests\TestCase;

class ReenviarTest extends TestCase
{
    private const ROTA = 'verification.send';

    public function testErroUsuarioNaoLogado()
    {
        $response = $this->postJson(route(self::ROTA));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();

        $response = $this->actingAs($usuario)
            ->postJson(route(self::ROTA));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
