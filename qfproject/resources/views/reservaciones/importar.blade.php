@extends('layouts.principal')

@section('titulo', 'Reservaciones | Importar datos')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Importar datos')

@section('breadcrumb')
    <li>
        <i class="fa fa-ticket icono-margen"></i>
        Reservaciones
    </li>
    <li class="active">
        Importar datos
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Importar datos
            </h3>
        </div>
            {!! Form::open(['route' => 'reservaciones.almacenar', 'autocomplete' => 'off', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal']) !!}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('archivo') ? ' has-error' : '' }}">
                        {!! Form::label('archivo', 'Archivo', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::file('archivo', ['class' => 'margen-campo-imagen']) !!}
                            @if ($errors->has('archivo'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('archivo') }}
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
                        {!! Form::submit('Importar', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA LAS RESERVACIONES -->
    @include('reservaciones.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE IMPORTAR RESERVACIONES DESDE EXCEL -->
    @include('reservaciones.partials.info-importar')
@endsection