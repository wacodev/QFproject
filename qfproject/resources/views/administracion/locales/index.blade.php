@extends('layouts.principal')

@section('titulo', 'Configuración | Locales')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Locales')

@section('breadcrumb')
    
    <li><i class="fa fa-cog icono-margen"></i>Configuración</li>
    <li class="active">Locales</li>
    
@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Locales</h3>
                </div>
                <div class="box-body">
                    <div class="margen-abajo">
                        @include('administracion.locales.search')
                    </div>
                    @if ($locales->count() > 0)
                        @foreach($locales as $local)
                            <div class="thumbnail">
                                <div class="clearfix">
                                    @if ($local->imagen != null)
                                        <a href="{{ url('images/locales/' . $local->imagen) }}" target="_blanck" class="thumb pull-left">
                                            <img src="{{ asset('images/locales/' . $local->imagen) }}" alt="Imagen del local">
                                        </a>
                                    @else
                                        <a href="{{ url('images/locales/local_default.jpg') }}" target="_blanck" class="thumb pull-left">
                                            <img src="{{ asset('images/locales/local_default.jpg') }}" alt="Imagen del local">
                                        </a>
                                    @endif
                                    <h4><strong>{{ $local->nombre }}</strong></h4>
                                    <p><strong>Capacidad:</strong> {{ $local->capacidad }}</p>
                                </div>
                                <div class="btn-group btn-group-justified margen-arriba" role="group" aria-label="Opciones">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('locales.edit', $local) }}" class="btn btn-default icono-margen"><i class="fa fa-wrench icono-margen" aria-hidden="true"></i>Editar</a>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <a href="" data-target="#modal-delete-{{ $local->id }}" data-toggle="modal" class="btn btn-danger icono-margen"><i class="fa fa-trash icono-margen" aria-hidden="true"></i>Eliminar</a>
                                    </div>
                                </div>
                            </div>
                            @include('administracion.locales.modal')
                        @endforeach
                        <div class="box-footer clearfix">
                            <div class="text-center">
                                {!! $locales->render() !!}
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                            <h4 class="verde-claro">No se encontraron locales</h4>
                        </div>
                    @endif
                </div>     
            </div>
        </div>
    </div>

@endsection