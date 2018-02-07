@extends('layouts.principal')

@section('titulo', 'Acciones')

@section('encabezado', 'Acciones')

@section('breadcrumb')
    <li class="active">
        <i class="fa fa-flag icono-margen"></i>
        Acciones
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Acciones
            </h3>
        </div>
        <div class="box-body">
            @if ($acciones->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover tabla-quitar-margen">
                        <thead>
                            <tr>
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

@section('sidebar')
    <!-- PANEL DEL PERFIL DE USUARIO -->
    @include('layouts.perfil')
@endsection