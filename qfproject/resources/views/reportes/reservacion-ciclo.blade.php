<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <!-- TÍTULO -->
        <title>Reporte de reservaciones por ciclo</title>
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
            <p class="titulo">INFORME DE LA OPERACIÓN</p>
        </div>
        <p>
            <strong>
                RESERVACIONES DEL CICLO NO REGISTRADAS
            </strong>
        </p>
        <div class="table-responsive">
            <table class="table table-bordered">
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
                    @foreach ($rnr as $r1)
                        <tr>
                            <td>{{ $r1->local->nombre }}</td>
                            <td>{{ $r1->fecha }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($r1->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($r1->hora_fin)->format('h:i A') }}
                            </td>
                            <td>{{ $r1->asignatura->nombre }}</td>
                            <td>{{ $r1->actividad->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p>
            <strong>
                RESERVACIONES DE TERCEROS ELIMINADAS
            </strong>
        </p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="active">
                        <th>Usuario</th>
                        <th>Local</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Asignatura</th>
                        <th>Actividad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($re as $r2)
                        <tr>
                            <td>{{ $r2->user->name }} {{ $r2->user->lastname }}</td>
                            <td>{{ $r2->local->nombre }}</td>
                            <td>{{ $r2->fecha }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($r2->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($r2->hora_fin)->format('h:i A') }}
                            </td>
                            <td>{{ $r2->asignatura->nombre }}</td>
                            <td>{{ $r2->actividad->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- FECHA Y HORA DE EMISIÓN DEL DOCUMENTO -->
        <p class="footer-pagina">
            Fecha y hora de emisión: {{ $hoy }}
        </p>
    </body>
</html>