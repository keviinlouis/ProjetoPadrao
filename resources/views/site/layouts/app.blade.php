<!DOCTYPE html>
<html lang="pt-br">
<head>
    @include('site.layouts.header')
    @stack('styles')
</head>
<body class="{{ isset($bodyClass) ? $bodyClass : ''}}" data-spy="scroll" data-target=".custom-navbar" data-offset="50" style="{{ isset($bodyStyle) ? $bodyStyle : '' }}">
    @yield('content')

    @if(!isset($semFooter))
        @include('site.layouts.footer')
    @endif

    <script src="https://use.fontawesome.com/87763b9fc2.js"></script>
    <script src="{{asset('assets/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/jquery.mask.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/materialize.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/scripts.js')}}" type="text/javascript"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            let maskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00009';
            };
            let options = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(maskBehavior.apply({}, arguments), options);
                }
            };

            $('.numeric-mask').mask('000,00', {reverse: true});
            $('.money-mask').mask('0000000.00', {reverse: true});
            $('.porcent-mask').mask('000,00%', {reverse: true});
            $('.telefone').mask('(00)0000-0000');
            $('.celular').mask(maskBehavior, options);
            $(".cnpj").mask("99.999.999/9999-99");
            $(".cpf").mask("999.999.999-99");
        })
    </script>
    @stack('scripts')
</body>
</html>