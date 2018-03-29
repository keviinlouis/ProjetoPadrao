@extends('emails.email-base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Mudança de plano</div>

                <div class="card-body">
                    O plano {{$plano->nome}} foi desativado e tivermos que mudar o plano dos seguintes animais<br>
                    <ul>
                    @foreach($dados as $key => $animal)
                        @if(!is_string($animal))
                        <li>{{$animal->nome}}</li>
                        @endif
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection