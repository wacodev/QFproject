<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <!-- TÍTULO -->
        <title>Comprobante de reservación</title>
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
            <p class="titulo">COMPROBANTE DE RESERVACIÓN DE ESPACIO FÍSICO</p>
        </div>
        <!-- DATOS DEL USUARIO -->
        <p><strong>RESPONSABLE DE LA RESERVACIÓN</strong></p>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr class="active">
                        <th>Nombre</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @if ($reservacion->responsable)
                            <td>{{ $reservacion->responsable }}</td>
                        @else
                            <td>{{ $reservacion->user->name }} {{ $reservacion->user->lastname }}</td>
                        @endif
                        <td>{{ $reservacion->user->tipo }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- DATOS DE LA RESERVACIÓN -->
        <p><strong>DATOS DE LA RESERVACIÓN</strong></p>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr class="active">
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Local</th>
                        <th>Código de comprobación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $reservacion->tipo }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('h:i A') }}
                        </td>
                        <td>{{ substr($reservacion->local->nombre, 0, 22) }}</td>
                        <td>{{ $reservacion->codigo }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- DETALLES DE LA RESERVACIÓN -->
        <p class="margen-arriba-grande">
            Se autoriza a
            @if ($reservacion->responsable)
                {{ $reservacion->responsable }}
            @else
                {{ $reservacion->user->name }} {{ $reservacion->user->lastname }}
            @endif
            hacer uso del local {{ $reservacion->local->nombre }} el día {{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }} de {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('h:i A') }} a {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('h:i A') }} para realizar:
        </p>
        <ul>
            <li>
                <strong>Asignatura:</strong>
                {{ $reservacion->asignatura->codigo }} &nbsp;-&nbsp; {{ $reservacion->asignatura->nombre }}.
            </li>
            <li>
                <strong>Actividad:</strong>
                {{ $reservacion->actividad->nombre }}.
            </li>
            <li>
                <strong>Tema a desarrollar:</strong>
                @if ($reservacion->tema)
                    {{ $reservacion->tema }}.
                @else
                    Sin definir.
                @endif
            </li>
        </ul>
        <!-- FECHA Y HORA DE EMISIÓN DEL DOCUMENTO -->
        <div class="footer-pagina text-right">
            <img src="images/sistema/sello.png"  alt="Logo de la Facultad de Química y Farmacia" class="sello">
            <p>
                Fecha y hora de emisión: {{ $hoy }}
            </p>
        </div>
    </body>
</html>