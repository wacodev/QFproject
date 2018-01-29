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
            <p class="titulo">COMPROBANTE DE RESERVACIÓN DE LOCAL</p>
        </div>
        <!-- DATOS DEL USUARIO -->
        <p><strong>DATOS DEL USUARIO</strong></p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="active">
                     @if(Auth::user()->tipo == 'Administrador' || Auth::user()->tipo == 'Asistente')   
                        <th>Apellidos</th>
                        <th>Nombres</th>
                     @endif
                        <th>Cargo</th>
                    @if(Auth::user()->tipo == 'Administrador' || Auth::user()->tipo == 'Visitante')
                        <th>Responsable de reserva</th>
                     @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    @if(Auth::user()->tipo == 'Administrador' || Auth::user()->tipo == 'Asistente')  
                        <td>{{ $reservacion->user->lastname }}</td>
                        <td>{{ $reservacion->user->name }}</td>
                    @endif
                        <td>{{ $reservacion->user->tipo }}</td>
                    @if(Auth::user()->tipo == 'Administrador' || Auth::user()->tipo == 'Visitante')
                        <td>{{ $reservacion->responsable }}</td>
                    @endif
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- DATOS DE LA RESERVACIÓN -->
        <p><strong>DATOS DE LA RESERVACIÓN</strong></p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="active">
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Local</th>
                        <th>Código de comprobación</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $reservacion->fecha }}</td>
                        <td>{{ $reservacion->hora_inicio }} - {{ $reservacion->hora_fin }}</td>
                        <td>{{ $reservacion->local->nombre }}</td>
                        <td>{{ $reservacion->codigo }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- DETALLES DE LA RESERVACIÓN -->
        <p class="margen-arriba-grande">
            Se autoriza a {{ $reservacion->user->name }} {{ $reservacion->user->lastname }} hacer uso del local {{ $reservacion->local->nombre }} el día {{ $reservacion->fecha }} de {{ $reservacion->hora_inicio }} a {{ $reservacion->hora_fin }} para realizar:
        </p>
        <ul>
            <li><strong>Actividad:</strong> {{ $reservacion->actividad->nombre }}.</li>
            <li><strong>Asignatura:</strong> [{{ $reservacion->asignatura->codigo }}] {{ $reservacion->asignatura->nombre }}.</li>
            <li><strong>Tema a desarrollar:</strong>
                @if ($reservacion->tema != null)
                    {{ $reservacion->tema }}.
                @else
                    Sin definir.
                @endif
            </li>
        </ul>
        <!-- FECHA Y HORA DE EMISIÓN DEL DOCUMENTO -->
        <p class="footer-pagina">Fecha y hora de emisión: {{ $hoy }}</p>
    </body>
</html>