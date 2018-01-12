@extends('layouts.principal')

@section('titulo', 'Reservaciones | Exportar datos')

@section('estilos')
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}" />
@endsection

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Exportar datos')

@section('breadcrumb')
    <li>
        <i class="fa fa-ticket icono-margen"></i>
        Reservaciones
    </li>
    <li class="active">
        Exportar datos
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Exportar datos
            </h3>
        </div>
        {!! Form::open(['route' => 'reservaciones.recibir', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
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
                    {!! Form::submit('Exportar', ['class' => 'btn btn-success']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA LAS RESERVACIONES -->
    @include('reservaciones.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE EXPORTAR RESERVACIONES A EXCEL -->
    @include('reservaciones.partials.info-exportar')
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