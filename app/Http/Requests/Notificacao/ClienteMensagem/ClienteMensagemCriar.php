<?php

namespace App\Http\Requests\Notificacao\ClienteMensagem;

use Illuminate\Foundation\Http\FormRequest;

class ClienteMensagemCriar extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'visualizada' => ['required', 'boolean'],
            'cliente_id' => ['required', 'integer', 'exists:clientes,id'],
            'mensagem_id' => ['required', 'integer', 'exists:mensagens,id'],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function bodyParameters(): array
    {
        return [
            'visualizada' => [
                'description' => 'Visualizou a mensagem.',
                'example' => 1,
            ],
            'cliente_id' => [
                'description' => 'Id do Cliente.',
                'example' => 1,
            ],
            'topico_id' => [
                'description' => 'Id do Topico.',
                'example' => 1,
            ],
        ];
    }
}
