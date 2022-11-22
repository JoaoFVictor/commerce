<?php

namespace App\Actions\Estoque;

use App\Repository\Produto\ProdutoRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidarEstoqueAction
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository
    ) {
    }

    public function execute(int $quantidadeEstoque, array $produtoDaTransacao, bool $removerEstoque): void
    {
        if ($removerEstoque && $quantidadeEstoque < $produtoDaTransacao['quantidade']) {
            $produtoInvalido = $this->produtoRepository->buscar($produtoDaTransacao['id']);
            throw new HttpException(409, "Quantidade de produto inválido, a quantidade. Produto : {$produtoInvalido->nome}");
        }
    }
}
