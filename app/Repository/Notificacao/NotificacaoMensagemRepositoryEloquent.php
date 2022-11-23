<?php

namespace App\Repository\Notificacao;

use App\Models\Notificacao\NotificacaoMensagem;
use Illuminate\Contracts\Pagination\Paginator;

class NotificacaoMensagemRepositoryEloquent implements NotificacaoMensagemRepositoryInterface
{
    public function __construct(private NotificacaoMensagem $model)
    {
        $this->model = $model;
    }

    public function criar(array $dados): NotificacaoMensagem
    {
        return $this->model->create($dados);
    }

    public function atualizar(int $notificacaoMensagemId, array $dados): NotificacaoMensagem
    {
        $notificacaoMensagem = $this->model->find($notificacaoMensagemId);
        $notificacaoMensagem->update($dados);

        return $notificacaoMensagem;
    }

    public function apagar(int $notificacaoMensagemId): void
    {
        $this->model->find($notificacaoMensagemId)->delete();
    }

    public function buscar(int $notificacaoMensagemId): ?NotificacaoMensagem
    {
        return $this->model->find($notificacaoMensagemId);
    }

    public function paginar(int $quantidade = 15): Paginator
    {
        return $this->model->simplePaginate($quantidade);
    }
}
