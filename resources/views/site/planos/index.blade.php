@extends('site.layouts.app')

@section('content')

    @include('site.layouts.navbar')

    <div class="jumbotron" id="home" style="background-image:url('{{ asset('assets/images/planos-de-adesao.jpg')}}');">

        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-6">

                    <div class="title">

                        <h1>Planos de Adesão</h1>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <section class="section md">

        <div class="container-fluid">

            <p class="p-v-25">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            </p>

            <div class="row planos-row">

                <div class="col-md-4">

                    <div class="portlet type-01">

                        <div class="portlet-header">

                            <h3>FIPE15</h3>

                            <strong>Valores entre R$10 mil e R$15 mil</strong>

                        </div>

                        <div class="portlet-body">

                            <ul class="list">

                                <li class="item">
                                    <h4>R$79,90 <small>Mensal</small></h4>
                                </li>

                                <li class="item">
                                    <h4>R$100,00 <small>Adesão</small></h4>
                                </li>

                            </ul>

                        </div>

                        <div class="portlet-footer">

                            <button class="button md type-01 btn-block primary">CONTRATAR</button>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="portlet type-01">

                        <div class="portlet-header">

                            <h3>FIPE20</h3>

                            <strong>Valores entre R$15 mil e R$20 mil</strong>

                        </div>

                        <div class="portlet-body">

                            <ul class="list">

                                <li class="item active">
                                    <h4>R$89,90 <small>Mensal</small></h4>
                                </li>

                                <li class="item">
                                    <h4>R$100,00 <small>Adesão</small></h4>
                                </li>

                            </ul>

                        </div>

                        <div class="portlet-footer">

                            <button class="button md type-01 btn-block primary">CONTRATAR</button>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="portlet type-01">

                        <div class="portlet-header">

                            <h3>FIPE25</h3>

                            <strong>Valores entre R$20 mil e R$25 mil</strong>

                        </div>

                        <div class="portlet-body">

                            <ul class="list">

                                <li class="item">
                                    <h4>R$109,90 <small>Mensal</small></h4>
                                </li>

                                <li class="item">
                                    <h4>R$100,00 <small>Adesão</small></h4>
                                </li>

                            </ul>

                        </div>

                        <div class="portlet-footer">

                            <button class="button md type-01 btn-block primary">CONTRATAR</button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection()

