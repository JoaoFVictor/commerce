<?php

namespace App\Repository\Estoque;

use App\Adapter\DTO\Estoque\EstoqueDTO;
use App\Models\Estoque;

interface EstoqueRepositoryInterface
{
    public function buscar(int $estoqueId): Estoque;

    public function atualizar(EstoqueDTO $estoqueDTO): void;

    public function criar(EstoqueDTO $estoqueDTO): Estoque;
}
