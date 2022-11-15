<?php

namespace App\Actions\Usuario;

use App\Models\Social;
use Illuminate\Http\JsonResponse;

class CriarRedeSocialUsuarioAction
{
    public function execute(array $dados): JsonResponse
    {
        $usuarioId = auth()->user()->id;
        Social::updateOrCreate(
            ['usuario_id' => $usuarioId],
            $dados
        );

        return response()->json(['message' => 'Dados Atualizados.']);
    }
}
