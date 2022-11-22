<?php

namespace App\Repository\Estoque;

use App\Adapter\DTO\Estoque\EstoqueDTO;
use App\Models\Estoque;

class EstoqueRepositoryEloquent implements EstoqueRepositoryInterface
{
    public function __construct(private Estoque $model)
    {
    }

    public function buscar(int $estoqueId): Estoque
    {
        return $this->model->findOrFail($estoqueId);
    }

    public function atualizar(EstoqueDTO $estoqueDTO): void
    {
        $estoque = $this->buscar($estoqueDTO->estoqueId);
        $novosDados = $this->tratarDTO($estoqueDTO);
        $estoque->update($novosDados);
    }

    public function criar(EstoqueDTO $estoqueDTO): Estoque
    {
        $novosDados = $this->tratarDTO($estoqueDTO);

        return $this->model->create($novosDados);
    }

    private function tratarDTO(EstoqueDTO $estoqueDTO): array
    {
        $novosDados = [
            'quantidade' => $estoqueDTO->quantidade,
            'produto_id' => $estoqueDTO->produtoId,
        ];

        return array_filter($novosDados, function ($valor) {
            return ! is_null($valor);
        });
    }
}
