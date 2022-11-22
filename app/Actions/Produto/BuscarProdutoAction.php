<?php

namespace App\Actions\Produto;

use App\Models\Produto;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BuscarProdutoAction
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository
    ) {
    }

    public function execute(int $produtoId): Produto
    {
        $usuarioId = Auth::id();
        $produto = $this->produtoRepository->buscar($produtoId);
        if (is_null($produto)) {
            throw new NotFoundHttpException(__('Produto não encontrado!'));
        }
        if ($produto->usuario_id != $usuarioId) {
            throw new AccessDeniedHttpException(__('Você não tem permissão nesse produto!'));
        }

        return $produto;
    }
}
