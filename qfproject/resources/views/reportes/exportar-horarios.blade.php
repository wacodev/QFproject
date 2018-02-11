@extends('layouts.principal')

@section('titulo', 'Reportes | Horarios')

@section('estilos')
    <!-- BOOTSTRAP DATE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
@endsection

@section('encabezado', 'Reportes')

@section('subencabezado', 'Horarios')

@section('breadcrumb')
    <li>
        <i class="fa fa-file-text icono-margen"></i>
        Reportes
    </li>
    <li class="active">
        Horarios
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Horarios
            </h3>
        </div>
        {!! Form::open(['route' => 'reportes.horarios', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group{{ $errors->has('fecha') ? ' has-error' : '' }}">
                    {!! Form::label('fecha', 'Fecha', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        <input name="fecha" type="text" class="form-control" id="datepicker" value="{{ old('fecha') }}" required="true" placeholder="mm/dd/yyyy">
                        @if ($errors->has('fecha'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('fecha') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('local_id') ? ' has-error' : '' }}">
                    {!! Form::label('local_id', 'Local', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::select('local_id', $locales, old('local_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione un local --']) !!}
                        @if ($errors->has('local_id'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('local_id') }}
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

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS PARA REPORTES -->
    @include('reportes.partials.herramientas')
    <!-- AYUDA PARA HORARIOS -->
    @include('reportes.partials.info-horarios')
@endsection

@push('scripts')
    <!--  BOOTSTRAP DATE PICKER -->
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <!-- CONTROL PICKER -->
    <script>
        $(function ()
        {            
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                daysOfWeekDisabled: [0, 2, 3, 4, 5, 6, 7],
                language: 'es'
            });
        })
    </script>
@endpush