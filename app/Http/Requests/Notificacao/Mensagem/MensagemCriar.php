<?php

namespace App\Http\Requests\Notificacao\Mensagem;

use Illuminate\Foundation\Http\FormRequest;

class MensagemCriar extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'usuario_id' => auth('sanctum')->user()->getAuthIdentifier(),
        ]);
    }

    public function rules(): array
    {
        return [
            'conteudo' => ['required', 'string', 'max:100'],
            'titulo' => ['required', 'string', 'max:100'],
            'topico_id' => ['required', 'integer', 'exists:topicos,id'],
            'usuario_id' => ['nullable'],
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
            'topico_id' => [
                'description' => 'Id do Tópico.',
                'example' => 1,
            ],
        ];
    }
}
