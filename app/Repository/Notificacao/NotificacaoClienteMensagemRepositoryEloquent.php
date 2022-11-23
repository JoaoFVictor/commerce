<?php

namespace App\Repository\Notificacao;

use App\Models\Notificacao\NotificacaoMensagemCliente;

class NotificacaoClienteMensagemRepositoryEloquent implements NotificacaoClienteMensagemRepositoryInterface
{
    public function __construct(private NotificacaoMensagemCliente $model)
    {
        $this->model = $model;
    }

    public function criar(array $dados): NotificacaoMensagemCliente
    {
        return $this->model->create($dados);
    }
}
