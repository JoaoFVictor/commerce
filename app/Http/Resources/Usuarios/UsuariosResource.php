<?php

namespace App\Http\Resources\Usuarios;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuariosResource extends JsonResource
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
            'email' => $this->email,
            'status' => $this->status,
            'telefone' => $this->telefone,
            'plano' => $this->plano,
            'imagem' => optional($this->imagem)->caminho,
        ];
    }
}
