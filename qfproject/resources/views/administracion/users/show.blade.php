@extends('layouts.principal')

@section('titulo', 'Usuarios | Ver usuario')

@section('encabezado', 'Usuarios')

@section('subencabezado', 'Ver usuario')

@section('breadcrumb')
    <li>
        <i class="fa fa-users icono-margen"></i>
        <a href="{{ route('users.index') }}">
            Usuarios
        </a>
    </li>
    <li class="active">
        Ver usuario
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-body box-profile">
            <a href="{{ url('images/users/' . $user->imagen) }}" target="_blanck">
                <img src="{{ asset('images/users/' . $user->imagen) }}" class="profile-user-img img-responsive img-circle" alt="Imagen de usuario">
            </a>
            <h3 class="profile-username text-center">
                {{ $user->name }} {{ $user->lastname }}
            </h3>
            <p class="text-muted text-center">
                {{ $user->tipo }}
            </p>
            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <strong>
                        ID
                    </strong>
                    <p class="pull-right">
                        {{ $user->id }}
                    </p>
                </li>
               
                <li class="list-group-item">
                    <strong>
                        Correo electrónico
                    </strong>
                    <p class="pull-right">
                        {{ $user->email }}
                    </p>
                </li>
            </ul>
        </div>
    </div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Reservaciones vigentes
            </h3>
        </div>
        <div class="box-body">
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
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE USUARIOS -->
    @include('administracion.partials.info-usuarios')
@endsection