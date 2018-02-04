<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <!-- TÍTULO -->
        <title>Horarios</title>
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
        <div class="pull-right">
            <p>
                <strong>
                    {{ $local->nombre }}
                </strong>
                <br>
                {{ $fecha_inicio }} - {{ $fecha_fin }}
            </p>
        </div>
        <div>
            <img src="images/sistema/logo.png"  alt="Logo de la Facultad de Química y Farmacia" class="logo-horarios">
            <div class="cero-margen">
                <p>UNIVERSIDAD DE EL SALVADOR</p>
                <p>FACULTAD DE QUÍMICA Y FARMACIA</p>
            </div>
            <p>ADMINISTRACIÓN ACADÉMICA</p>
        </div>
        <!-- HORARIO -->
        <div class="table-responsive">
            <table class="table table-bordered table-condensed text-center">
                <tbody>
                    <tr class="active">
                        <td>H/D</td>
                        <td>Lunes</td>
                        <td>Martes</td>
                        <td>Miércoles</td>
                        <td>Jueves</td>
                        <td>Viernes</td>
                        <td>Sábado</td>
                    </tr>
                    @for ($i = 0; $i < count($tabla); $i++)
                        <tr>
                            <td class="id-size">
                                <p class="cero-margen">
                                    {{ 7 + $i }} - {{ 8 + $i }}
                                </p>
                            </td>
                            @for ($j = 0; $j < count($tabla[$i]); $j++))
                                @if ($tabla[$i][$j] != null)
                                    <td class="horario-size">
                                        <p class="cero-margen">
                                            {{ substr($tabla[$i][$j]->asignatura->nombre, 0, 20) }}
                                            <br>
                                            {{ substr($tabla[$i][$j]->actividad->nombre, 0, 20) }}
                                        </p>
                                    </td>
                                @else
                                    <td class="horario-size"></td>
                                @endif
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </body>
</html>