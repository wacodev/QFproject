@extends('layouts.principal')

@section('titulo', 'Acciones')

@section('encabezado', 'Acciones')

@section('breadcrumb')
    <li class="active">
        <i class="fa fa-flag icono-margen"></i>
        Acciones
    </li>
@endsection

@section('contenido-fila')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Registro de tus acciones
            </h3>
        </div>
        <div class="box-body">
            @if ($acciones->count() > 0)
            <p>
                <i class="fa fa-square icono-margen amarillo"></i>
                Reservaciones que no pudieron ser registradas
            </p>
            <p>
                <i class="fa fa-square icono-margen rojo"></i>
                Reservaciones que fueron eliminadas durante alguna acción que realizaste
            </p>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fa fa-trash icono-margen-izq" aria-hidden="true"></i>
                                </th>
                                <th>Usuario</th>
                                <th>Tipo</th>
                                <th>Local</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Asignatura</th>
                                <th>Actividad</th>
                                <th>Tema</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($acciones as $accion)
                                @if ($accion->data['tipo'] == 'no-registro')
                                    <tr class="warning">
                                @elseif ($accion->data['tipo'] == 'eliminar')
                                    <tr class="danger">
                                @endif
                                    <td>
                                        <a href="{{ route('acciones.destroy', $accion->id) }}" type="button" class="btn btn-box-tool">
                                            <span aria-hidden="true">
                                                <i class="fa fa-close" aria-hidden="true"></i>
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $accion->data['propietario']['name'] }} {{ $accion->data['propietario']['lastname'] }}
                                    </td>
                                    <td>
                                        {{ $accion->data['reservacion']['tipo'] }}
                                    </td>
                                    <td>
                                        {{ $accion->data['local']['nombre'] }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($accion->data['reservacion']['fecha'])->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($accion->data['reservacion']['hora_inicio'])->format('h:i A') }} - {{ \Carbon\Carbon::parse($accion->data['reservacion']['hora_fin'])->format('h:i A') }}
                                    </td>
                                    <td>
                                        {{ $accion->data['asignatura']['nombre'] }}
                                    </td>
                                    <td>
                                        {{ $accion->data['actividad']['nombre'] }}
                                    </td>
                                    <td>
                                        {{ $accion->data['reservacion']['tema'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <a href="{{ route('acciones.destroy-multiple') }}" class="btn btn-danger" onclick="return confirm('¿Deseas eliminar todos los registros de tus acciones?')">
                        Eliminar todos los registros
                    </a>
                </div>
            @else
                <div class="text-center">
                    <i class="fa fa-flag fa-5x verde-claro" aria-hidden="true"></i>
                    <h4 class="verde-claro">
                        No hay acciones
                    </h4>
                </div>
            @endif
        </div>
        <div class="box-footer">
            <div class="text-center">
                {!! $acciones->render() !!}
            </div>
        </div>
    </div>
    <?php
        // Marcar como leídas las notificaciones.
        $user = Auth::user();
        $user->unreadNotifications->where('type', '=', 'qfproject\Notifications\TareaNotification')->markAsRead();
    ?>
@endsection