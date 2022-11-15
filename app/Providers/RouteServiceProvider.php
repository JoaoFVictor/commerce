<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    protected $namespace = 'App\\Http\\Controllers';
    protected $namespaceAuth = 'App\\Http\\Controllers\\Auth';
    protected $namespaceCliente = 'App\\Http\\Controllers\\Cliente';
    protected $namespaceUsuario = 'App\\Http\\Controllers\\Usuario';

    public function boot()
    {
        $this->configureRateLimiting();
        $this->carregarArquivosRotas();
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    private function carregarArquivosRotas()
    {
        $this->routes(
            function () {
                Route::namespace($this->namespace)->middleware('web')->group(base_path('routes/web.php'));
                Route::namespace($this->namespaceAuth)->group(base_path('routes/auth.php'));
                Route::namespace($this->namespaceAuth)->group(base_path('routes/email.php'));
                Route::namespace($this->namespaceAuth)->group(base_path('routes/password.php'));
                Route::namespace($this->namespaceCliente)->middleware('api')->group(base_path('routes/cliente.php'));
                Route::namespace($this->namespaceUsuario)->middleware('api')->group(base_path('routes/usuario.php'));
            }
        );
    }
}
