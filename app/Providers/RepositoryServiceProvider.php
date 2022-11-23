<?php

namespace App\Providers;

use App\Repository\Cliente\ClienteRepositoryEloquent;
use App\Repository\Cliente\ClienteRepositoryInterface;
use App\Repository\Estoque\EstoqueRepositoryEloquent;
use App\Repository\Estoque\EstoqueRepositoryInterface;
use App\Repository\Imagem\ImagemRepositoryEloquent;
use App\Repository\Imagem\ImagemRepositoryInterface;
use App\Repository\Notificacao\NotificacaoClienteTopicoRepositoryEloquent;
use App\Repository\Notificacao\NotificacaoClienteTopicoRepositoryInterface;
use App\Repository\Notificacao\NotificacaoClienteMensagemRepositoryEloquent;
use App\Repository\Notificacao\NotificacaoClienteMensagemRepositoryInterface;
use App\Repository\Notificacao\NotificacaoMensagemRepositoryEloquent;
use App\Repository\Notificacao\NotificacaoMensagemRepositoryInterface;
use App\Repository\Notificacao\NotificacaoTopicoRepositoryEloquent;
use App\Repository\Notificacao\NotificacaoTopicoRepositoryInterface;
use App\Repository\Produto\ProdutoRepositoryEloquent;
use App\Repository\Produto\ProdutoRepositoryInterface;
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
        $this->app->bind(ProdutoRepositoryInterface::class, ProdutoRepositoryEloquent::class);
        $this->app->bind(EstoqueRepositoryInterface::class, EstoqueRepositoryEloquent::class);
        $this->app->bind(NotificacaoClienteMensagemRepositoryInterface::class, NotificacaoClienteMensagemRepositoryEloquent::class);
        $this->app->bind(NotificacaoClienteTopicoRepositoryInterface::class, NotificacaoClienteTopicoRepositoryEloquent::class);
        $this->app->bind(NotificacaoMensagemRepositoryInterface::class, NotificacaoMensagemRepositoryEloquent::class);
        $this->app->bind(NotificacaoTopicoRepositoryInterface::class, NotificacaoTopicoRepositoryEloquent::class);
    }
}
