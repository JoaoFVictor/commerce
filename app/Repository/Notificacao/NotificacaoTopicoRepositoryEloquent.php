<?php

namespace App\Repository\Notificacao;

use App\Models\Notificacao\NotificacaoTopico;
use Illuminate\Contracts\Pagination\Paginator;

class NotificacaoTopicoRepositoryEloquent implements NotificacaoTopicoRepositoryInterface
{
    public function __construct(private NotificacaoTopico $model)
    {
        $this->model = $model;
    }

    public function criar(array $dados): NotificacaoTopico
    {
        return $this->model->create($dados);
    }

    public function atualizar(int $notificacaoTopicoId, array $dados): NotificacaoTopico
    {
        $notificacaoTopico = $this->model->find($notificacaoTopicoId);
        $notificacaoTopico->update($dados);

        return $notificacaoTopico;
    }

    public function apagar(int $notificacaoTopicoId): void
    {
        $this->model->find($notificacaoTopicoId)->delete();
    }

    public function buscar(int $notificacaoTopicoId): ?NotificacaoTopico
    {
        return $this->model->find($notificacaoTopicoId);
    }

    public function paginar(int $quantidade = 15): Paginator
    {
        return $this->model->simplePaginate($quantidade);
    }
}
