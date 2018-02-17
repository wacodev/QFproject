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
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
        <!-- MIS ESTILOS -->
        <link rel="stylesheet" href="{{ asset('css/mis-estilos.css') }}" />
        <!-- FAVICON -->
        <link rel="logo-simple" href="{{ asset('images/sistema/logos-simple.png') }}" />
        <link rel="shortcut icon" href="{{ asset('images/sistema/logo-simple.ico') }}" />
    </head>
    <body>
        <!-- ENCABEZADO -->
        <div>
            <img src="{{ asset('images/sistema/logo.png') }}"  alt="Logo de la Facultad de Química y Farmacia" class="logo">
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
                        @if ($reservaciones[0]->responsable)
                            <td>{{ $reservaciones[0]->responsable }}</td>
                        @else
                            <td>{{ $reservaciones[0]->user->name }} {{ $reservaciones[0]->user->lastname }}</td>
                        @endif
                        <td>{{ $reservaciones[0]->user->tipo }}</td>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $reservaciones[0]->tipo }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservaciones[0]->fecha)->format('d/m/Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($reservaciones[0]->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservaciones[0]->hora_fin)->format('h:i A') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- LISTA DE LOCALES -->
        <p><strong>LOCALES</strong></p>
        <ul>
            @foreach ($reservaciones as $reservacion)
                <li>
                    {{ $reservacion->codigo }} &nbsp;-&nbsp; {{ $reservacion->local->nombre }}
                </li>
            @endforeach
        </ul>
        <!-- DETALLES DE LA RESERVACIÓN -->
        <p>
            Se autoriza a
            @if ($reservaciones[0]->responsable)
                {{ $reservaciones[0]->responsable }}
            @else
                {{ $reservaciones[0]->user->name }} {{ $reservaciones[0]->user->lastname }}
            @endif
            hacer uso de los locales el día {{ \Carbon\Carbon::parse($reservaciones[0]->fecha)->format('d/m/Y') }} de {{ \Carbon\Carbon::parse($reservaciones[0]->hora_inicio)->format('h:i A') }} a {{ \Carbon\Carbon::parse($reservaciones[0]->hora_fin)->format('h:i A') }} para realizar:
        </p>
        <ul>
            <li>
                <strong>Asignatura:</strong>
                {{ $reservaciones[0]->asignatura->codigo }} &nbsp;-&nbsp; {{ $reservaciones[0]->asignatura->nombre }}.
            </li>
            <li>
                <strong>Actividad:</strong>
                {{ $reservaciones[0]->actividad->nombre }}.
            </li>
            <li>
                <strong>Tema a desarrollar:</strong>
                @if ($reservaciones[0]->tema)
                    {{ $reservaciones[0]->tema }}.
                @else
                    Sin definir.
                @endif
            </li>
        </ul>
        <!-- FECHA Y HORA DE EMISIÓN DEL DOCUMENTO -->
        <div class="footer-pagina text-right">
            <img src="{{ asset('images/sistema/sello.png') }}"  alt="Logo de la Facultad de Química y Farmacia" class="sello">
            <p>
                Fecha y hora de emisión: {{ $hoy }}
            </p>
        </div>
    </body>
</html>