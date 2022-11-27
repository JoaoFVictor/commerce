<?php

namespace App\Repository\Notificacao;

use App\Models\Notificacao\NotificacaoTopico;
use Illuminate\Contracts\Pagination\Paginator;

interface NotificacaoTopicoRepositoryInterface
{
    public function criar(array $dados): NotificacaoTopico;

    public function atualizar(int $notificacaoTopicoId, array $dados): NotificacaoTopico;

    public function apagar(int $notificacaoTopicoId): void;

    public function buscar(int $notificacaoTopicoId): ?NotificacaoTopico;

    public function paginar(int $quantidade = 15): Paginator;
}
