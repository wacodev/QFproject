@extends('layouts.principal')

@section('titulo', 'Configuración | Nuevo asueto')

@section('estilos')
    <!-- BOOTSTRAP DATE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
@endsection

@section('encabezado', 'Configuración')

@section('subencabezado', 'Asuetos')

@section('breadcrumb')
    <li>
        <i class="fa fa-cog icono-margen"></i>
            Configuración
        </li>
    <li>
        <a href="{{ route('asuetos.index') }}">
            Asuetos
        </a>
    </li>
    <li class="active">
        Nuevo asueto
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Nuevo asueto
            </h3>
        </div>
        <!-- FORMULARIO PARA CREAR UN NUEVO ASUETO -->
        {!! Form::open(['route' => 'asuetos.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                    {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::text('nombre', old('nombre'), ['class' => 'form-control', 'placeholder' => 'Nombre del asueto', 'required']) !!}
                        @if ($errors->has('nombre'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('nombre') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('fecha') ? ' has-error' : '' }}">
                    {!! Form::label('fecha', 'Fecha', ['class' => 'col-sm-4 control-label']) !!}
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
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <a href="{{ route('asuetos.index') }}" class="btn btn-default">
                        Cancelar
                    </a>
                    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA ASUETOS -->
    @include('administracion.partials.herr-asuetos')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- INFORMACIÓN ADICIONAL DE ASUETOS -->
    @include('administracion.partials.info-asuetos')
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
                language: 'es'
            })
        })
    </script>
@endpush