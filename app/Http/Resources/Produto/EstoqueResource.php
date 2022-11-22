<?php

namespace App\Http\Resources\Produto;

use Illuminate\Http\Resources\Json\JsonResource;

class EstoqueResource extends JsonResource
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function toArray($request): array
    {
        return [
            'preco_custo' => $this->preco_custo,
            'quantidade' => $this->quantidade,
        ];
    }
}
