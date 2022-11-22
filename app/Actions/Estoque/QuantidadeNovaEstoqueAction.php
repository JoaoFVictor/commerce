<?php

namespace App\Actions\Estoque;

class QuantidadeNovaEstoqueAction
{
    public function execute(int $quantidadeEstoque, int $quantidadeProduto, bool $removerEstoque): int
    {
        if ($removerEstoque) {
            return $quantidadeEstoque - $quantidadeProduto;
        }

        return $quantidadeEstoque + $quantidadeProduto;
    }
}
