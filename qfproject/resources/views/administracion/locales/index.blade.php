@extends('layouts.principal')

@section('titulo', 'Configuración | Locales')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Locales')

@section('breadcrumb')
    <li>
        <i class="fa fa-cog icono-margen"></i>
        Configuración
    </li>
    <li class="active">
        Locales
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Locales
            </h3>
        </div>
        <div class="box-body">
            <!-- BARRA DE BÚSQUEDA Y BOTÓN PARA NUEVO LOCAL -->
            @include('administracion.locales.search')
            <!-- LISTADO DE LOCALES -->
            @if ($locales->count() > 0)
                @foreach($locales as $local)
                    <div class="clearfix">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="img-local pull-left">
                                    <a href="{{ url('images/locales/' . $local->imagen) }}" target="_blanck">
                                        <img src="{{ asset('images/locales/' . $local->imagen) }}" alt="Imagen del local">
                                    </a>
                                </div>
                                <h4 class="encabezado-notificacion">
                                    {{ $local->nombre }}
                                </h4>
                                <p>
                                    <strong>
                                        ID:
                                    </strong>
                                    {{ $local->id }}
                                    &nbsp;&#8226;&nbsp;
                                    <strong>
                                        Capacidad:
                                    </strong>
                                    {{ $local->capacidad }}
                                </p>
                                <a href="{{ route('locales.edit', $local) }}" class="btn btn-default icono-margen">
                                    <i class="fa fa-wrench icono-margen" aria-hidden="true"></i>
                                    Editar
                                </a>
                                <a href="" data-target="#modal-delete-{{ $local->id }}" data-toggle="modal" class="btn btn-danger icono-margen">
                                    <i class="fa fa-trash icono-margen" aria-hidden="true"></i>
                                    Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- MODAL PARA CONFIRMAR ELIMINACIÓN DE ACTIVIDAD -->
                    @include('administracion.locales.modal')
                @endforeach
            <!-- MOSTRAR CUANDO NO HAY LOCALES -->
            @else
                <div class="text-center">
                    <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                    <h4 class="verde-claro">No se encontraron locales</h4>
                </div>
            @endif
        </div>     
        <div class="box-footer">
            <div class="text-center">
                <!-- PAGINACIÓN -->
                {!! $locales->render() !!}
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE LOCALES -->
    @include('administracion.partials.info-locales')
@endsection