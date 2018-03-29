@extends('auth.layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Resetar Senha</div>

                    <div class="card-body">
                        @if(!$token)
                            <div class="alert alert-danger">Opa, parece que o token está incorreto</div>
                        @else
                            <form method="POST" action="{{ $route }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               name="email" value="{{ $email or old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="senha" class="col-md-4 col-form-label text-md-right">Nova Senha</label>

                                    <div class="col-md-6">
                                        <input id="senha" type="password"
                                               class="form-control{{ $errors->has('senha') ? ' is-invalid' : '' }}"
                                               name="senha" required>

                                        @if ($errors->has('senha'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('senha') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="senha-confirm" class="col-md-4 col-form-label text-md-right">Confirmar
                                        Senha</label>
                                    <div class="col-md-6">
                                        <input id="senha-confirm" type="password"
                                               class="form-control{{ $errors->has('senha_confirmation') ? ' is-invalid' : '' }}"
                                               name="senha_confirmation" required>

                                        @if ($errors->has('senha_confirmation'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('senha_confirmation') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Resetar senha
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
