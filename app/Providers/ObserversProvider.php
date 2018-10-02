<?php

namespace App\Providers;

use App\Entities\Arquivo;
use App\Entities\Endereco;
use App\Observers\FileObserver;
use App\Observers\AddressObserver;
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
        Arquivo::observe(FileObserver::class);
        Endereco::observe(AddressObserver::class);
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
