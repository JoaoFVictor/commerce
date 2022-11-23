<?php

namespace App\Http\Resources\Notificacao\ClienteTopico;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteTopicoResource extends JsonResource
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getKey(),
            'cliente_id' => $this->cliente->getKey(),
            'cliente_nome' => $this->cliente->nome,
            'topico_id' => $this->topico->getKey(),
            'topico_nome' => $this->topico->nome,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
