@extends('layouts.principal')

@section('titulo', 'Configuración | Nueva suspensión')

@section('encabezado', 'Configuración')

@section('subencabezado', 'Suspensiones')

@section('breadcrumb')
    
    <li><i class="fa fa-cog icono-margen"></i>Configuración</li>
    <li><a href="{{ route('suspensiones.index') }}">Suspensiones</a></li>
    <li class="active">Nueva suspensión</li>

@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Nueva suspensión</h3>
                </div>
                {!! Form::open(['route' => 'suspensiones.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
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
                            <a href="{{ route('suspensiones.index') }}" class="btn btn-default">Cancelar</a>
                            {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
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