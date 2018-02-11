<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <!-- TÍTULO -->
        <title>Listado de reservaciones por usuario</title>
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
                Listado de reservaciones de {{ $user->name }} {{ $user->lastname }}
            </p>
        </div>
        <!-- INFORMACIÓN GENERAL -->
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
                        <th>Local</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Asignatura</th>
                        <th>Actividad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservaciones as $reservacion)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }}</td>
                            <td>{{ substr($reservacion->local->nombre, 0, 35) }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('h:i A') }}</td>
                            <td>{{ substr($reservacion->asignatura->nombre, 0, 45) }}</td>
                            <td>{{ substr($reservacion->actividad->nombre, 0, 25) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>