<?php

namespace App\Adapter\DTO\Estoque;

use App\Adapter\DTO\DTOInterface;

final class EstoqueDTO extends DTOInterface
{
    public function __construct(
        public ?int $estoqueId = null,
        public ?int $quantidade = null,
        public ?int $produtoId = null
    ) {
    }
}
