<?php

namespace App\Actions\Usuario;

use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class CadastrarUsuarioAction
{
    public function execute(array $dados): void
    {
        DB::transaction(function () use ($dados) {
            event(new Registered(Usuario::create($dados)));
        });
    }
}
