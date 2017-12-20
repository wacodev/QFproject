@extends('layouts.principal')

@section('titulo', 'Inicio')

@section('encabezado', 'Inicio')

@section('breadcrumb')
    
    <li class="active"><i class="fa fa-home icono-margen"></i>Inicio</li>

@endsection

@section('contenido')

    <div class="row">
        <div class="col-md-8">
        	<div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Mis reservaciones</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(array('url' => 'home', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search')) !!}
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="searchText", placeholder="Buscar", value="{{ $searchText }}"></input>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </span>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    @if ($reservaciones->count() > 0)
                        @foreach ($reservaciones as $reservacion)
                            <hr>
                            <span class="text-muted fecha-hora-c pull-right">
                                <i class="fa fa-clock-o" aria-hidden="true"></i> {{ \Carbon\Carbon::parse($reservacion->created_at)->format('d/m/Y | h:i A') }}
                            </span>
                            <h4><strong>Reservación: {{ $reservacion->codigo }}</strong></h4>
                            <p class="text-muted margen-inicio">
                                <strong>Local:</strong> {{ $reservacion->local->nombre }}
                            </p>
                            <p class="text-muted margen-inicio">
                                <strong>Fecha y hora:</strong> {{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }} | {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('h:i A') }}
                            </p>
                            <p class="text-muted margen-inicio">
                                <strong>Asignatura:</strong> [{{ $reservacion->asignatura->codigo }}] {{ $reservacion->asignatura->nombre }}
                            </p>
                            <p class="text-muted">
                                <strong>Actividad:</strong> {{ $reservacion->actividad->nombre }}
                                    @if ($reservacion->tema != null)
                                        | {{ $reservacion->tema }}
                                    @endif
                            </p>
                            <div class="btn-group btn-group-justified" role="group">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('reservacion.comprobante', $reservacion->id) }}" class="btn btn-default"><i class="fa fa-download icono-margen" aria-hidden="true"></i>Comprobante</a>
                                </div>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('reservaciones.edit', $reservacion->id) }}" class="btn btn-default"><i class="fa fa-wrench icono-margen" aria-hidden="true"></i>Editar</a>
                                </div>
                                <div class="btn-group" role="group">
                                    <a href="" data-target="#modal-delete-{{ $reservacion->id }}" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash icono-margen" aria-hidden="true"></i>Eliminar</a>
                                </div>
                            </div>
                            @include('reservaciones.modal')
                        @endforeach
                        <div class="box-footer clearfix">
                            <div class="text-center">
                                {!! $reservaciones->render() !!}
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                            <h4 class="verde-claro">No se encontraron reservaciones</h4>
                        </div>
                    @endif
                </div>     
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ asset('images/users/default_profile.jpg') }}" alt="Imagen de usuario">
                    <h3 class="profile-username text-center">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</h3>
                    <p class="text-muted text-center">{{ Auth::user()->tipo }}</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Carnet</b> <p class="pull-right">{{ Auth::user()->carnet }}</p>
                        </li>
                        <li class="list-group-item">
                            <b>Correo electrónico</b> <p class="pull-right">{{ Auth::user()->email }}</p>
                        </li>
                    </ul>
                    <a href="{{ route('reservaciones.paso-uno') }}" class="btn btn-success btn-block">Nueva reservación</a>
                    <a href="#" class="btn btn-default btn-block">Editar perfil</a>
                </div>
            </div>
        </div>
    </div>
@endsection