<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <!-- TÍTULO -->
        <title>Listado de choques</title>
        <!-- BOOTSTRAP 3.3.5 -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
        <!-- ESTILO DEL TEMA -->
        <link rel="stylesheet" href="{{ asset('css/AdminLTE.css')}}" />
        <!-- MIS ESTILOS -->
        <link rel="stylesheet" href="{{ asset('css/mis-estilos.css') }}" />
        <!-- FAVICON -->
        <link rel="logo-simple" href="{{ asset('images/sistema/logos-simple.png') }}" />
        <link rel="shortcut icon" href="{{ asset('images/sistema/logo-simple.ico') }}" />
    </head>
    <body onload="window.print();">
        <div class="wrapper">
            <section class="invoice">
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
                    <p class="titulo">
                        LISTADO DE CHOQUES DE RESERVACIONES
                    </p>
                </div>
                <!-- LISTADO DE CHOQUES -->
                @foreach ($listado as $lista)
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr class="active">
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Local</th>
                                    <th>Responsable</th>
                                    <th>Código</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lista as $reservacion)
                                    <tr>
                                        <td>{{ $reservacion->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('h:i A') }}
                                        </td>
                                        <td>{{ $reservacion->local->nombre }}</td>
                                        @if ($reservacion->responsable)
                                            <td>{{ $reservacion->responsable }}</td>
                                        @else
                                            <td>{{ $reservacion->user->name }} {{ $reservacion->user->lastname }}</td>
                                        @endif
                                        <td>{{ $reservacion->codigo }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </section>
        </div>
    </body>
</html>