@extends('layouts.principal')

@section('titulo', 'Editar perfil')

@section('encabezado', 'Editar perfil')

@section('breadcrumb')
    <li class="active">
        <i class="fa fa-users icono-margen"></i>
        Editar perfil
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Editar perfil
            </h3>
        </div>
            <!-- FORMULARIO PARA EDITAR PERFIL DE USUARIO -->
            {!! Form::open(['route' => ['actualizar-perfil', $user], 'autocomplete' => 'off', 'method' => 'PUT', 'files' => true, 'class' => 'form-horizontal']) !!}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        {!! Form::label('password', 'Contraseña', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Nueva contraseña']) !!}
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Confirmar contraseña', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirmar nueva contraseña']) !!}
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('imagen') ? ' has-error' : '' }}">
                        {!! Form::label('imagen', 'Imagen', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::file('imagen', ['class' => 'margen-campo-imagen']) !!}
                            @if ($errors->has('imagen'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('imagen') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    {!! Form::hidden('tipo', Auth::user()->tipo) !!}
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="{{ route('home') }}" class="btn btn-default">
                            Cancelar
                        </a>
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
    </div>
@endsection

@section('sidebar')
    <!-- PANEL DEL PERFIL DE USUARIO -->
    @include('layouts.perfil')
    <!-- AYUDA DE EDITAR PERFIL -->
    @include('layouts.partials.info-editar-perfil')
@endsection