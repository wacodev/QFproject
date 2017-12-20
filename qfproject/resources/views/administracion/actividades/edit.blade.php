@extends('layouts.principal')

@section('titulo', 'Configuración | Editar actividad')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Actividades')

@section('breadcrumb')
    
    <li><i class="fa fa-cog icono-margen"></i>Configuración</li>
    <li><a href="{{ route('actividades.index') }}">Actividades</a></li>
    <li class="active">Editar actividad</li>

@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Editar actividad: {{ $actividad->nombre }}</h3>
                </div>
                    {!! Form::open(['route' => ['actividades.update', $actividad], 'autocomplete' => 'off', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                        <div class="box-body">
                            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                                {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('nombre', $actividad->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre de la actividad', 'required']) !!}
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
                                <a href="{{ route('actividades.index') }}" class="btn btn-default">Cancelar</a>
                                {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection