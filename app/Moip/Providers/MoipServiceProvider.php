<?php
/**
 * Created by PhpStorm.
 * User: DevMaker BackEnd
 * Date: 17/04/2018
 * Time: 14:40
 */

namespace App\Moip\Providers;


use App\Fipe\Commands\SyncFipe;
use App\Moip\Commands\GenerateWebhookMoip;
use Illuminate\Support\ServiceProvider;

class MoipServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateWebhookMoip::class,
            ]);
        }
    }
}