<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('local')) {
            DB::listen(function ($query) {
                File::append(
                    storage_path('/logs/query.log'),
                    '['.date('Y-m-d H:i:s').']'.PHP_EOL.$query->sql.' ['.implode(', ', $query->bindings).']'.PHP_EOL.PHP_EOL
                );
            });
        }
    }
}
