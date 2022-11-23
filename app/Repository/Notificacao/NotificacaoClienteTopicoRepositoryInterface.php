<?php

namespace App\Repository\Notificacao;

use App\Models\Notificacao\NotificacaoClienteTopico;
use Illuminate\Contracts\Pagination\Paginator;

interface NotificacaoClienteTopicoRepositoryInterface
{
    public function criar(array $dados): NotificacaoClienteTopico;

    public function atualizar(int $clienteTopicoId, array $dados): NotificacaoClienteTopico;

    public function apagar(int $clienteTopicoId): void;

    public function buscar(int $clienteTopicoId): ?NotificacaoClienteTopico;

    public function paginar(int $quantidade = 15): Paginator;
}
