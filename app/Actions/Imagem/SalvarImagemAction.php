<?php

namespace App\Actions\Imagem;

use App\Exceptions\ImagemInvalida;
use App\Http\Requests\Usuarios\Atualizar as Request;
use App\Models\Imagem;
use App\Repository\Imagem\ImagemRepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SalvarImagemAction
{
    private const CAMINHO_IMAGEM = 'public/imagens';

    public function __construct(
        private ImagemRepositoryEloquent $imagemRepositoryEloquent
    ) {
    }

    public function execute(Request $request): Imagem
    {
        $imagem = DB::transaction(function () use ($request) {
            if ($request->file('imagem')->isValid()) {
                $imagemCaminho = $request->file('imagem')->store(self::CAMINHO_IMAGEM);

                return $this->imagemRepositoryEloquent->criar(
                    asset(Storage::url($imagemCaminho)),
                    $request->input('descricao', 'Sem descrição')
                );
            } else {
                throw ImagemInvalida::uploadErro();
            }
        });

        return $imagem;
    }
}
