@extends('layouts.principal')

@section('titulo', 'Configuración | Nueva asignatura')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Asignaturas')

@section('breadcrumb')
    <li>
        <i class="fa fa-cog icono-margen"></i>
        Configuración
    </li>
    <li>
        <a href="{{ route('asignaturas.index') }}">
            Asignaturas
        </a>
    </li>
    <li class="active">
        Nueva asignatura
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Nueva asignatura
            </h3>
        </div>
            <!-- FORMULARIO PARA CREAR UNA NUEVA ASIGNATURA -->
            {!! Form::open(['route' => 'asignaturas.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('codigo') ? ' has-error' : '' }}">
                        {!! Form::label('codigo', 'Código', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('codigo', old('codigo'), ['class' => 'form-control', 'placeholder' => 'Código de la asignatura', 'required']) !!}
                            @if ($errors->has('codigo'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('codigo') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                        {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('nombre', old('nombre'), ['class' => 'form-control', 'placeholder' => 'Nombre de la asignatura', 'required']) !!}
                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('nombre') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="{{ route('asignaturas.index') }}" class="btn btn-default">
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
    <!-- INFORMACIÓN ADICIONAL DE ASIGNATURAS -->
    @include('administracion.partials.info-asignaturas')
@endsection