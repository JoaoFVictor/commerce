<?php

namespace App\Actions\Usuario;

use Illuminate\Http\JsonResponse;

class ReenviarEmailVerificacaoUsuarioAction
{
    public function execute(): JsonResponse
    {
        if (auth('sanctum')->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email já está verificado.']);
        }
        auth('sanctum')->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Email reenviado.']);
    }
}
