<?php

namespace App\Actions\Produto;

use App\Adapter\DTO\Estoque\EstoqueDTO;
use App\Adapter\DTO\Produto\ProdutoDTO;
use App\Repository\Estoque\EstoqueRepositoryInterface;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CriarProdutoAction
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository,
        private EstoqueRepositoryInterface $estoqueRepository
    ) {
    }

    public function execute(array $dados): array
    {
        $produtos = [];
        $erroTransacao = DB::transaction(function () use ($dados, &$produtos) {
            foreach ($dados['produtos'] as $produto) {
                $produto = (object) array_filter($produto);
                $produtoDTO = new ProdutoDTO(
                    codigoBarras: $produto->codigo_barras,
                    nome: $produto->nome,
                    marca: $produto->marca,
                    precoCusto: $produto->preco_custo ?? 0,
                    precoVenda: $produto->preco_venda ?? 0,
                    validade: $produto->validade ?? null,
                    usuarioId: Auth::id()
                );
                $novoProduto = $this->produtoRepository->criar($produtoDTO);
                $estoqueDTO = new EstoqueDTO(
                    produtoId: $novoProduto->getKey(),
                    quantidade: 0,
                );
                $this->estoqueRepository->criar($estoqueDTO);

                $produtos[] = $novoProduto;
            }
        });

        if ($erroTransacao) {
            throw new HttpException(409, $erroTransacao);
        }

        return $produtos;
    }
}
