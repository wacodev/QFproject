@extends('layouts.principal')

@section('titulo', 'Configuración | Asignaturas')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Asignaturas')

@section('breadcrumb') 
    <li>
        <i class="fa fa-cog icono-margen"></i>
            Configuración
        </li>
    <li class="active">
        Asignaturas
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Asignaturas
            </h3>
        </div>
        <div class="box-body">
            <!-- BARRA DE BÚSQUEDA Y BOTÓN PARA NUEVA ASIGNATURA -->
            @include('administracion.asignaturas.search')
            <!-- LISTADO DE ASIGNATURAS -->
            @if ($asignaturas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover tabla-quitar-margen">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asignaturas as $asignatura)
                                <tr>
                                    <td class="id-size">
                                        {{ $asignatura->id }}
                                    </td>
                                    <td class="codigo-size">
                                        {{ $asignatura->codigo }}
                                    </td>
                                    <td>
                                        {{ $asignatura->nombre }}
                                    </td>
                                    <td class="opc-size">
                                        <a href="{{ route('asignaturas.edit', $asignatura->id) }}" class="btn btn-default">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                        <a href="" data-target="#modal-delete-{{ $asignatura->id }}" data-toggle="modal" class="btn btn-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- MODAL PARA CONFIRMAR ELIMINACIÓN DE ASIGNATURA -->
                                @include('administracion.asignaturas.modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            <!-- MOSTRAR CUANDO NO HAY ASIGNATURAS -->
            @else
                <div class="text-center">
                    <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                    <h4 class="verde-claro">
                        No se encontraron asignaturas
                    </h4>
                </div>
            @endif
        </div>     
        <div class="box-footer">
            <div class="text-center">
                <!-- PAGINACIÓN -->
                {!! $asignaturas->render() !!}
            </div>
        </div>
    </div>     
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE ASIGNATURAS -->
    @include('administracion.partials.info-asignaturas')
@endsection