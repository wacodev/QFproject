<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Sistema de Reservación de Locales</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- BOOTSTRAP 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <!-- ESTILO DEL TEMA -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css')}}">
    <!-- MIS ESTILOS -->
    <link rel="stylesheet" href="{{ asset('css/mis-estilos.css') }}">
    <!-- FAVICON -->
    <link rel="logo-simple" href="{{ asset('images/sistema/logos-simple.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/sistema/logo-simple.ico') }}">

</head>
<body class="hold-transition login-page login-fondo">
        <div class="login-box">
            <!-- LOGO -->
            <div class="login-logo login-logo-color">
                Facultad de Química y Farmacia
            </div>
       
            <!-- CONTENIDO -->
            <center>
    
        @yield('content')
               
    
            </div>
            </center>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
