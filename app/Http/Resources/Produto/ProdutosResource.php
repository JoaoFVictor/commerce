<?php

namespace App\Http\Resources\Produto;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdutosResource extends JsonResource
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'codigo_barras' => $this->codigo_barras,
            'marca' => $this->marca,
            'preco_venda' => $this->preco_venda,
            'preco_custo' => $this->preco_custo,
            'validade' => $this->validade,
            'quantidade' => $this->estoque->quantidade,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
