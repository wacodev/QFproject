@extends('layouts.principal')

@section('titulo', 'Reservaciones | Ver reservación')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Ver reservación')

@section('breadcrumb')
    <li>
        <i class="fa fa-ticket icono-margen"></i>
        Reservaciones
    </li>
    <li class="active">
        Ver reservación
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Ver reservación
            </h3>
        </div>
        <div class="box-body">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="btn-group pull-left icono-notificacion">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-caret-down fa-2x" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('reservacion.comprobante', $reservacion->id) }}">
                                    Comprobante
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reservaciones.edit', $reservacion->id) }}">
                                    Editar
                                </a>
                            </li>
                            <li>
                                <a href="" data-target="#modal-delete-{{ $reservacion->id }}" data-toggle="modal" >
                                    Eliminar
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="pull-left">
                        <a href="{{ url('images/locales/' . $reservacion->local->imagen) }}" target="_blanck">
                            <img src="{{ asset('images/locales/' . $reservacion->local->imagen) }}" class="img-circle img-miniatura" alt="Imagen del local">
                        </a>
                    </div>
                    <span class="text-muted pull-right">
                        <small>
                            <i class="fa fa-clock-o icono-margen" aria-hidden="true"></i>
                            {{ $reservacion->created_at->diffForHumans() }}
                        </small>
                    </span>
                    <h4 class="encabezado-notificacion">
                        Reservación {{ $reservacion->tipo }}
                    </h4>
                    <p>
                        <small>
                        Código:
                        {{ $reservacion->codigo }}
                        </small>
                    </p>
                    <div class="well well-sm well-panel well-parrafo">
                        <p>
                            <strong>
                                Local:
                            </strong>
                            {{ $reservacion->local->nombre }}
                        </p>
                        <p>
                            <strong>
                                Fecha y hora:
                            </strong>
                            {{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }} &nbsp;&#8226;&nbsp; {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('h:i A') }}
                        </p>
                        <p>
                            <strong>
                                Asignatura:
                            </strong>
                            {{ $reservacion->asignatura->nombre }} &nbsp;-&nbsp; ({{ $reservacion->asignatura->codigo }})
                        </p>
                        <p>
                            <strong>
                                Actividad:
                            </strong>
                            {{ $reservacion->actividad->nombre }}
                            @if ($reservacion->tema != null)
                                &nbsp;-&nbsp; {{ $reservacion->tema }}
                            @endif
                        </p>
                    </div>
                    
                </div>
            </div>
            <!-- MODAL PARA CONFIRMAR ELIMINACIÓN DE ASIGNATURA -->
            @include('reservaciones.modal')
        </div>
        <div class="box-footer">
            <div class="text-center">
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE USUARIOS -->
    @include('administracion.partials.info-usuarios')
@endsection