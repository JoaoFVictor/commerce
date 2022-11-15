<?php

namespace App\Actions\Usuario;

use App\Actions\Imagem\SalvarImagemAction;
use App\Http\Requests\Usuarios\Atualizar as Request;
use App\Http\Resources\Usuarios\UsuariosResource;
use Auth;
use Illuminate\Http\JsonResponse;
use Throwable;

class AtualizarUsuarioAction
{
    public function execute(Request $request): JsonResponse|UsuariosResource
    {
        $usuario = Auth::user();
        $novaImagem = null;
        $dados = $request->validated();

        if ($request->file('imagem')?->isValid()) {
            try {
                $novaImagem = app(SalvarImagemAction::class)->execute($request);
                $dados['imagem_id'] = $novaImagem->getKey();
            } catch (Throwable $exception) {
                return response()->json(['message' => $exception->getMessage()], $exception->getCode());
            }
        }

        $usuario->update($dados);

        return new UsuariosResource($usuario);
    }
}
