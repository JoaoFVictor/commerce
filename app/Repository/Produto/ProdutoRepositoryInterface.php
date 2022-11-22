<?php

namespace App\Repository\Produto;

use App\Adapter\DTO\Produto\ProdutoDTO;
use App\Models\Produto;
use Illuminate\Contracts\Pagination\Paginator;

interface ProdutoRepositoryInterface
{
    public function apagarJuntoEstoque(int $produtoId): void;
    public function buscar(int $produtoId): ?Produto;
    public function atualizar(ProdutoDTO $produtoDTO): Produto;
    public function listar(int $usuarioId, array $filtros, ?int $estoqueMinimo): Paginator;
    public function buscarValorTotal(int $usuarioId): float;
    public function criar(ProdutoDTO $produtoDTO): Produto;
}
