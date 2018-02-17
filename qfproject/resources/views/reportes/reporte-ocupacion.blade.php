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
        @for ($i = 0; $i < count($principal); $i++)
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
                            REPORTE DE OCUPACIÓN DE ESPACIO FÍSICO
                        </p>
                    </div>
                    <!-- INFORMACIÓN GENERAL -->
                    <div class="cero-margen">
                        <p>
                            <strong>
                                Local:
                            </strong>
                            {{ $locales[$i]->nombre }}
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
                                @for ($j = 0; $j < 11; $j++)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($horas[$j])->format('h:i A') }}</td>
                                        <td>{{ $principal[$i][$j] }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        @endfor
    </body>
</html>