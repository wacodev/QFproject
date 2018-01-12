@extends('layouts.principal')

@section('titulo', 'Configuración | Suspensiones')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Suspensiones')

@section('breadcrumb')
    <li>
        <i class="fa fa-cog icono-margen"></i>
        Configuración
    </li>
    <li class="active">
        Suspensiones
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Suspensiones
            </h3>
        </div>
        <div class="box-body">
            <!-- BARRA DE BÚSQUEDA Y BOTÓN PARA NUEVA SUSPENSIÓN -->
            @include('administracion.suspensiones.search')
            <!-- LISTADO DE SUSPENSIONES -->
            @if ($suspensiones->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover tabla-quitar-margen">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Hora de inicio</th>
                                <th>Hora de finalización</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suspensiones as $suspension)
                                <tr>
                                    <td class="id-size">
                                        {{ $suspension->id }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($suspension->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($suspension->hora_inicio)->format('h:i A') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($suspension->hora_fin)->format('h:i A') }}
                                    </td>
                                    <td class="opc-size">
                                        <a href="" data-target="#modal-delete-{{ $suspension->id }}" data-toggle="modal" class="btn btn-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- MODAL PARA CONFIRMAR ELIMINACIÓN DE SUSPENSIÓN -->
                                @include('administracion.suspensiones.modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="text-center">
                        <!-- PAGINACIÓN -->
                        {!! $suspensiones->render() !!}
                    </div>
                </div>
            <!-- MOSTRAR CUANDO NO HAY SUSPENSIONES -->
            @else
                <div class="text-center">
                    <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                    <h4 class="verde-claro">
                        No se encontraron suspensiones
                    </h4>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE SUSPENSIONES -->
    @include('administracion.partials.info-suspensiones')
@endsection