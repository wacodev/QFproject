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
            <p class="titulo">LISTADO DE RESERVACIONES</p>
        </div>

        <!-- DATOS DE LA RESERVACIÓN -->
        <p><strong><center>FECHA: {{ \Carbon\Carbon::parse($manana)->format('d/m/Y') }}</center></strong></p>
            @if ($reservaciones->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="active">
                        <th>Local</th>
                        <th>Hora</th>
                        <th>Responsable</th>
                        <th>Asignatura</th>
                        <th>Actividad</th>
                    </tr>
                </thead>
                <tbody>
          
                @foreach($reservaciones as $reservacion)
                    <tr>
                        <td>{{ $reservacion->local->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('h:i A') }}</td>
                        <td>
                            @if ($reservacion->responsable)
                                {{ $reservacion->responsable }}
                            @else
                                {{ $reservacion->user->name }} {{ $reservacion->user->lastname }}
                            @endif
                        </td>
                        <td>{{ substr($reservacion->asignatura->nombre, 0, 30) }}</td>
                        <td>{{ substr($reservacion->actividad->nombre, 0, 20) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
               @else
               <hr>
              <div align="center">
              <font color="red">

                    <b><em>
                        NO SE ENCONTRARON RESERVAS 
                    </em></b>
               </font>
                </div>
                <hr>
            @endif
    </body>
</html>