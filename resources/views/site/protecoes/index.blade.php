@extends('site.layouts.app')

@section('content')

    @include('site.layouts.navbar')

    <div class="jumbotron" id="home" style="background-image:url('{{ asset('assets/images/protecoes.jpg') }}');">

        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-6">

                    <div class="title">

                        <h1>Proteções</h1>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <section class="section md">

        <div class="container-fluid">

            <p class="p-v-25">
                É importante se manter protegido. Por isso que a ANJO oferece as melhores coberturas adicionais para manter seus associados satisfeitos mesmo após alguma eventualidade.
                <br /><br />
                Nossa missão é garantir que você e sua família recebam a melhor assistência, com rapidez e segurança.
            </p>

            <div class="row protecoes-row">

                <div class="col-md-4">

                    <div class="protecao">

                        <div class="image">

                            <img src="{{ asset('assets/images/car-breakdown.svg') }}" />

                        </div>

                        <h4 class="default">24h atendimento à sinistros</h4>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="protecao">

                        <div class="image">

                            <img src="{{ asset('assets/images/crane-1-copy.svg') }}" />

                        </div>

                        <h4 class="default">24h guincho com rapidez</h4>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="protecao">

                        <div class="image">

                            <img src="{{ asset('assets/images/battery.svg') }}" />

                        </div>

                        <h4 class="default">24h reposição de baterias</h4>

                    </div>

                </div>

            </div>

            <div class="info">

                <p>Conhecemos a indústria de proteção de dentro pra fora. Oferecemos as melhores soluções para você e seu veículo.</p>

                <button class="button md type-01 primary m-t-15">SIMULADOR</button>

            </div>

        </div>

    </section>

    <section class="section md bg-grey">

        <div class="container-fluid">

            <h2 class="default">Porque escolher nossa proteção?</h2>

            <p>Somos uma associação de benefício mútuo. Participe da nova forma de proteger seu patrimônio.</p>

            <div class="row protecoes-row">

                <div class="col-md-4">

                    <div class="protecao">

                        <div class="image">

                            <img src="{{ asset('assets/images/discount-1-copy.svg') }}" />

                        </div>

                        <h4 class="default">Descontos e benefícios</h4>
                        <p class="default">Proteção extra pra você</p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="protecao">

                        <div class="image">

                            <img src="{{ asset('assets/images/laptop.svg') }}" />

                        </div>

                        <h4 class="default">Área do associado</h4>
                        <p class="default">Agilidade nas solicitações</p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="protecao">

                        <div class="image">

                            <img src="{{ asset('assets/images/24-hours.svg') }}" />

                        </div>

                        <h4 class="default">Serviços 24/7</h4>
                        <p class="default">A hora que precisar</p>

                    </div>

                </div>

            </div>

            <div class="info">

                <p>Na ANJO, somos especialistas no que fazemos. Não há melhor prova disso do que nossa crescente lista de associados.</p>

                <button class="button md type-01 primary m-t-15">SIMULADOR</button>

            </div>

        </div>

    </section>

@endsection()

