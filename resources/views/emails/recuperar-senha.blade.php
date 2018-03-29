@extends('emails.email-base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Redefinir Senha</div>

                <div class="card-body">
                    Foi solicitado uma mudança de senha para a sua conta PetLoversApp<br>
                    Caso não tenha sido você, apenas ignore este email<br>
                    <br>
                    <br>
                    Para mudar a sua senha, <a href="{{$url}}">clique aqui</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection