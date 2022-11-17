<?php

namespace App\Repository\Usuario;

use App\Models\Usuario;

class UsuarioRepositoryEloquent implements UsuarioRepositoryInterface
{
    public function __construct(private Usuario $model)
    {
        $this->model = $model;
    }

    public function criar(array $dados): Usuario
    {
        return $this->model->create($dados);
    }

    public function atualizar(int $usuarioId, array $dados): Usuario
    {
        $usuario = $this->model->find($usuarioId);
        $usuario->update($dados);

        return $usuario;
    }

    public function apagar(int $usuarioId): void
    {
        $this->model->find($usuarioId)->delete();
    }

    public function buscar(int $usuarioId): ?Usuario
    {
        return $this->model->find($usuarioId);
    }
}
