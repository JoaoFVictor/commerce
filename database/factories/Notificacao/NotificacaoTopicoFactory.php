<?php

namespace Database\Factories\Notificacao;

use App\Models\Notificacao\NotificacaoTopico;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificacaoTopicoFactory extends Factory
{
    protected $model = NotificacaoTopico::class;

    public function definition()
    {
        return [
            'nome' => 'Topico 1',
        ];
    }
}
