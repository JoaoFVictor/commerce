<?php

namespace App\Repository\Cliente;

use App\Models\Cliente;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class ClienteRepositoryEloquent implements ClienteRepositoryInterface
{
    public function __construct(private Cliente $model)
    {
        $this->model = $model;
    }

    public function criar(array $dados): Cliente
    {
        return $this->model->create($dados);
    }

    public function atualizar(int $clienteId, array $dados): Cliente
    {
        $cliente = $this->model->find($clienteId);
        $cliente->update($dados);

        return $cliente;
    }

    public function apagar(int $clienteId): void
    {
        $this->model->find($clienteId)->delete();
    }

    public function buscar(int $clienteId): ?Cliente
    {
        return $this->model->find($clienteId);
    }

    public function ListarPeloNome(string $clienteNome): Collection
    {
        return $this->model->where('nome', 'ILIKE', "%{$clienteNome}%")->get();
    }

    public function paginar(int $quantidade = 15): Paginator
    {
        return $this->model->simplePaginate($quantidade);
    }

    public function isClienteUsuario(int $clienteId, int $usuarioId): bool
    {
        return $this->model->where('usuario_id', $usuarioId)
            ->where('id', $clienteId)->exists();
    }

    public function isClienteCpfCadastradoComUsuario(string $cpf, int $usuarioId, ?int $clienteId = null): bool
    {
        $cliente = $this->model->where('cpf', $cpf)
            ->where('usuario_id', $usuarioId);

        if ($clienteId) {
            $cliente->where('id', '!=', $clienteId);
        }

        return $cliente->exists();
    }
}
