<?php

namespace App\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormCollectiveProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component(
            'logout',
            'componentes.form.logout',
            [
                'route' => 'logout',
                'id' => 'form-logout'
            ]
        );

        Form::component(
            'delete',
            'componentes.form.delete',
            [
                'route',
                'modelId',
                'id' => 'form-delete'
            ]
        );

        Form::component(
            'inputEmail',
            'componentes.form.email',
            [
                'label' => null,
                'class' => [],
                'name' => 'email',
                'value' => null,
                'id' => null,
                'placeholder' => null,
                'attributes' => []
            ]
        );

        Form::component(
            'inputSenha',
            'componentes.form.senha',
            [
                'label' => null,
                'class' => [],
                'name' => 'senha',
                'id' => null,
                'placeholder' => null,
                'attributes' => []
            ]
        );
    }
}
