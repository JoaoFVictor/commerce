<?php

namespace App\Repository\Cliente;

use App\Models\Cliente;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface ClienteRepositoryInterface
{
    public function criar(array $dados): Cliente;

    public function atualizar(int $clienteId, array $dados): Cliente;

    public function apagar(int $clienteId): void;

    public function buscar(int $clienteId): ?Cliente;

    public function ListarPeloNome(string $clienteNome): Collection;

    public function paginar(int $quantidade = 15): Paginator;

    public function isClienteUsuario(int $clienteId, int $usuarioId): bool;

    public function isClienteCpfCadastradoComUsuario(string $cpf, int $usuarioId, ?int $clienteId = null): bool;
}
