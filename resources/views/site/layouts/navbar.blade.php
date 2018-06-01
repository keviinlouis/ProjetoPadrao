<div class="responsive-menu">

    <ul class="menu">

        <li class="menu-item logo"><a href="{{ route('site.index') }}"><img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="logo do anjo"></a></li>

    </ul>

</div>

<label for="navbar-controller" class="btn-navbar"><i class="material-icons">menu</i></label>

<input type="checkbox" id="navbar-controller" class="d-none" />

<div class="custom-navbar default">

    <ul class="menu">

        <li class="menu-item logo"><a href="{{ route('site.index') }}"><img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="logo do anjo"></a></li>

        <li class="menu-item"><a href="{{ route('site.index') }}">HOME</a></li>
        <li class="menu-item"><a href="{{ route('site.index') }}">SIMULADOR</a></li>
        <li class="menu-item"><a href="{{ route('site.planos') }}">PLANOS DE ADESÃO</a></li>
        <li class="menu-item"><a href="{{ route('site.protecoes') }}">PROTEÇÕES</a></li>
        <li class="menu-item"><a href="{{ route('site.contato') }}">CONTATO</a></li>
        <li class="menu-item"><a href="{{ route('site.login') }}">ÁREA DO ASSOCIADO</a></li>

    </ul>

</div>