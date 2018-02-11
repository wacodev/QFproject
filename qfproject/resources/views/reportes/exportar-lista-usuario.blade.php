@extends('layouts.principal')

@section('titulo', 'Reportes | Reservas por usuario')

@section('estilos')
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}" />
@endsection

@section('encabezado', 'Reportes')

@section('subencabezado', 'Reservas por usuario')

@section('breadcrumb')
    <li>
        <i class="fa fa-file-text icono-margen"></i>
        Reportes
    </li>
    <li class="active">
        Reservas por usuario
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Reservas por usuario
            </h3>
        </div>
        {!! Form::open(['route' => 'reportes.lista-usuario', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
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
                <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                    {!! Form::label('user_id', 'Usuario', ['class' => 'col-sm-4 control-label']) !!}
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
    <!-- AYUDA PARA PROGRAMACIÓN POR ACTIVIDAD -->
    @include('reportes.partials.info-prousuario')
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