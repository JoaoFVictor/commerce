<?php

namespace Database\Factories\Notificacao;

use App\Models\Notificacao\NotificacaoMensagem;
use App\Models\Notificacao\NotificacaoTopico;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificacaoMensagemFactory extends Factory
{
    protected $model = NotificacaoMensagem::class;

    public function definition()
    {
        return [
            'titulo' => 'Titulo 1',
            'conteudo' => 'Conteudo 1',
            'usuario_id' => Usuario::factory()->create()->getKey(),
            'topico_id' => NotificacaoTopico::factory()->create()->getKey(),
        ];
    }
}
