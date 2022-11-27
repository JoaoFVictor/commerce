<?php

namespace App\Http\Resources\Notificacao\Mensagem;

use Illuminate\Http\Resources\Json\JsonResource;

class MensagemResource extends JsonResource
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getKey(),
            'titulo' => $this->titulo,
            'conteudo' => $this->conteudo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
