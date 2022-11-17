<?php

namespace App\Repository\Usuario;

use App\Models\Usuario;

interface UsuarioRepositoryInterface
{
    public function criar(array $dados): Usuario;

    public function atualizar(int $usuarioId, array $dados): Usuario;

    public function apagar(int $usuarioId): void;

    public function buscar(int $usuarioId): ?Usuario;
}
