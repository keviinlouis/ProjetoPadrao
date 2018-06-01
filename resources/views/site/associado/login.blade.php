@extends('site.layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_associado/css/main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_associado/css/login-register.css') }}" />
@endpush

@section('content')

    @include('site.layouts.navbar')

    <div class="login">

        <p>Acesse agora sua área de associado:</p>

        <form action="" method="get">

            <div class="input-field md">

                <input id="cpf-cnpj" type="text" placeholder="CPF/CNPJ" class="browser-default field type-01 md default" />
                <label for="cpf-cnpj">Informe seu CPF ou CNPJ</label>

            </div>

            <div class="input-field md m-b-5">

                <input id="password" type="password" placeholder="Senha" class="browser-default field type-01 md default" />
                <label for="password">Digite sua senha</label>

            </div>

            <div class="flex-aic-jcsb">

                <label>

                    <input type="checkbox" />
                    <span class="default">Lembrar senha</span>

                </label>

                <a href="#" class="default">Esqueceu a senha?</a>

            </div>

            <button class="waves-effect waves-light btn-large full-width m-t-30 primary">ENTRAR</button>
            <button class="waves-effect waves-light btn-large full-width facebook"><i class="fab fa-facebook-f fa-lg m-r-10"></i> ENTRAR COM FACEBOOK</button>

            <div class="new-account">

                <a href="{{ route('site.cadastro') }}" class="default">Ainda não tem uma conta?</a>

                <a class="waves-effect waves-light btn full-width black rounded" onclick="window.location.href = '{{ route('site.cadastro') }}'">CADASTRE-SE</a>

            </div>

        </form>

    </div>

@endsection()

