<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespaceWeb = 'App\Http\Controllers\Web';
    protected $namespaceUtils = 'App\Http\Controllers\Utils';
    //TODO Criar namespaces para cada tipo acessavel no sistema

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespaceWeb)
             ->group(base_path('routes/web.php'));


    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespaceUtils)
             ->group(base_path('routes/utils.php'));

        //TODO Configurar Rotas para tipos acesaveis no sistema
        // É recomendavel separar as rotas para cada tipo de usuario que irá acessar o sistema
        // Deixar a utils para acesso comum entre os usuarios
        // Caso não queira, apenas utilize as rotas web e remova a configuração acima
    }
}
