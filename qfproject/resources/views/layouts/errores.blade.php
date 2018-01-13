<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- TÍTULO -->
        <title>
            @yield('titulo', 'Error')
        </title>
        <!-- BOOTSTRAP 3.3.5 -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
        <!-- MIS ESTILOS -->
        <link rel="stylesheet" href="{{ asset('css/mis-estilos.css') }}">
        <!-- FAVICON -->
        <link rel="logo-simple" href="{{ asset('images/sistema/logos-simple.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/sistema/logo-simple.ico') }}">
    </head>
    <body class="fondo">
        <div class="jumbotron">
            <div class="container">
                <h2>@yield('encabezado', 'Error')</h2>
            </div>
        </div>
        <div class="container text-center">
            <div class="row">
                <div class="col-xs-12">
                    <!--<img src="{{ asset('images/sistema/robot.png') }}" alt="Robot" class="img-responsive" style="display: inline">-->
                    <img src="{{ asset('images/sistema/robot.png') }}" alt="Robot" class="img-responsive img-robot">
                    <h3 class="verde-claro">
                        @yield('mensaje', 'Error')
                    </h3>
                    <p class="margen-arriba-grande">
                        <a href="{{ url('/') }}"><i class="fa fa-home icono-margen" aria-hidden="true"></i>
                            Volver al inicio
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>