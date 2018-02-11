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
        {!! Form::open(['route' => 'reservaciones.store', 'autocomplete' => 'off', 'method' => 'GET', 'class' => 'form-horizontal']) !!}
            {{ Form::token() }}
            <div class="box-body">
                <div class="form-group{{ $errors->has('asignatura_id') ? ' has-error' : '' }} select-margen">
                    {!! Form::label('asignatura_id', 'Asignatura', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7 input-group">
                        {!! Form::select('asignatura_id', $asignaturas, old('asignatura_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione una asignatura --', 'required']) !!}
                        <span class="input-group-btn">
                            <a href="" data-target="#modal-asignatura" data-toggle="modal" class="btn btn-default">
                                <i class="fa fa-plus"></i>
                            </a>
                        </span>
                        @if ($errors->has('asignatura_id'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('asignatura_id') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('actividad_id') ? ' has-error' : '' }} select-margen">
                    {!! Form::label('actividad_id', 'Actividad', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7 input-group">
                        {!! Form::select('actividad_id', $actividades, old('actividad_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione una actividad --', 'required']) !!}
                        <span class="input-group-btn">
                            <a href="" data-target="#modal-actividad" data-toggle="modal" class="btn btn-default">
                                <i class="fa fa-plus"></i>
                            </a>
                        </span>
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
                @if (Auth::user()->administrador() || Auth::user()->asistente())
                    <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                        {!! Form::label('user_id', 'Asignar a', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::select('user_id', $users, old('user_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione un usuario --']) !!}
                            @if ($errors->has('user_id'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('user_id') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
                @if (Auth::user()->visitante())
                <div class="form-group{{ $errors->has('responsable') ? ' has-error' : '' }}">
                    {!! Form::label('responsable', 'Responsable', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::text('responsable', old('responsable'), ['class' => 'form-control', 'placeholder' => 'Responsable de reserva', 'required']) !!}
                        @if ($errors->has('responsable'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('responsable') }}
                            </span>
                        @endif
                    </div>
                </div>
                @endif
                @foreach ($locales as $local)
                    {!! Form::hidden('l[]', $local) !!}
                @endforeach
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
        <!-- MODAL PARA AGREGAR UNA ACTIVIDAD -->
        @include('reservaciones.modal-actividad')
        <!-- MODAL PARA AGREGAR UNA ASIGNATURA -->
        @include('reservaciones.modal-asignatura')
    </div>
@endsection

@section('sidebar')
    @if (Auth::user()->administrador() || Auth::user()->asistente())
        <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA LAS RESERVACIONES -->
        @include('reservaciones.partials.herramientas')
    @endif
    <!-- AYUDA DE RESERVACIONES INDIVIDUALES -->
    @include('reservaciones.partials.info-reserva-individual')
@endsection