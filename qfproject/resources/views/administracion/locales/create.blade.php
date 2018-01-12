@extends('layouts.principal')

@section('titulo', 'Configuración | Nuevo local')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Nuevo local')

@section('breadcrumb')
    <li>
        <i class="fa fa-ticket icono-margen"></i>
        Configuración
    </li>
    <li>
        <a href="{{ route('locales.index') }}">
            Locales
        </a>
    </li>
    <li class="active">
        Nuevo local
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Nuevo local
            </h3>
        </div>
            <!-- FORMULARIO PARA CREAR UN NUEVO LOCAL -->
            {!! Form::open(['route' => 'locales.store', 'autocomplete' => 'off', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal']) !!}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                        {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('nombre', old('nombre'), ['class' => 'form-control', 'placeholder' => 'Nombre del local', 'required']) !!}
                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('nombre') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('capacidad') ? ' has-error' : '' }}">
                        {!! Form::label('capacidad', 'Capacidad', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::number('capacidad', old('capacidad'), ['class' => 'form-control', 'placeholder' => 'Capacidad del local', 'min' => '1', 'required']) !!}
                            @if ($errors->has('capacidad'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('capacidad') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('imagen') ? ' has-error' : '' }}">
                        {!! Form::label('imagen', 'Imagen', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::file('imagen', ['class' => 'margen-campo-imagen']) !!}
                            @if ($errors->has('imagen'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('imagen') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="{{ route('locales.index') }}" class="btn btn-default">
                            Cancelar
                        </a>
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE LOCALES -->
    @include('administracion.partials.info-locales')
@endsection