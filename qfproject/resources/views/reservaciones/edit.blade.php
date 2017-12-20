@extends('layouts.principal')

@section('titulo', 'Reservaciones | Editar reservación')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Editar reservación')

@section('breadcrumb')
    
    <li><i class="fa fa-ticket icono-margen"></i>Reservaciones</li>
    <li class="active">Editar reservación</li>

@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Editar reservación: {{ $reservacion->codigo }}</h3>
                </div>
                    {!! Form::open(['route' => ['reservaciones.update', $reservacion], 'autocomplete' => 'off', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                        <div class="box-body">
                            <div class="form-group{{ $errors->has('asignatura_id') ? ' has-error' : '' }}">
                            {!! Form::label('asignatura_id', 'Asignatura', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-7">
                                {!! Form::select('asignatura_id', $asignaturas, $reservacion->asignatura_id, ['class' => 'form-control', 'placeholder' => '-- Seleccione una asignatura --', 'required']) !!}
                                @if ($errors->has('asignatura_id'))
                                    <span class="help-block">
                                        <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('asignatura_id') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('actividad_id') ? ' has-error' : '' }}">
                            {!! Form::label('actividad_id', 'Actividad', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-7">
                                {!! Form::select('actividad_id', $actividades, $reservacion->actividad_id, ['class' => 'form-control', 'placeholder' => '-- Seleccione una actividad --', 'required']) !!}
                                @if ($errors->has('actividad_id'))
                                    <span class="help-block">
                                        <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('actividad_id') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('tema') ? ' has-error' : '' }}">
                            {!! Form::label('tema', 'Tema', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-7">
                                {!! Form::text('tema', $reservacion->tema, ['class' => 'form-control', 'placeholder' => 'Tema a desarrollar']) !!}
                                @if ($errors->has('tema'))
                                    <span class="help-block">
                                        <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('tema') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
                            {!! Form::label('tipo', 'Tipo de reservación', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-7">
                                {!! Form::select('tipo', [
                                    'Ordinaria' => 'Ordinaria',
                                    'Extraordinaria'     => 'Extraordinaria'
                                    ], $reservacion->tipo, ['class' => 'form-control', 'placeholder' => '-- Seleccione el tipo de reservación --']) !!}
                                @if ($errors->has('tipo'))
                                    <span class="help-block">
                                        <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('tipo') }}
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