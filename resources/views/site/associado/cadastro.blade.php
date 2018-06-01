@extends('site.layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_associado/css/main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_associado/css/login-register.css') }}" />
@endpush

@section('content')

    @include('site.layouts.navbar')

    <div class="register">

        <h5 class="center-align">Crie sua conta agora e aproveite todos os nossos benfícios!</h5>

        <form>

            <div class="row">

                <div class="input-field md col s12 m6">

                    <input id="cpf-cnpj" type="text" placeholder="Nome" class="browser-default field type-01 md default" />
                    <label for="cpf-cnpj">Nome</label>

                </div>

                <div class="input-field md col s12 m6">

                    <input id="cpf-cnpj" type="text" placeholder="Sobrenome" class="browser-default field type-01 md default" />
                    <label for="cpf-cnpj">Sobrenome / Razao Social</label>

                </div>

            </div>

            <div class="row">

                <div class="input-field md col s12 m6">

                    <input id="cpf-cnpj" type="text" placeholder="(00) 9 8888 8888" class="browser-default field type-01 md default" />
                    <label for="cpf-cnpj">Telefone</label>

                </div>

                <div class="input-field md col s12 m6">

                    <input id="cpf-cnpj" type="text" placeholder="seuemail@email.com" class="browser-default field type-01 md default" />
                    <label for="cpf-cnpj">E-mail</label>

                </div>

            </div>

            <div class="row">

                <div class="input-field md col s12 m6">

                    <input id="cpf-cnpj" type="text" placeholder="********" class="browser-default field type-01 md default" />
                    <label for="cpf-cnpj">Senha</label>

                </div>

                <div class="input-field md col s12 m6">

                    <input id="cpf-cnpj" type="text" placeholder="********" class="browser-default field type-01 md default" />
                    <label for="cpf-cnpj">Confirmar senha</label>

                </div>

            </div>

            <div class="row">

                <div class="input-field md col s12 m6 offset-m3 flex-jcc">

                    <input id="cpf-cnpj" type="text" placeholder="XXXXXXX" class="browser-default field type-01 md default center-align" />
                    <label for="cpf-cnpj" class="center-align">CÓDIGO DO REPRESENTANTE</label>

                </div>

            </div>

            <div class="row">

                <div class="col s12 m4 offset-m4">

                    <button class="waves-effect waves-light btn-large full-width primary">CADASTRAR</button>

                </div>

            </div>

        </form>

    </div>

@endsection()

