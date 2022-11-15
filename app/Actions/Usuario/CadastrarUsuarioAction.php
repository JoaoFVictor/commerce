<?php

namespace App\Actions\Usuario;

use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CadastrarUsuarioAction
{
    public function execute(array $dados): JsonResponse
    {
        DB::transaction(function () use ($dados) {
            event(new Registered(Usuario::create($dados)));
        });

        return response()->json(['message' => 'Conta criada.'])->setStatusCode(201);
    }
}
