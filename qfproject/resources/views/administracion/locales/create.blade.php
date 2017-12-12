@extends('layouts.principal')

@section('titulo', 'Configuración | Nuevo local')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Locales')

@section('breadcrumb')
    
    <li><i class="fa fa-cog icono-margen"></i>Configuración</li>
    <li><a href="{{ route('locales.index') }}">Locales</a></li>
    <li class="active">Nuevo local</li>

@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Nuevo local</h3>
                </div>
                    {!! Form::open(['route' => 'locales.store', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal']) !!}
                        {{ Form::token() }}
                        <div class="box-body">
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre del local']) !!}
                                    @if ($errors->has('nombre'))
                                        <span class="help-block">
                                            <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('nombre') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('capacidad', 'Capacidad', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::number('capacidad', null, ['class' => 'form-control', 'placeholder' => 'Capacidad del local', 'min' => '1']) !!}
                                    @if ($errors->has('capacidad'))
                                        <span class="help-block">
                                            <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('capacidad') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('imagen', 'Imagen', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::file('imagen', ['class' => 'margen-campo-imagen']) !!}
                                    @if ($errors->has('imagen'))
                                        <span class="help-block">
                                            <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('imagen') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                    	    <div class="pull-right">
                    	        <a href="{{ route('locales.index') }}" class="btn btn-default">Cancelar</a>
                    	        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                    	    </div>
                        </div>
                    {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection