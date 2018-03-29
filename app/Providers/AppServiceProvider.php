<?php

namespace App\Providers;

use App\Http\Requests\Request;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;
use Reliese\Coders\CodersServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        \Schema::defaultStringLength(191);
        \Carbon\Carbon::setLocale('pt_BR');
        \Carbon\Carbon::setUtf8(true);
        Resource::withoutWrapping();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() != 'production') {
            $this->app->register(CodersServiceProvider::class);
        }

        $this->app->extend(\Illuminate\Http\Request::class, function ($request) {
            return new Request($request);
        });
    }
}
