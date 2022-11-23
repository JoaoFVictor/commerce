<?php

namespace App\Repository\Notificacao;

use App\Models\Notificacao\NotificacaoClienteTopico;
use Illuminate\Contracts\Pagination\Paginator;

class NotificacaoClienteTopicoRepositoryEloquent implements NotificacaoClienteTopicoRepositoryInterface
{
    public function __construct(private NotificacaoClienteTopico $model)
    {
        $this->model = $model;
    }

    public function criar(array $dados): NotificacaoClienteTopico
    {
        return $this->model->create($dados);
    }

    public function atualizar(int $clienteTopicoId, array $dados): NotificacaoClienteTopico
    {
        $clienteTopico = $this->model->find($clienteTopicoId);
        $clienteTopico->update($dados);

        return $clienteTopico;
    }

    public function apagar(int $clienteTopicoId): void
    {
        $this->model->find($clienteTopicoId)->delete();
    }

    public function buscar(int $clienteTopicoId): ?NotificacaoClienteTopico
    {
        return $this->model->find($clienteTopicoId);
    }

    public function paginar(int $quantidade = 15): Paginator
    {
        return $this->model->simplePaginate($quantidade);
    }
}
