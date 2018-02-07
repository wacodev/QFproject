@extends('layouts.principal')

@section('titulo', 'Notificaciones')

@section('encabezado', 'Notificaciones')

@section('breadcrumb')
    <li class="active">
        <i class="fa fa-bell icono-margen"></i>
        Notificaciones
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Notificaciones
            </h3>
        </div>
        <div class="box-body">
            @if ($notificaciones->count() > 0)
                @foreach ($notificaciones as $notificacion)
                    @if ($notificacion->read_at)
                        <div class="panel panel-default">
                    @else
                        <div class="panel panel-default panel-sin-leer">
                    @endif
                        <div class="panel-body">
                            <div class="pull-left icono-notificacion">
                                @if ($notificacion->data['tipo'] == 'crear')
                                    <i class="fa fa-ticket fa-2x icono-success" aria-hidden="true"></i>
                                @elseif ($notificacion->data['tipo'] == 'editar')
                                    <i class="fa fa-wrench fa-2x icono-primary" aria-hidden="true"></i>
                                @elseif ($notificacion->data['tipo'] == 'eliminar')
                                    <i class="fa fa-trash fa-2x icono-danger" aria-hidden="true"></i>
                                @endif
                            </div>
                            <div class="pull-left">
                                <a href="{{ url('images/users/' . $notificacion->data['user']['imagen']) }}" target="_blanck">
                                    <img src="{{ asset('images/users/' . $notificacion->data['user']['imagen']) }}" class="img-circle img-miniatura" alt="Imagen de usuario">
                                </a>
                            </div>
                            <span class="text-muted pull-right">
                                <small>
                                    <i class="fa fa-clock-o icono-margen" aria-hidden="true"></i>
                                    <span class="icono-margen">
                                        {{ $notificacion->created_at->diffForHumans() }}
                                    </span>
                                </small>
                                <!-- ELIMINAR NOTIFICACIÓN -->
                                <a href="{{ route('notificaciones.destroy', $notificacion->id) }}" type="button" class="btn btn-box-tool">
                                    <span aria-hidden="true">
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </span>
                            <h4 class="encabezado-notificacion">
                                {{ $notificacion->data['user']['name'] . ' ' . $notificacion->data['user']['lastname'] }}
                            </h4>
                            <p>
                                {{ $notificacion->data['mensaje'] }}
                            </p>
                            <div class="well well-sm well-panel well-parrafo">
                                <p>
                                    <strong>
                                        Tipo de reservación:
                                    </strong>
                                    {{ $notificacion->data['reservacion']['tipo'] }}
                                </p>
                                <p>
                                    <strong>
                                        Código:
                                    </strong>
                                    {{ $notificacion->data['reservacion']['codigo'] }}
                                </p>
                                <p>
                                    <strong>
                                        Realizada por:
                                    </strong>
                                    {{ $notificacion->data['propietario']['name'] }} {{ $notificacion->data['propietario']['lastname'] }}
                                </p>
                                <p>
                                    <strong>
                                        Local:
                                    </strong>
                                    {{ $notificacion->data['local']['nombre'] }}
                                </p>
                                <p>
                                    <strong>
                                        Fecha y hora:
                                    </strong>
                                    {{ \Carbon\Carbon::parse($notificacion->data['reservacion']['fecha'])->format('d/m/Y') }} &nbsp;&#8226;&nbsp; {{ \Carbon\Carbon::parse($notificacion->data['reservacion']['hora_inicio'])->format('h:i A') }} - {{ \Carbon\Carbon::parse($notificacion->data['reservacion']['hora_fin'])->format('h:i A') }}
                                </p>
                                <p>
                                    <strong>
                                        Asignatura:
                                    </strong>
                                    {{ $notificacion->data['asignatura']['nombre'] }} &nbsp;-&nbsp; ({{ $notificacion->data['asignatura']['codigo'] }})
                                </p>
                                <p>
                                    <strong>
                                        Actividad:
                                    </strong>
                                    {{ $notificacion->data['actividad']['nombre'] }}
                                    @if ($notificacion->data['reservacion']['tema'] != null)
                                        &nbsp;-&nbsp; {{ $notificacion->data['reservacion']['tema'] }}
                                    @endif
                                </p>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center">
                    <i class="fa fa-bell-slash fa-5x verde-claro" aria-hidden="true"></i>
                    <h4 class="verde-claro">
                        No hay notificaciones
                    </h4>
                </div>
            @endif
        </div>
        <div class="box-footer">
            <div class="text-center">
                {!! $notificaciones->render() !!}
            </div>
        </div>
    </div>
    <?php
        // Marcar como leídas las notificaciones.
        $user = Auth::user();
        $user->unreadNotifications->where('type', '=', 'qfproject\Notifications\ReservacionNotification')->markAsRead();
    ?>
@endsection

@section('sidebar')
    <!-- PANEL DEL PERFIL DE USUARIO -->
    @include('layouts.perfil')
@endsection