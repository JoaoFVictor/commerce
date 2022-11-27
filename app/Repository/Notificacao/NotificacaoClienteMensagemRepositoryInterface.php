<?php

namespace App\Repository\Notificacao;

use App\Models\Notificacao\NotificacaoMensagemCliente;

interface NotificacaoClienteMensagemRepositoryInterface
{
    public function criar(array $dados): NotificacaoMensagemCliente;
}
