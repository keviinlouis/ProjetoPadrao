@extends('site.layouts.app')

@section('content')

@include('site.layouts.navbar')

<div class="jumbotron" id="home" style="background-image:url('assets/images/jumbotron.jpg');">

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-6">

                <div class="form">

                    <h5>Simule agora sua cotação:</h5>

                    <div class="row">

                        <div class="col-md-8">

                            <div class="form-group">

                                <label>Marca:</label>

                                <select class="select2 default field type-01">
                                    <option>Digite o nome ou selecione</option>
                                </select>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>Ano:</label>

                                <select class="select2 default field type-01">
                                    <option>Digite ou selecione</option>
                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Modelo:</label>

                        <select class="select2 default field type-01">
                            <option>Digite o nome ou selecione</option>
                        </select>

                    </div>

                    <div class="values">

                        <div class="value">

                            <h5>VALOR TABELA FIPE:</h5>
                            <h4 class="primary">R$00</h4>

                        </div>

                        <div class="value">

                            <h5>COTAÇÃO ESTIMADA:</h5>
                            <h4 class="default">R$00<small>/mês</small></h4>

                        </div>

                    </div>

                    <div class="form-group text-center">

                        <button class="button primary type-01 md">CONTRATAR</button>

                    </div>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="title">

                    <h1>Anjo,</h1>
                    <h2>A melhor proteção para seu veículo!</h2>

                </div>

            </div>

        </div>

    </div>

</div>

<section class="section md" id="sobre-nos">

    <div class="container-fluid" style="background-image:url('{{ asset('assets/images/bg-1.png') }}');">

        <div class="row">

            <div class="col-md-6 col-sm-10">

                <h2 class="title default">Sobre <strong>nós,</strong></h2>

                <p>
                    A ANJO surgiu da reunião de um grupo de pessoas buscando benefícios e vantagens mútuas, proporcionando economias e outros proveitos aos associados quando da aquisição de serviços e produtos, por meio de empresas parceiras e também através da própria associação.

                    <br />
                    <br />

                    Estamos comprometidos em oferecer os maiores níveis de proteção com preços acessíveis.
                </p>

            </div>

        </div>

        <div class="row">

            <div class="col-md-4 col-sm-10">

                <button class="button type-02 md primary btn-block shadow">ENTRE EM CONTATO</button>

            </div>

        </div>

    </div>

</section>

<section class="section md" style="background-image:url('{{ asset('assets/images/bg-2.jpg') }}');">

    <div class="container-fluid">

        <h2 class="subtitle white">
            Simples, eficiente e o melhor,<br />
            <strong>cabe</strong> no seu <strong>bolso!</strong>
        </h2>

    </div>

</section>

<section class="section md" id="beneficios">

    <div class="container-fluid">

        <h2 class="default m-b-25">Benefícios do <strong class="primary">Clube Anjo!</strong></h2>

        <div class="row lg">

            <div class="col-lg-4">

                <div class="icon">

                    <img src="{{ asset('assets/images/icon-1.png') }}" alt="garanta sua proteção" />

                </div>

                <h4 class="default">Garanta sua proteção</h4>

                <div class="body">

                    <p>
                        Para evitar preocupações desnecessárias, garantimos a proteção em caso de acidentes. Com parcerias estratégicas, elaboramos planos que oferecem os maiores níveis de proteção.
                        <br />
                        <br />
                        Faça sua simulação, sem cadastro, agora mesmo pelo site.
                    </p>

                </div>

                <div class="form-group">

                    <button class="button type-02 primary md shadow btn-block">SIMULAR</button>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="icon">

                    <img src="{{ asset('assets/images/icon-2.png') }}" alt="garanta sua proteção" />

                </div>

                <h4 class="default">Proteções adicionais</h4>

                <div class="body">

                    <p>
                        É importante se manter protegido. Por isso que a ANJO oferece as melhores proteções adicionais para manter seus associados satisfeitos mesmo após alguma eventualidade.
                        <br />
                        <br />
                        Nossa missão é garantir que você e sua família recebam a melhor assistência, com rapidez e segurança.
                    </p>

                </div>

                <div class="form-group">

                    <button class="button type-02 primary md shadow btn-block">PROTEÇÃO</button>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="icon">

                    <img src="{{ asset('assets/images/icon-3.png') }}" alt="garanta sua proteção" />

                </div>

                <h4 class="default">Clube de benefícios</h4>

                <div class="body">

                    <p>
                        Todos os associados têm acesso ao clube de descontos na rede de conveniados.
                        <br />
                        <br />
                        ​Nossos consultores estão sempre em busca de novas parcerias para oferecer benefícios cada vez maiores. Por isso nossa associação é considerada a melhor proteção para você. Verifique as promoções de sua região!
                    </p>

                </div>

                <div class="form-group">

                    <button class="button type-02 primary md shadow btn-block">DESCONTOS</button>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection()

