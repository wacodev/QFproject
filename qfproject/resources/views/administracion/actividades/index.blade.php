@extends('layouts.principal')

@section('titulo', 'Configuración | Actividades')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Actividades')

@section('breadcrumb')
    <li>
        <i class="fa fa-cog icono-margen"></i>
        Configuración
    </li>
    <li class="active">
        Actividades
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Actividades
            </h3>
        </div>
        <div class="box-body">
            <!-- BARRA DE BÚSQUEDA Y BOTÓN PARA NUEVA ACTIVIDAD -->
            @include('administracion.actividades.search')
            <!-- LISTADO DE ACTIVIDADES -->
            @if ($actividades->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover tabla-quitar-margen">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($actividades as $actividad)
                                <tr>
                                    <td class="id-size">
                                        {{ $actividad->id }}
                                    </td>
                                    <td>
                                        {{ $actividad->nombre }}
                                    </td>
                                    <td class="opc-size">
                                        <a href="{{ route('actividades.edit', $actividad->id) }}" class="btn btn-default">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                        <a href="" data-target="#modal-delete-{{ $actividad->id }}" data-toggle="modal" class="btn btn-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- MODAL PARA CONFIRMAR ELIMINACIÓN DE ACTIVIDAD -->
                                @include('administracion.actividades.modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            <!-- MOSTRAR CUANDO NO HAY ACTIVIDADES -->
            @else
                <div class="text-center">
                    <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                    <h4 class="verde-claro">
                        No se encontraron actividades
                    </h4>
                </div>
            @endif
        </div>     
        <div class="box-footer">
            <div class="text-center">
                <!-- PAGINACIÓN -->
                {!! $actividades->render() !!}
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE ACTIVIDADES -->
    @include('administracion.partials.info-actividades')
@endsection