<?php

namespace App\Actions\Produto;

use App\Adapter\DTO\Estoque\EstoqueDTO;
use App\Adapter\DTO\Produto\ProdutoDTO;
use App\Models\Produto;
use App\Repository\Estoque\EstoqueRepositoryInterface;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AtualizarProdutoAction
{
    public function __construct(
        private ProdutoRepositoryInterface $produtoRepository,
        private EstoqueRepositoryInterface $estoqueRepository,
    ) {
    }

    public function execute(int $produtoId, array $dados, int $produtoEstoqueId = null): Produto
    {
        $usuarioId = Auth::id();
        $produto = $this->produtoRepository->buscar($produtoId);
        if (is_null($produto)) {
            throw new NotFoundHttpException(__('Produto não encontrado!'));
        }
        if ($produto->usuario_id != $usuarioId) {
            throw new AccessDeniedHttpException(__('Você não tem permissão nesse produto!'));
        }

        return DB::transaction(function () use ($produtoId, $dados, $produtoEstoqueId) {
            $dados = (object) array_filter($dados);
            $produtoDTO = new ProdutoDTO(
                produtoId: $produtoId,
                codigoBarras: $dados->codigo_barras ?? null,
                nome: $dados->nome ?? null,
                marca: $dados->marca ?? null,
                precoCusto: $dados->preco_custo ?? null,
                precoVenda: $dados->preco_venda ?? null,
                validade: $dados->validade ?? null
            );
            $produto = $this->produtoRepository->atualizar($produtoDTO);
            if (property_exists($dados, 'quantidade') && $produtoEstoqueId) {
                $estoqueDTO = new EstoqueDTO(
                    estoqueId: $produtoEstoqueId,
                    produtoId: $produtoId,
                    quantidade: $dados->quantidade,
                );
                $this->estoqueRepository->atualizar($estoqueDTO);
            }

            return $produto;
        });
    }
}
