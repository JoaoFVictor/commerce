<?php

namespace App\Http\Requests\Notificacao\ClienteTopico;

use Illuminate\Foundation\Http\FormRequest;

class ClienteTopicoCriar extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'integer', 'exists:clientes,id'],
            'topico_id' => ['required', 'integer', 'exists:topicos,id'],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function bodyParameters(): array
    {
        return [
            'cliente_id' => [
                'description' => 'Id do Cliente.',
                'example' => 1,
            ],
            'topico_id' => [
                'description' => 'Id do Topico.',
                'example' => 2,
            ],
        ];
    }
}
