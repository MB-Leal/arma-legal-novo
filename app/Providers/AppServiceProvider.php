<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        view()->composer('layouts.admin', function ($view) {
            $countNovos = \App\Models\PedidoArma::where('status_pedido', 'iniciado')->count();
            $view->with('novosPedidosCount', $countNovos);
        });
    }
}
