@extends('layouts.principal')

@section('titulo', 'Configuración | Editar asignatura')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Asignaturas')

@section('breadcrumb')
    
    <li><i class="fa fa-cog icono-margen"></i>Configuración</li>
    <li><a href="{{ route('asignaturas.index') }}">Asignaturas</a></li>
    <li class="active">Editar asignatura</li>

@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Editar asignatura: {{ $asignatura->nombre }}</h3>
                </div>
                    {!! Form::open(['route' => ['asignaturas.update', $asignatura], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                        {{ Form::token() }}
                        <div class="box-body">
                            <div class="form-group">
                                {!! Form::label('codigo', 'Código', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('codigo', $asignatura->codigo, ['class' => 'form-control', 'placeholder' => 'Código de la asignatura']) !!}
                                    @if ($errors->has('codigo'))
                                        <span class="help-block">
                                            <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('codigo') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('nombre', $asignatura->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre de la asignatura']) !!}
                                    @if ($errors->has('nombre'))
                                        <span class="help-block">
                                            <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('nombre') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                    	    <div class="pull-right">
                    	        <a href="{{ route('asignaturas.index') }}" class="btn btn-default">Cancelar</a>
                    	        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                    	    </div>
                        </div>
                    {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection