<?php

namespace App\Providers;

use App\Repository\Cliente\ClienteRepositoryEloquent;
use App\Repository\Cliente\ClienteRepositoryInterface;
use App\Repository\Imagem\ImagemRepositoryEloquent;
use App\Repository\Imagem\ImagemRepositoryInterface;
use App\Repository\Usuario\UsuarioRepositoryEloquent;
use App\Repository\Usuario\UsuarioRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImagemRepositoryInterface::class, ImagemRepositoryEloquent::class);
        $this->app->bind(UsuarioRepositoryInterface::class, UsuarioRepositoryEloquent::class);
        $this->app->bind(ClienteRepositoryInterface::class, ClienteRepositoryEloquent::class);
    }
}
