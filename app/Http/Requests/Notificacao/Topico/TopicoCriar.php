<?php

namespace App\Http\Requests\Notificacao\Topico;

use Illuminate\Foundation\Http\FormRequest;

class TopicoCriar extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
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
                'example' => 'Novo Tópico',
            ],
        ];
    }
}
