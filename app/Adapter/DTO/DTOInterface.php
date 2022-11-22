<?php

namespace App\Adapter\DTO;

use InvalidArgumentException;
use JsonSerializable;

abstract class DTOInterface implements JsonSerializable
{
    public function values(): array
    {
        return get_object_vars($this);
    }

    public function get(string $propriedade): mixed
    {
        $getter = 'get' . ucfirst($propriedade);
        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }
        if (!property_exists($this, $propriedade)) {
            throw new InvalidArgumentException(sprintf(
                "A propriedade '%s' não existe em '%s' Classe de DTO",
                $propriedade,
                get_class()
            ));
        }

        return $this->{$propriedade};
    }

    public function jsonSerialize(): mixed
    {
        return $this->values();
    }

    public function __get(string $nome)
    {
        return $this->get($nome);
    }

    public function __set(string $nome, mixed $value)
    {
        throw new InvalidArgumentException(
            sprintf("A propriedade '%s' é apenas leitura", $nome)
        );
    }

    public function __isset($nome): bool
    {
        return property_exists($this, $nome);
    }
}
