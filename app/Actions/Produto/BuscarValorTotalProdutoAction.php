<?php

namespace App\Actions\Produto;

use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class BuscarValorTotalProdutoAction
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository
    ) {
    }

    public function execute(): float
    {
        $usuarioId = Auth::id();
        $valorTotal = $this->produtoRepository->buscarValorTotal($usuarioId);

        return round($valorTotal, 2);
    }
}
