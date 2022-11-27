<?php

namespace Database\Factories\Notificacao;

use App\Models\Cliente;
use App\Models\Notificacao\NotificacaoClienteTopico;
use App\Models\Notificacao\NotificacaoTopico;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificacaoClienteTopicoFactory extends Factory
{
    protected $model = NotificacaoClienteTopico::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory()->create()->getKey(),
            'topico_id' => NotificacaoTopico::factory()->create()->getKey(),
        ];
    }
}
