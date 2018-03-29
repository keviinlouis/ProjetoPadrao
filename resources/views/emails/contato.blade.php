@extends('emails.email-base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Contato PetLovers</div>

                <div class="card-body">
                    Nome: {{$nome}}<br>
                    Email: {{$email}}<br>
                    Assunto: {{$assunto}}<br>
                    Mensagem: {{$mensagem}}<br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection