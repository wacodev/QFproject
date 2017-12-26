@extends('layouts.principal')

@section('titulo', 'Reservaciones | Importar datos')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Importar datos')

@section('breadcrumb')
    
    <li><i class="fa fa-ticket icono-margen"></i>Reservaciones</li>
    <li class="active">Importar datos</li>

@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Importar datos</h3>
                </div>
                    {!! Form::open(['route' => 'reservaciones.almacenar', 'autocomplete' => 'off', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal']) !!}
                        <div class="box-body">
                            <div class="form-group{{ $errors->has('imagen') ? ' has-error' : '' }}">
                                {!! Form::label('archivo', 'Archivo', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-7">
                                    {!! Form::file('archivo', ['class' => 'margen-campo-imagen']) !!}
                                    @if ($errors->has('imagen'))
                                        <span class="help-block">
                                            <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>{{ $errors->first('imagen') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <a href="{{ route('home') }}" class="btn btn-default">Cancelar</a>
                                {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection