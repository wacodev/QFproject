@extends('layouts.principal')

@section('titulo', 'Reportes | Registros del sistema')

@section('encabezado', 'Reportes')

@section('subencabezado', 'Registros del sistema')

@section('breadcrumb')
    <li>
        <i class="fa fa-file-text icono-margen"></i>
        Reportes
    </li>
    <li class="active">
        Registros del sistema
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Registros del sistema
            </h3>
        </div>
        {!! Form::open(['route' => 'reportes.lista-sistema', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group{{ $errors->has('reporte') ? ' has-error' : '' }}">
                    {!! Form::label('reporte', 'Reporte', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::select('reporte', [
                            '1' => 'Actividades',
                            '2' => 'Asignaturas',
                            '3' => 'Locales',
                            '4' => 'Usuarios'
                            ], old('reporte'), ['class' => 'form-control', 'placeholder' => '-- Seleccione el tipo de reporte --', 'required']) !!}
                        @if ($errors->has('reporte'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('reporte') }}
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
    <!-- AYUDA DE REGISTROS DEL SISTEMA -->
    @include('reportes.partials.info-sistema')
@endsection