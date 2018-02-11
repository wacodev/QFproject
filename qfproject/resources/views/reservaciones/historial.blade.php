@extends('layouts.principal')

@section('titulo', 'Historial')

@section('encabezado', 'Historial')

@section('breadcrumb')
    <li class="active">
        <i class="fa fa-clock-o icono-margen"></i>
        Historial
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Historial de reservaciones
            </h3>
        </div>
        <div class="box-body">
            {!! Form::open(array('url' => 'reservaciones/historial', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search')) !!}
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="searchText", placeholder="Buscar", value="{{ $searchText }}"></input>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </div>
            {!! Form::close() !!}
            @if ($reservaciones->count() > 0)
                @foreach ($reservaciones as $reservacion)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="btn-group pull-left icono-notificacion">
                                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-caret-down fa-2x" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('reservacion.comprobante', $reservacion->id) }}" target="_blanck">
                                            Comprobante
                                        </a>
                                    </li>
                                    @if ($reservacion->fecha >= $hoy)
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
                                    @endif
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
                                    Código: {{ $reservacion->codigo }}
                                </small>
                                @if ($reservacion->fecha >= $hoy)
                                    <label class="label label-success">
                                        Vigente
                                    </label>
                                @else
                                    <label class="label label-danger">
                                        Prescrita
                                    </label>
                                @endif
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
                @endforeach
            @else
                <div class="text-center">
                    <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                    <h4 class="verde-claro">
                        No se encontraron reservaciones
                    </h4>
                </div>
            @endif
        </div>
        <div class="box-footer">
            <div class="text-center">
                {!! $reservaciones->render() !!}
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <!-- PANEL DEL PERFIL DE USUARIO -->
    @include('layouts.perfil')
    <!-- AYUDA DE HISTORIAL -->
    @include('reservaciones.partials.info-historial')
@endsection