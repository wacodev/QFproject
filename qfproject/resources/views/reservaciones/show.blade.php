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
        <div class="box-body box-profile">
            <div class="text-center">
                <a href="{{ url('images/locales/' . $reservacion->local->imagen) }}" target="_blanck">
                    <img src="{{ asset('images/locales/' . $reservacion->local->imagen) }}" class="img-local" alt="Imagen del local">
                </a>
            </div>
            <br>
            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <strong>
                        Tipo
                    </strong>
                    <p class="pull-right">
                        {{ $reservacion->tipo }}
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Código
                    </strong>
                    <p class="pull-right">
                        {{ $reservacion->codigo }}
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Responsable
                    </strong>
                    <p class="pull-right">
                        @if ($reservacion->responsable)
                            {{ $reservacion->responsable }}
                        @else
                            {{ $reservacion->user->name }} {{ $reservacion->user->lastname }}
                        @endif
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Local
                    </strong>
                    <p class="pull-right">
                        {{ $reservacion->local->nombre }}
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Fecha
                    </strong>
                    <p class="pull-right">
                        {{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }}
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Hora
                    </strong>
                    <p class="pull-right">
                        {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('h:i A') }}
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Asignatura
                    </strong>
                    <p class="pull-right">
                        ({{ $reservacion->asignatura->codigo }}) &nbsp;-&nbsp; {{ $reservacion->asignatura->nombre }}
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Actividad
                    </strong>
                    <p class="pull-right">
                        {{ $reservacion->actividad->nombre }}
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Tema
                    </strong>
                    <p class="pull-right">
                        {{ $reservacion->tema }}
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Fecha y hora de registro
                    </strong>
                    <p class="pull-right">
                        {{ \Carbon\Carbon::parse($reservacion->created_at)->format('d/m/Y - h:i A') }}
                    </p>
                </li>
                <li class="list-group-item">
                    <strong>
                        Última actualización
                    </strong>
                    <p class="pull-right">
                        {{ \Carbon\Carbon::parse($reservacion->updated_at)->format('d/m/Y - h:i A') }}
                    </p>
                </li>
            </ul>
        </div>
        <div class="box-footer text-center">
            <a href="{{ route('reservacion.comprobante', $reservacion->id) }}" class="btn btn-success">
                Comprobante
            </a>
        </div>
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA LAS RESERVACIONES -->
    @include('reservaciones.partials.herramientas')
    <!-- AYUDA DEL PANEL DE ADMINISTRACIÓN DE RESERVACIONES -->
    @include('reservaciones.partials.info-panel')
@endsection