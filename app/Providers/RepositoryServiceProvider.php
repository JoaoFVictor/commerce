<?php

namespace App\Providers;

use App\Repository\Imagem\ImagemRepositoryEloquent;
use App\Repository\Imagem\ImagemRepositoryInterface;
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
    }
}
