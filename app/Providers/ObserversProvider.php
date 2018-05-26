<?php

namespace App\Providers;

use App\Entities\Arquivo;
use App\Entities\Endereco;
use App\Observers\ArquivoObserver;
use App\Observers\EnderecoObserver;
use Illuminate\Support\ServiceProvider;

class ObserversProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Arquivo::observe(ArquivoObserver::class);
        Endereco::observe(EnderecoObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
