@extends('layouts.principal')

@section('titulo', 'Reservaciones | Nuevo ciclo')

@section('estilos')
    <!-- BOOTSTRAP DATE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}" />
@endsection

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Nuevo ciclo')

@section('breadcrumb')
    <li>
        <i class="fa fa-ticket icono-margen"></i>
        Reservaciones
    </li>
    <li class="active">
        Nuevo ciclo
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Nuevo ciclo
            </h3>
        </div>
        {!! Form::open(['route' => 'reservaciones.registrar-ciclo', 'autocomplete' => 'off', 'method' => 'GET', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group{{ $errors->has('rango_fecha') ? ' has-error' : '' }}">
                    {!! Form::label('rango_fecha', 'Rango de fechas', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        <input name="rango_fecha" type="text" class="form-control pull-right" id="reservation" required="true" placeholder="mm/dd/yyyy - mm/dd/yyyy">
                        @if ($errors->has('rango_fecha'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('rango_fecha') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('fecha') ? ' has-error' : '' }}">
                    {!! Form::label('fecha', 'Inicio de ciclo', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        <input name="fecha" type="text" class="form-control" id="datepicker" required="true" value="{{ old('fecha') }}" placeholder="mm/dd/yyyy">
                        @if ($errors->has('fecha'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('fecha') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('propiedad') ? ' has-error' : '' }}">
                    {!! Form::label('propiedad', 'Reservar como propias', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::select('propiedad', [
                            true => 'Si',
                            false => 'No'
                            ], old('propiedad'), ['class' => 'form-control', 'placeholder' => '-- Seleccione una respuesta --', 'required']) !!}
                        @if ($errors->has('propiedad'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('propiedad') }}
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
                    {!! Form::submit('Reservar', ['class' => 'btn btn-success', 'id' => 'boton']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA LAS RESERVACIONES -->
    @include('reservaciones.partials.herramientas')
    <!-- AYUDA DE LA RESERVACIÓN POR CICLO -->
    @include('reservaciones.partials.info-crear-ciclo')
@endsection

@push('scripts')
    <!--  BOOTSTRAP DATE PICKER -->
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <!-- DATE RANGE PICKER -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <!-- CONTROL PICKER -->
    <script>
        $(function ()
        {            
            //Date range picker
            $('#reservation').daterangepicker()
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                daysOfWeekDisabled: [0],
                language: 'es'
            })
        })
    </script>
@endpush