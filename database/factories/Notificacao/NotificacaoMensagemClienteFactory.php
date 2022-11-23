<?php

namespace Database\Factories\Notificacao;

use App\Models\Cliente;
use App\Models\Notificacao\NotificacaoMensagem;
use App\Models\Notificacao\NotificacaoMensagemCliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificacaoMensagemClienteFactory extends Factory
{
    protected $model = NotificacaoMensagemCliente::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory()->create()->getKey(),
            'mensagem_id' => NotificacaoMensagem::factory()->create()->getKey(),
        ];
    }
}
