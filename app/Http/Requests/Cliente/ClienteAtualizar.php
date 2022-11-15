<?php

namespace App\Http\Requests\Cliente;

use App\Rules\ClienteDuplicadoParaUsuario;
use Illuminate\Foundation\Http\FormRequest;

class ClienteAtualizar extends FormRequest
{
    private const URL_SEGMENTO_CLIENTE_ID = 2;

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['filled', 'string', 'max:100'],
            'telefone' => ['filled', 'string', 'max:14', 'regex:/^\([1-9]{2}\)[0-9]{4,5}-[0-9]{4}$/'],
            'bairro' => ['filled', 'string', 'max:100'],
            'rua' => ['filled', 'string', 'max:100'],
            'numero' => ['filled', 'string', 'max:10'],
            'cpf' => ['filled', 'max:11', 'cpf', new ClienteDuplicadoParaUsuario($this->segment(self::URL_SEGMENTO_CLIENTE_ID))],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function bodyParameters(): array
    {
        return [
            'nome' => [
                'description' => 'Nome do Cliente.',
                'example' => 'Paulo Breno',
            ],
            'telefone' => [
                'description' => 'Telefone do Cliente.',
                'example' => '(38)3221-2011',
            ],
            'bairro' => [
                'description' => 'Bairro do Cliente.',
                'example' => 'Centro',
            ],
            'rua' => [
                'description' => 'Rua do Cliente.',
                'example' => 'Rua 4',
            ],
            'numero' => [
                'description' => 'Numero do Cliente.',
                'example' => '99',
            ],
            'cpf' => [
                'description' => 'Cpf do Cliente.',
                'example' => '25642235087',
            ],
        ];
    }
}
