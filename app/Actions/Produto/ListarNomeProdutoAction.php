<?php

namespace App\Actions\Produto;

use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ListarNomeProdutoAction
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository
    ) {
    }

    public function execute(string $nome, array $dados): Paginator
    {
        $usuarioId = Auth::id();
        $filtros = [
            'nome' => $nome,
        ];
        $quantidade = isset($dados['has_estoque']) ? 0 : null;

        return $this->produtoRepository->listar($usuarioId, $filtros, $quantidade);
    }
}
