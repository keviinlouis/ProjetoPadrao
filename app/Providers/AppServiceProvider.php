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

        $this->makeRequestLog();
    }

    public function clearLang($lang)
    {
        return trim(
            str_replace('(current)', '',
                strtolower(
                    str_replace('-', '_', $lang)
                )
            )
        );
    }

    private function makeRequestLog(): void
    {
        if(env('APP_ENV') === 'production'){
            return;
        }
        if (strpos(request()->getUri(), 'logs') === false || request()->getRequestUri() == '/') {
            \Log::channel('requests')->info('Route: ' . request()->getRequestUri(), [
                'IP: ' . request()->getClientIp(),
                'Method: '. request()->method(),
                'Headers: '. json_encode(request()->headers->all()),
                'Body: ' . json_encode(request()->toArray()),

            ]);
        }
    }
}
