<?php

namespace qfproject\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * ---------------------------------------------------------------------------
         * Línea agregada para arreglar error:
         * SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was
         * too long; max key length is 767 bytes.
         *
         * Si utiliza MySQL v5.7.7 o superior, no debería tener problemas y podría
         * comentar o borrar las líneas 13 y 37.
         *
         * Fuente: https://laravel-news.com/laravel-5-4-key-too-long-error
         * ---------------------------------------------------------------------------
         */
        
        Schema::defaultStringLength(191);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
