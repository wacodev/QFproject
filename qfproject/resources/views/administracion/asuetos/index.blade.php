@extends('layouts.principal')

@section('titulo', 'Configuración | Asuetos')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Asuetos')

@section('breadcrumb')
    
    <li><i class="fa fa-cog icono-margen"></i>Configuración</li>
    <li class="active">Asuetos</li>
    
@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Asuetos</h3>
                </div>
                <div class="box-body">
                    @include('administracion.asuetos.search')
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
                                            <td class="id-size" style="vertical-align: middle;">{{ $asueto->id }}</td>
                                            <td class="fecha-size" style="vertical-align: middle;">{{ $asueto->dia }}/{{ $asueto->mes }}</td>
                                            <td style="vertical-align: middle;">{{ $asueto->nombre }}</td>
                                            <td class="opc-size">
                                                <div class="btn-group btn-group-justified" role="group">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('asuetos.edit', $asueto->id) }}" class="btn btn-default"><i class="fa fa-wrench icono-margen" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <a href="" data-target="#modal-delete-{{ $asueto->id }}" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('administracion.asuetos.modal')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="text-center">
                                {!! $asuetos->render() !!}
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                            <h4 class="verde-claro">No se encontraron asuetos</h4>
                        </div>
                    @endif
                </div>     
            </div>
        </div>
    </div>

@endsection