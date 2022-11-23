<?php

namespace App\Http\Requests\Notificacao\Topico;

use Illuminate\Foundation\Http\FormRequest;

class TopicoAtualizar extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['filled', 'string', 'max:100'],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function bodyParameters(): array
    {
        return [
            'nome' => [
                'description' => 'Nome do Tópico.',
                'example' => 'Novo tópico',
            ],
        ];
    }
}
