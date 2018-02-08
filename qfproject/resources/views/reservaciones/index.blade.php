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
    <div>
        @if ($errors->has('seleccion'))
            <div class="alert alert-error alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
                <h4>
                    <i class="fa fa-ban icon" aria-hidden="true"></i>
                    ¡Error en ingreso de datos!
                </h4>
                <p class="ban">
                    {{ $errors->first('seleccion') }}
                </p>
            </div>
        @endif
    </div>
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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="marcar(this);">
                                </th>
                                <th>Local</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Usuario</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        {!! Form::open(['route' => 'reservaciones.destroy-multiple', 'method' => 'GET']) !!}
                            <tbody>
                                @foreach($reservaciones as $reservacion)
                                    <tr>
                                        <?php
                                            // Validación de acceso a las opciones.
                                            $acceso = false;
                                            switch ($reservacion->t) { 


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
                                                case 'Visitante':
                                                    $acceso = true;
                                                    break;
                                            }
                                        ?>
                                        <td>
                                            @if($acceso)
                                                <input type="checkbox" name="seleccion[]" value="{{ $reservacion->id }}">
                                            @endif
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
                                        <td class="opc-size">
                                            <a href="{{ route('reservaciones.show', $reservacion->id) }}" class="btn btn-default">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </a>
                                            @if($acceso)
                                                <a href="{{ route('reservaciones.edit', $reservacion->id) }}" class="btn btn-default">
                                                    <i class="fa fa-wrench" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('reservaciones.destroy', $reservacion->id) }}" class="btn btn-danger" onclick="return confirm('¿Deseas eliminar la reservación?')">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                            @else
                                                <a href="" class="btn btn-default disabled">
                                                    <i class="fa fa-wrench" aria-hidden="true"></i>
                                                </a>
                                                <a href="" class="btn btn-danger disabled">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Deseas eliminar las reservaciones seleccionadas?')">
                            Eliminar seleccionadas
                        </button>
                    </div>
                {!! Form::close() !!}
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

@push('scripts')
    <script type="text/javascript">
        function marcar(source) {
            checkboxes = document.getElementsByTagName('input');
            for (i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == "checkbox") {
                    checkboxes[i].checked = source.checked;
                }
            }
        }
    </script>
@endpush