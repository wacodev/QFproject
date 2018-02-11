<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <!-- TÍTULO -->
        <title>Reporte de ocupación de espacio físico</title>
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
                REPORTE DE OCUPACIÓN DE ESPACIO FÍSICO
            </p>
        </div>
        <!-- INFORMACIÓN GENERAL -->
        <div class="cero-margen">
            <p>
                <strong>
                    Local:
                </strong>
                {{ $local->nombre }}
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
                        <th>Hora</th>
                        <th>Porcentaje de ocupación (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 11; $i++)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($horas[$i])->format('h:i A') }}</td>
                            <td>{{ $porcentajes[$i] }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </body>
</html>