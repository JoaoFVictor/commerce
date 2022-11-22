<?php

namespace App\Adapter\DTO\Produto;

use App\Adapter\DTO\DTOInterface;

final class ProdutoDTO extends DTOInterface
{
    public function __construct(
        public ?int $produtoId = null,
        public ?string $codigoBarras = null,
        public ?string $nome = null,
        public ?string $marca = null,
        public ?float $precoCusto = null,
        public ?float $precoVenda = null,
        public ?string $validade = null,
        public ?int $usuarioId = null,
    ) {
    }
}
