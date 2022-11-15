<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ImagemInvalida extends Exception
{
    public static function nomeInvalido(string $nome): Exception
    {
        return new static("O nome {$nome} é inválido.");
    }

    public static function uploadErro(): Exception
    {
        return new static('Erro ao carregar imagem.', Response::HTTP_BAD_REQUEST);
    }
}
