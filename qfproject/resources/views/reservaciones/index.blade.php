@extends('layouts.principal')

@section('titulo', 'Reservaciones | Panel de administración')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Panel de administración')

@section('breadcrumb') 
    <li>
        <i class="fa fa-ticket icono-margen"></i>
        Reservaciones
    </li>
    <li class="active">
        Panel de administración
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Panel de administración
            </h3>
        </div>
        <div class="box-body">
            <!-- BARRA DE BÚSQUEDA -->
            {!! Form::open(array('url' => 'reservaciones', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search')) !!}
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
            <!-- LISTADO DE RESERVACIONES -->
            @if ($reservaciones->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover tabla-quitar-margen">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Local</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Usuario</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservaciones as $reservacion)
                                <tr>
                                    <td class="id-size">
                                        {{ $reservacion->id }}
                                    </td>
                                    <td>
                                        {{ $reservacion->local->nombre }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($reservacion->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('h:i A') }}
                                    </td>
                                    <td>
                                        {{ $reservacion->user->name }} {{ $reservacion->user->lastname }}
                                    </td>
                                    <?php
                                        // Validación de acceso a las opciones.
                                        $acceso = false;
                                        switch ($reservacion->user->tipo) {
                                            case 'Administrador':
                                                if (Auth::user()->id == $reservacion->user_id) {
                                                    $acceso = true;
                                                }
                                                break;
                                            case 'Asistente':
                                                if (Auth::user()->tipo == 'Administrador' || Auth::user()->id == $reservacion->user_id) {
                                                    $acceso = true;
                                                }
                                                break;
                                            case 'Docente':
                                                $acceso = true;
                                                break;
                                        }
                                    ?>
                                    <td class="opc-size">
                                        <a href="{{ route('reservaciones.show', $reservacion->id) }}" class="btn btn-default">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </a>
                                        @if($acceso)
                                            <a href="{{ route('reservaciones.edit', $reservacion->id) }}" class="btn btn-default">
                                                <i class="fa fa-wrench" aria-hidden="true"></i>
                                            </a>
                                            <a href="" data-target="#modal-delete-{{ $reservacion->id }}" data-toggle="modal" class="btn btn-danger">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-default disabled">
                                                <i class="fa fa-wrench" aria-hidden="true"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger disabled">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <!-- MODAL PARA CONFIRMAR ELIMINACIÓN DE ASIGNATURA -->
                                @include('reservaciones.modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            <!-- MOSTRAR CUANDO NO HAY ASIGNATURAS -->
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
                <!-- PAGINACIÓN -->
                {!! $reservaciones->render() !!}
            </div>
        </div>
    </div>     
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA LAS RESERVACIONES -->
    @include('reservaciones.partials.herramientas')
    <!-- AYUDA DEL PANEL DE ADMINISTRACIÓN DE RESERVACIONES -->
    @include('reservaciones.partials.info-panel')
@endsection