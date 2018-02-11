@extends('layouts.principal')

@section('titulo', 'Reservaciones | Nueva reservación')

@section('estilos')
    <!-- BOOTSTRAP DATE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
    <!-- BOOTSTRAP TIME PICKER -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-timepicker.css') }}" />
@endsection

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
            <h3 class="box-title">Paso 1: Fecha y hora</h3>
        </div>
        {!! Form::open(['route' => 'reservaciones.paso-dos', 'autocomplete' => 'off', 'method' => 'GET', 'class' => 'form-horizontal']) !!}
            {{ Form::token() }}
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
                <div class="form-group{{ $errors->has('hora_inicio') ? ' has-error' : '' }}">
                    {!! Form::label('hora_inicio', 'Hora de inicio', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        <div class="bootstrap-timepicker">
                            <input name="hora_inicio" type="text" class="form-control timepicker" value="{{ old('hora_inicio') }}" required="true" placeholder="hh:mm XX">
                        </div>
                        @if ($errors->has('hora_inicio'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('hora_inicio') }}
                                </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('hora_fin') ? ' has-error' : '' }}">
                    {!! Form::label('hora_fin', 'Hora de finalización', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        <div class="bootstrap-timepicker">
                            <input name="hora_fin" type="text" class="form-control timepicker" value="{{ old('hora_fin') }}" required="true" placeholder="hh:mm XX">
                        </div>
                        @if ($errors->has('hora_fin'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('hora_fin') }}
                            </span>
                        @endif
                    </div>
                </div>
                @if (Auth::user()->administrador() || Auth::user()->asistente())
                    <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
                        {!! Form::label('tipo', 'Tipo de reservación', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::select('tipo', [
                                'Ordinaria' => 'Ordinaria',
                                'Extraordinaria'     => 'Extraordinaria'
                                ], old('tipo'), ['class' => 'form-control', 'placeholder' => '-- Seleccione el tipo de reservación --']) !!}
                            @if ($errors->has('tipo'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('tipo') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    @if(Auth::user()->docente())
                        <a href="{{ route('home') }}" class="btn btn-default">
                            Cancelar
                        </a>
                    @else
                        <a href="{{ route('reservaciones.index') }}" class="btn btn-default">
                            Cancelar
                        </a>
                    @endif
                    {!! Form::submit('Siguiente', ['class' => 'btn btn-success']) !!}
                </div>
            </div>
        {!! Form::close() !!}
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

@push('scripts')
    <!--  BOOTSTRAP DATE PICKER -->
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <!--  BOOTSTRAP TIME PICKER -->
    <script src="{{ asset('js/bootstrap-timepicker.js') }}"></script>
    <!-- CONTROL PICKER -->
    <script>
        $(function ()
        {            
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                daysOfWeekDisabled: [0],
                language: 'es'
            })
            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false,
                minuteStep: 60,
                defaultTime: '07:00 AM'
            }).on('changeTime.timepicker',
            function(e)
            {
                //Limitando hora de 7:00 AM a 06:00 PM
                var h = e.time.hours;
                var mer = e.time.meridian;
                if (h != 12) {
                    if (mer == 'AM' && h < 7 || mer == 'PM' && h > 6) $('.timepicker').timepicker('setTime', '07:00 AM');
                }
            });
        })
    </script>
@endpush