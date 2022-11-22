<?php

namespace App\Actions\Produto;

use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ListarProdutoAction
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository
    ) {
    }

    public function execute(array $dados): Paginator
    {
        $quantidadeMinima = isset($dados['quantidade_minima']) ? intval($dados['quantidade_minima']) : 0;
        $usuarioId = Auth::id();

        return $this->produtoRepository->listar($usuarioId, [], $quantidadeMinima);
    }
}
