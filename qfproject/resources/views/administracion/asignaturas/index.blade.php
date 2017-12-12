@extends('layouts.principal')

@section('titulo', 'Configuración | Asignaturas')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Asignaturas')

@section('breadcrumb')
    
    <li><i class="fa fa-cog icono-margen"></i>Configuración</li>
    <li class="active">Asignaturas</li>
    
@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Asignaturas</h3>
                </div>
                <div class="box-body">
                    @include('administracion.asignaturas.search')
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
                                            <td class="id-size" style="vertical-align: middle;">{{ $asignatura->id }}</td>
                                            <td class="codigo-size" style="vertical-align: middle;">{{ $asignatura->codigo }}</td>
                                            <td style="vertical-align: middle;">{{ $asignatura->nombre }}</td>
                                            <td class="opc-size">
                                                <div class="btn-group btn-group-justified" role="group">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('asignaturas.edit', $asignatura->id) }}" class="btn btn-default"><i class="fa fa-wrench" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <a href="" data-target="#modal-delete-{{ $asignatura->id }}" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('administracion.asignaturas.modal')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="text-center">
                                {!! $asignaturas->render() !!}
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                            <h4 class="verde-claro">No se encontraron asignaturas</h4>
                        </div>
                    @endif
                </div>     
            </div>
        </div>
    </div>

@endsection