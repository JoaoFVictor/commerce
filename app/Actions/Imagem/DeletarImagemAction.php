<?php

namespace App\Actions\Imagem;

use App\Models\Imagem;
use App\Repository\Imagem\ImagemRepositoryEloquent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeletarImagemAction
{
    private const CAMINHO_IMAGEM = 'public/imagens';

    public function __construct(
        private ImagemRepositoryEloquent $imagemRepositoryEloquent
    ) {
    }

    public function execute(Imagem $imagem): void
    {
        $imagemCaminho = Str::afterLast($imagem->caminho, '/');
        Storage::delete(self::CAMINHO_IMAGEM."/{$imagemCaminho}");
        $this->imagemRepositoryEloquent->apagar($imagem->getKey());
    }
}
