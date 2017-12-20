<!DOCTYPE html>

<html lang="es">
    
    <head>
        
        <!-- METAINFORMACIÓN -->
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
        <!-- TÍTULO -->

        <title>503 - Servicio no disponible</title>
    
        <!-- DILE AL NAVEGADOR QUE RESPONDA AL ANCHO DE LA PANTALLA -->
    
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
        <!-- BOOTSTRAP 3.3.5 -->
    
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
        <!-- FONT AWESOME -->
    
        <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">

        <!-- MIS ESTILOS -->
    
        <link rel="stylesheet" href="{{ asset('css/mis-estilos.css') }}">

    </head>
    
    <body class="fondo">

        <div class="jumbotron">
            <div class="container">
                <h2>503 - Servicio no disponibe</h2>
            </div>
        </div>
        <div class="container text-center">
            <div class="col-xs-12">
            <img src="{{ asset('images/sistema/robot.png') }}" alt="Robot" class="img-responsive" style="display: inline">
            <h3 class="verde-claro">El servidor no puede responder a la petición en este momento</h3>
            <p style="margin-top: 50px;">
                <a href="{{ url('/') }}"><i class="fa fa-home icono-margen" aria-hidden="true"></i>Volver al inicio</a>
            </p>
            </div>
        </div>

    </body>

</html>