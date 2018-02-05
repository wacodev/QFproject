@extends('layouts.principal')

@section('titulo', 'Configuración | Asuetos')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Asuetos')

@section('breadcrumb')
    <li>
        <i class="fa fa-cog icono-margen"></i>
        Configuración
    </li>
    <li class="active">
        Asuetos
    </li>
@endsection

@section('contenido')   
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Asuetos
            </h3>
        </div>
        <div class="box-body">
            <!-- BARRA DE BÚSQUEDA Y BOTÓN PARA NUEVO ASUETO -->
            @include('administracion.asuetos.search')
            <!-- LISTADO DE ASUETOS -->
            @if ($asuetos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover tabla-quitar-margen">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asuetos as $asueto)
                                <tr>
                                    <td class="id-size">
                                        {{ $asueto->id }}
                                    </td>
                                    <td class="fecha-size">
                                        {{ $asueto->dia }}/{{ $asueto->mes }}
                                    </td>
                                    <td>
                                        {{ $asueto->nombre }}
                                    </td>
                                    <td class="opc-size">
                                        <a href="{{ route('asuetos.edit', $asueto->id) }}" class="btn btn-default">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                        <a href="" data-target="#modal-delete-{{ $asueto->id }}" data-toggle="modal" class="btn btn-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- MODAL PARA CONFIRMAR ELIMINACIÓN DE ASUETO -->
                                @include('administracion.asuetos.modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            <!-- MOSTRAR CUANDO NO HAY ASUETOS -->
            @else
                <div class="text-center">
                    <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                    <h4 class="verde-claro">
                        No se encontraron asuetos
                    </h4>
                </div>
            @endif
        </div>     
        <div class="box-footer">
            <div class="text-center">
                <!-- PAGINACIÓN -->
                {!! $asuetos->render() !!}
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA ASUETOS -->
    @include('administracion.partials.herr-asuetos')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE ASUETOS -->
    @include('administracion.partials.info-asuetos')
@endsection