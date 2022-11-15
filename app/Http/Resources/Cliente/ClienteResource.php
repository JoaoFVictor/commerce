<?php

namespace App\Http\Resources\Cliente;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getKey(),
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'bairro' => $this->bairro,
            'rua' => $this->rua,
            'numero' => $this->numero,
            'cpf' => $this->cpf,
        ];
    }
}
