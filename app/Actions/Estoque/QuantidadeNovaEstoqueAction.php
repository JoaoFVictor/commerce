<?php

namespace App\Actions\Estoque;

class QuantidadeNovaEstoqueAction
{
    public function execute(int $quantidadeEstoque, int $quantidadeProduto, bool $removerEstoque): int
    {
        return $removerEstoque ? $quantidadeEstoque - $quantidadeProduto : $quantidadeEstoque + $quantidadeProduto;
    }
}
