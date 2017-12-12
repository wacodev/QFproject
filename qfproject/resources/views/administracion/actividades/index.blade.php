@extends('layouts.principal')

@section('titulo', 'Configuración | Actividades')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Actividades')

@section('breadcrumb')
    
    <li><i class="fa fa-cog icono-margen"></i>Configuración</li>
    <li class="active">Actividades</li>

@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Actividades</h3>
                </div>
                <div class="box-body">
                    @include('administracion.actividades.search')
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
                                            <td class="id-size" style="vertical-align: middle;">{{ $actividad->id }}</td>
                                            <td style="vertical-align: middle;">{{ $actividad->nombre }}</td>
                                            <td class="opc-size">
                                                <div class="btn-group btn-group-justified" role="group">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('actividades.edit', $actividad->id) }}" class="btn btn-default"><i class="fa fa-wrench icono-margen" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <a href="" data-target="#modal-delete-{{ $actividad->id }}" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('administracion.actividades.modal')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="text-center">
                                {!! $actividades->render() !!}
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                            <h4 class="verde-claro">No se encontraron actividades</h4>
                        </div>
                    @endif
                </div>     
            </div>
        </div>
    </div>

@endsection