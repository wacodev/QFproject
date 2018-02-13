@extends('layouts.principal')

@section('titulo', 'Usuarios | Editar usuario')

@section('encabezado', 'Usuarios')

@section('subencabezado', 'Editar usuario')

@section('breadcrumb')
    <li>
        <i class="fa fa-users icono-margen"></i>
        <a href="{{ route('users.index') }}">
            Usuarios
        </a>
    </li>
    <li class="active">
        Editar usuario
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Editar usuario: {{ $user->name }} {{ $user->lastname }}
            </h3>
        </div>
            <!-- FORMULARIO PARA EDITAR UN USUARIO -->
            {!! Form::open(['route' => ['users.update', $user], 'autocomplete' => 'off', 'method' => 'PUT', 'files' => true, 'class' => 'form-horizontal']) !!}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {!! Form::label('name', 'Nombre', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Nombres del usuario', 'required']) !!}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        {!! Form::label('lastname', 'Apellido', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('lastname', $user->lastname, ['class' => 'form-control', 'placeholder' => 'Apellidos del usuario', 'required']) !!}
                            @if ($errors->has('lastname'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('lastname') }}
                                </span>
                            @endif
                        </div>
                    </div>
                  

                  <!--USERNAME -->
                  <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        {!! Form::label('username', 'Username', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('username', $user->username, ['class' => 'form-control', 'placeholder' => 'Username', 'required']) !!}
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('username') }}
                                </span>
                            @endif
                        </div>
                    </div>




                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!! Form::label('email', 'Correo electrónico', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => 'ejemplo@correo.com', 'required']) !!}
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>
                    </div>
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
                    <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
                        {!! Form::label('tipo', 'Tipo de usuario', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::select('tipo', [
                                'Administrador' => 'Administrador',
                                'Asistente'     => 'Asistente',
                                'Docente'       => 'Docente',
                                'Visitante'     => 'Visitante'
                                ], $user->tipo, ['class' => 'form-control', 'placeholder' => 'Tipo de usuario', 'required']) !!}
                            @if ($errors->has('tipo'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('tipo') }}
                                </span>
                            @endif
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
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="{{ route('users.index') }}" class="btn btn-default">
                            Cancelar
                        </a>
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA USUARIOS -->
    @include('administracion.partials.herr-usuarios')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- AYUDA DE USUARIOS -->
    @include('administracion.partials.info-usuarios')
@endsection