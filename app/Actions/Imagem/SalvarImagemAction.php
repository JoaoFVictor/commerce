<?php

namespace App\Actions\Imagem;

use App\Exceptions\ImagemInvalida;
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

    public function execute(array $dados): Imagem
    {
        $imagem = DB::transaction(function () use ($dados) {
            if ($dados['imagem']?->isValid()) {
                $imagemCaminho = $dados['imagem']->store(self::CAMINHO_IMAGEM);

                return $this->imagemRepositoryEloquent->criar(
                    asset(Storage::url($imagemCaminho)),
                    $dados['descricao'] ?? 'Sem descrição'
                );
            } else {
                throw ImagemInvalida::uploadErro();
            }
        });

        return $imagem;
    }
}
