<?php

namespace App\Http\Requests\Cliente;

use App\Repository\Cliente\ClienteRepositoryInterface;
use App\Rules\ClienteDuplicadoParaUsuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClienteCriar extends FormRequest
{
    public function __construct(private ClienteRepositoryInterface $clienteRepository)
    {
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'usuario_id' => Auth::user()->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'telefone' => ['nullable', 'string', 'max:14', 'regex:/^\([1-9]{2}\)[0-9]{4,5}-[0-9]{4}$/'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'rua' => ['nullable', 'string', 'max:100'],
            'numero' => ['nullable', 'string', 'max:10'],
            'cpf' => ['nullable', 'string', 'max:11', 'cpf', new ClienteDuplicadoParaUsuario(null, $this->clienteRepository)],
            'usuario_id' => ['nullable'],
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
