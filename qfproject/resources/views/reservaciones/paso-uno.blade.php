@extends('layouts.principal')

@section('titulo', 'Reservaciones | Nueva reservación')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Nueva reservación')

@section('breadcrumb')
    
    <li><i class="fa fa-ticket icono-margen"></i>Reservaciones</li>
    <li class="active">Nueva reservación</li>

@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Paso 1: Fecha y hora</h3>
                </div>
                {!! Form::open(['route' => 'reservaciones.paso-dos', 'autocomplete' => 'off', 'method' => 'GET', 'class' => 'form-horizontal']) !!}
                    {{ Form::token() }}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('fecha') ? ' has-error' : '' }}">
                            {!! Form::label('fecha', 'Fecha', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-7">
                                <input name="fecha" type="text" class="form-control" id="datepicker" value="{{ old('fecha') }}" required="true">
                                @if ($errors->has('fecha'))
                                    <span class="help-block">
                                        <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('fecha') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('hora_inicio') ? ' has-error' : '' }}">
                            {!! Form::label('hora_inicio', 'Hora de inicio', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-7">
                                <div class="bootstrap-timepicker">
                                    <input name="hora_inicio" type="text" class="form-control timepicker" value="{{ old('hora_inicio') }}" required="true">
                                </div>
                                @if ($errors->has('hora_inicio'))
                                    <span class="help-block">
                                        <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('hora_inicio') }}
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('hora_fin') ? ' has-error' : '' }}">
                            {!! Form::label('hora_fin', 'Hora de finalización', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-7">
                                <div class="bootstrap-timepicker">
                                    <input name="hora_fin" type="text" class="form-control timepicker" value="{{ old('hora_fin') }}" required="true">
                                </div>
                                @if ($errors->has('hora_fin'))
                                    <span class="help-block">
                                        <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('hora_fin') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            {!! Form::submit('Siguiente', ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @push('scripts')

        <script src="{{ asset('js/pickers-control.js') }}"></script>

    @endpush

@endsection