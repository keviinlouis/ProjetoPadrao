<?php

namespace App\Providers;

use App\Entities\Animal;
use App\Entities\Anuncio;
use App\Entities\Arquivo;
use App\Entities\Banner;
use App\Entities\Dono;
use App\Entities\Mensagem;
use App\Entities\Notificacao;
use App\Entities\Pagamento;
use App\Entities\Plano;
use App\Observers\AnimaisObserver;
use App\Observers\AnunciosObserver;
use App\Observers\ArquivosObserver;
use App\Observers\BannersObserver;
use App\Observers\DonosObserver;
use App\Observers\MensagensObserver;
use App\Observers\NotificacoesObserver;
use App\Observers\PagamentosObserver;
use App\Observers\PlanosObserver;
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
//        Arquivo::observe(ArquivosObserver::class);
//        Mensagem::observe(MensagensObserver::class);
//        Pagamento::observe(PagamentosObserver::class);
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
