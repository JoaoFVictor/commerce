<?php

namespace App\Actions\Produto;

use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ListarCodigoBarrasProdutoAction
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository
    ) {
    }

    public function execute(string $produtoCodigoBarras, array $dados): Paginator
    {
        $usuarioId = Auth::id();
        $filtros = [
            'codigo_barras' => $produtoCodigoBarras,
        ];
        $quantidade = array_key_exists('has_estoque', $dados) ? 0 : null;

        return $this->produtoRepository->listar($usuarioId, $filtros, $quantidade);
    }
}
