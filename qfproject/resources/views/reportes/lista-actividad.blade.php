<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <!-- TÍTULO -->
        <title>Listado de reservaciones por actividad</title>
        <!-- BOOTSTRAP 3.3.5 -->
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <!-- MIS ESTILOS -->
        <link rel="stylesheet" href="css/mis-estilos.css" />
        <!-- FAVICON -->
        <link rel="logo-simple" href="{{ asset('images/sistema/logos-simple.png') }}" />
        <link rel="shortcut icon" href="{{ asset('images/sistema/logo-simple.ico') }}" />
    </head>
    <body>
        <!-- ENCABEZADO -->
        <div>
            <img src="images/sistema/logo.png"  alt="Logo de la Facultad de Química y Farmacia" class="logo">
            <div class="cero-margen">
                <p>UNIVERSIDAD DE EL SALVADOR</p>
                <p>FACULTAD DE QUÍMICA Y FARMACIA</p>
                <p>ADMINISTRACIÓN ACADÉMICA</p>
            </div>
        </div>
        <!-- TÍTULO DEL DOCUMENTO -->
        <div class="text-center">
            <p class="titulo">
                LISTADO DE RESERVACIONES POR ACTIVIDAD
            </p>
        </div>
        <!-- INFORMACIÓN GENERAL -->
        <div class="cero-margen">
            <p>
                <strong>
                    Asignatura:
                </strong>
                {{ $asignatura->nombre }}
            </p>
            <p>
                <strong>
                    Actividad:
                </strong>
                {{ $actividad->nombre }}
            </p>
        </div>
        <p>
            <strong>
                Fecha:
            </strong>
            {{ $fecha_inicio }} - {{ $fecha_fin }}
        </p>
        <!-- DATOS DE LAS RESERVACIONES -->
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr class="active">
                        <th>Fecha</th>
                        <th>Local</th>
                        <th>{{ $actividad->nombre }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservaciones as $reservacion)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $reservacion->local->nombre }}</td>
                            <td>{{ $reservacion->tema }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>