<?php

namespace App\Repository\Notificacao;

use App\Models\Notificacao\NotificacaoMensagem;
use Illuminate\Contracts\Pagination\Paginator;

interface NotificacaoMensagemRepositoryInterface
{
    public function criar(array $dados): NotificacaoMensagem;

    public function atualizar(int $notificacaoMensagemId, array $dados): NotificacaoMensagem;

    public function apagar(int $notificacaoMensagemId): void;

    public function buscar(int $notificacaoMensagemId): ?NotificacaoMensagem;

    public function paginar(int $quantidade = 15): Paginator;
}
