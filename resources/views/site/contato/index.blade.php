@extends('site.layouts.app')

@section('content')

@include('site.layouts.navbar')

<section class="section md m-t-50">

    <div class="container-fluid">

        <div class="row contact-row">

            <div class="col-md-6">

                <div class="form-group">

                    <label>Nome</label>
                    <input type="text" class="field type-02 default md" placeholder="Escrever" />

                </div>

                <div class="form-group">

                    <label>E-mail</label>
                    <input type="text" class="field type-02 default md" placeholder="seuemail@email.com.br" />

                </div>

                <div class="form-group">

                    <label>Mensagem</label>
                    <textarea type="text" class="field type-02 default md" rows="7" placeholder="Escrever"></textarea>

                </div>

                <div class="form-group">

                    <button class="button md primary type-01 btn-block">ENVIAR</button>

                </div>

            </div>

            <div class="col-md-6">

                <div class="contacts">

                    <div class="contact">

                        <div class="image">
                            <img src="{{ asset('assets/images/phone-receiver.svg') }}" />
                        </div>

                        <h5>+55-41-3016-7182</h5>

                    </div>

                    <div class="contact">

                        <div class="image">
                            <img src="{{ asset('assets/images/mail.svg') }}" />
                        </div>

                        <h5>anjo@anjo.net.br</h5>

                    </div>

                    <div class="contact">

                        <div class="image">
                            <img src="{{ asset('assets/images/map.svg') }}" />
                        </div>

                        <h5>Av. Maringá 271 - Pinhais / PR</h5>

                    </div>

                    <div class="contact">

                        <div class="image">
                            <img src="{{ asset('assets/images/facebook.svg') }}" />
                        </div>

                        <h5>/facebook</h5>

                    </div>

                    <div class="contact">

                        <div class="image">
                            <img src="{{ asset('assets/images/linkedin.svg') }}" />
                        </div>

                        <h5>/linkedin</h5>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection()