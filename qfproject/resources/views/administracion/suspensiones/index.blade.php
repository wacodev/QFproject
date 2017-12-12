@extends('layouts.principal')

@section('titulo', 'Configuración | Suspensiones')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Suspensiones')

@section('breadcrumb')
    
    <li><i class="fa fa-cog icono-margen"></i>Configuración</li>
    <li class="active">Suspensiones</li>
    
@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Suspensiones</h3>
                </div>
                <div class="box-body">
                    @include('administracion.suspensiones.search')
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
                                            <td class="id-size" style="vertical-align: middle;">{{ $suspension->id }}</td>
                                            <td style="vertical-align: middle;">{{ \Carbon\Carbon::parse($suspension->fecha)->format('d/m/Y') }}</td>
                                            <td style="vertical-align: middle;">{{ \Carbon\Carbon::parse($suspension->hora_inicio)->format('h:i A') }}</td>
                                            <td style="vertical-align: middle;">{{ \Carbon\Carbon::parse($suspension->hora_fin)->format('h:i A') }}</td>
                                            <td class="opc-size">
                                                <div class="btn-group btn-group-justified" role="group">
                                                    <div class="btn-group" role="group">
                                                        <a href="" data-target="#modal-delete-{{ $suspension->id }}" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('administracion.suspensiones.modal')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="text-center">
                                {!! $suspensiones->render() !!}
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                            <h4 class="verde-claro">No se encontraron suspensiones</h4>
                        </div>
                    @endif
                </div>     
            </div>
        </div>
    </div>

@endsection