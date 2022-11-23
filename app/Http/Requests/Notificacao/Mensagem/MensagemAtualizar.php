<?php

namespace App\Http\Requests\Notificacao\Mensagem;

use Illuminate\Foundation\Http\FormRequest;

class MensagemAtualizar extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'conteudo' => ['filled', 'string', 'max:100'],
            'titulo' => ['filled', 'string', 'max:100'],
            'usuario_id' => ['filled', 'integer', 'exists:usuarios,id'],
            'topico_id' => ['filled', 'integer', 'exists:topicos,id'],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function bodyParameters(): array
    {
        return [
            'conteudo' => [
                'description' => 'Conteúdo da Mensagem.',
                'example' => 'Olá senhor fulano.',
            ],
            'titulo' => [
                'description' => 'Título da Mensagem.',
                'example' => 'Bem-vindo!',
            ],
            'usuario_id' => [
                'description' => 'Id do Usuário.',
                'example' => 1,
            ],
            'topico_id' => [
                'description' => 'Id do Tópico.',
                'example' => 1,
            ],
        ];
    }
}
