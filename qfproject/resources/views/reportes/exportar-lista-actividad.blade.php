@extends('layouts.principal')

@section('titulo', 'Reportes | Listado de reservaciones por actividad')

@section('estilos')
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}" />
@endsection

@section('encabezado', 'Reportes')

@section('subencabezado', 'Listado de reservaciones por actividad')

@section('breadcrumb')
    <li>
        <i class="fa fa-file-text icono-margen"></i>
        Reportes
    </li>
    <li class="active">
        Listado de reservaciones por actividad
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Listado de reservaciones por actividad
            </h3>
        </div>
        {!! Form::open(['route' => 'reportes.lista-actividad', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group{{ $errors->has('fecha') ? ' has-error' : '' }}">
                    {!! Form::label('fecha', 'Rango de fechas', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        <input name="fecha" type="text" class="form-control pull-right" id="reservation" required="true" placeholder="mm/dd/yyyy - mm/dd/yyyy">
                        @if ($errors->has('fecha'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('fecha') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('asignatura_id') ? ' has-error' : '' }}">
                    {!! Form::label('asignatura_id', 'Asignatura', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::select('asignatura_id', $asignaturas, old('asignatura_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione una asignatura --']) !!}
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
                        {!! Form::select('actividad_id', $actividades, old('actividad_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione una asignatura --']) !!}
                        @if ($errors->has('actividad_id'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('actividad_id') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <a href="{{ route('reservaciones.index') }}" class="btn btn-default">
                        Cancelar
                    </a>
                    {!! Form::submit('Aceptar', ['class' => 'btn btn-success']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <!-- DATE RANGE PICKER -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <!-- CONTROL PICKER -->
    <script>
        $(function ()
        {            
            //Date range picker
            $('#reservation').daterangepicker()
        })
    </script>
@endpush