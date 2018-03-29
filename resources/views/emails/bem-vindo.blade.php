@extends('emails.email-base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Bem vindo {{$dono->nome}}</div>

                <div class="card-body">
                    Olá {{$dono->nome}}, seja bem vindo ao PetLovers!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection