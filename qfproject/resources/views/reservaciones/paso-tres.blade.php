@extends('layouts.principal')

@section('titulo', 'Reservaciones | Nueva reservación')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Nueva reservación')

@section('breadcrumb')
    <li>
        <i class="fa fa-ticket icono-margen"></i>
        Reservaciones
    </li>
    <li class="active">
        Nueva reservación
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Paso 3: Detalles
            </h3>
        </div>
        {!! Form::open(['route' => 'reservaciones.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group{{ $errors->has('asignatura_id') ? ' has-error' : '' }}">
                    {!! Form::label('asignatura_id', 'Asignatura', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::select('asignatura_id', $asignaturas, old('asignatura_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione una asignatura --', 'required']) !!}
                        @if ($errors->has('asignatura_id'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('asignatura_id') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('actividad_id') ? ' has-error' : '' }}">
                    {!! Form::label('actividad_id', 'Actividad', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::select('actividad_id', $actividades, old('actividad_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione una actividad --', 'required']) !!}
                        @if ($errors->has('actividad_id'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('actividad_id') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tema') ? ' has-error' : '' }}">
                    {!! Form::label('tema', 'Tema', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::text('tema', old('tema'), ['class' => 'form-control', 'placeholder' => 'Tema a desarrollar']) !!}
                        @if ($errors->has('tema'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('tema') }}
                            </span>
                        @endif
                    </div>
                </div>
                {!! Form::hidden('local_id', $reservacion->local_id) !!}
                {!! Form::hidden('fecha', $reservacion->fecha) !!}
                {!! Form::hidden('hora_inicio', $reservacion->hora_inicio) !!}
                {!! Form::hidden('hora_fin', $reservacion->hora_fin) !!}
                {!! Form::hidden('tipo', $reservacion->tipo) !!}
            </div>
            <div class="box-footer">
        	    <div class="pull-right">
        	        <a href="{{ route('reservaciones.paso-uno') }}" class="btn btn-default">
                        Cancelar
                    </a>
        	        {!! Form::submit('Reservar', ['class' => 'btn btn-success']) !!}
        	    </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pickers-control.js') }}"></script>
@endpush