<?php

namespace Tests\Feature\Usuario;

use App\Models\Usuario;
use Tests\TestCase;

class ApagarTest extends TestCase
{
    private const ROTA = 'usuarios.delete';

    private Usuario $usuario;

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
    }

    public function testFalhaUsuarioNaoLogado()
    {
        $response = $this->deleteJson(route(self::ROTA));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $response = $this->actingAs($this->usuario)->deleteJson(route(self::ROTA));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('usuarios', [
            'id' => $this->usuario->id,
            'deleted_at' => null,
        ]);
    }
}
