<?php

namespace App\Http\Resources\Notificacao\ClienteMensagem;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteMensagemResource extends JsonResource
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getKey(),
            'visualizada' => $this->visualizada,
            'cliente_id' => $this->cliente->getKey(),
            'cliente_nome' => $this->cliente->nome,
            'mensagem_id' => $this->mensagem->getKey(),
            'mensagem_titulo' => $this->mensagem->nome,
            'mensagem_conteudo' => $this->mensagem->conteudo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
