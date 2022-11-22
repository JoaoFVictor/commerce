<?php

namespace App\Repository\Produto;

use App\Adapter\DTO\Produto\ProdutoDTO;
use App\Models\Produto;
use Illuminate\Contracts\Pagination\Paginator;

class ProdutoRepositoryEloquent implements ProdutoRepositoryInterface
{
    public function __construct(private Produto $model)
    {
    }

    public function buscar(int $produtoId): ?Produto
    {
        return $this->model->find($produtoId);
    }

    public function apagarJuntoEstoque(int $produtoId): void
    {
        $produto = $this->model->findOrFail($produtoId);
        $produto->estoque->delete();
    }

    public function atualizar(ProdutoDTO $produtoDTO): Produto
    {
        $produto = $this->buscar($produtoDTO->produtoId);
        $novosDados = $this->tratarDTO($produtoDTO);
        $produto->update($novosDados);

        return $produto;
    }

    public function listar(
        int $usuarioId,
        array $filtros,
        ?int $estoqueMinimo = null
    ): Paginator {
        $consulta = $this->model->whereHas('estoque', function ($query) use ($estoqueMinimo) {
            if ($estoqueMinimo) {
                $query->where('quantidade', '>=', $estoqueMinimo);
            }
        })
            ->where('usuario_id', $usuarioId);

        if (isset($filtros['codigo_barras'])) {
            $consulta->where('codigo_barras', $filtros['codigo_barras']);
        }
        if (isset($filtros['nome'])) {
            $consulta->where('nome', 'ILIKE', "%{$filtros['nome']}%");
        }

        return $consulta->simplePaginate(15);
    }

    public function buscarValorTotal(int $usuarioId): float
    {
        $produtos = $this->model->with('estoque')
            ->whereHas('estoque', function ($query) {
                $query->where('quantidade', '>', 0);
            })
            ->where('usuario_id', $usuarioId)
            ->get();

        return $produtos->sum(function ($produto) {
            return $produto->preco_venda * $produto->estoque->quantidade;
        });
    }

    public function criar(ProdutoDTO $produtoDTO): Produto
    {
        $novosDados = $this->tratarDTO($produtoDTO);

        return $this->model->create($novosDados);
    }

    private function tratarDTO(ProdutoDTO $produtoDTO): array
    {
        $novosDados = [
            'codigo_barras' => $produtoDTO->codigoBarras,
            'nome' => $produtoDTO->nome,
            'marca' => $produtoDTO->marca,
            'preco_custo' => $produtoDTO->precoCusto,
            'preco_venda' => $produtoDTO->precoVenda,
            'validade' => $produtoDTO->validade,
            'usuario_id' => $produtoDTO->usuarioId,
        ];

        return array_filter($novosDados, function ($valor) {
            return ! is_null($valor);
        });
    }
}
