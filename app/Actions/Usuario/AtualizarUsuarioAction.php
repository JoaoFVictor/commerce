<?php

namespace App\Actions\Usuario;

use App\Actions\Imagem\SalvarImagemAction;
use App\Models\Usuario;
use App\Repository\Usuario\UsuarioRepositoryInterface;

class AtualizarUsuarioAction
{
    public function __construct(private SalvarImagemAction $salvarImagemAction, private UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->salvarImagemAction = $salvarImagemAction;
        $this->usuarioRepository = $usuarioRepository;
    }

    public function execute(int $usuarioId, array $dados): Usuario
    {
        $novaImagem = null;

        if ($dados['imagem']?->isValid()) {
            $novaImagem = $this->salvarImagemAction->execute($dados);
            $dados['imagem_id'] = $novaImagem->id;
        }

        return $this->usuarioRepository->atualizar($usuarioId, $dados);
    }
}
