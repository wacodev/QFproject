<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- TÍTULO -->
        <title>Registro</title>
        <!-- BOOTSTRAP 3.3.5 -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
        <!-- ESTILO DEL TEMA -->
        <link rel="stylesheet" href="{{ asset('css/AdminLTE.css')}}">
        <!-- MIS ESTILOS -->
        <link rel="stylesheet" href="{{ asset('css/mis-estilos.css') }}">
        <!-- FAVICON -->
        <link rel="logo-simple" href="{{ asset('images/sistema/logos-simple.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/sistema/logo-simple.ico') }}">
    </head>
    <body class="hold-transition login-page login-fondo">
        <div class="login-box">
            <!-- LOGO -->
            <div class="login-logo login-logo-color">
                Facultad de Química y Farmacia
            </div>
            <!-- CONTENIDO -->
            <div class="login-box-body">
                <p class="login-box-msg">
                    Formulario de registro
                </p>
                <!-- FORMULARIO -->
                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <!-- NOMBRE -->
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Nombre">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                    <!-- APELLIDO -->
                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }} has-feedback">
                        <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required placeholder="Apellido">
                        @if ($errors->has('lastname'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('lastname') }}
                            </span>
                        @endif
                    </div>
                    <!-- CORREO ELECTRÓNICO -->
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Correo electrónico">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                    <!-- CONTRASEÑA -->
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                        <input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <!-- CONFIRMAR CONTRASEÑA -->
                    <div class="form-group has-feedback">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirmar contraseña">
                    </div>
                    <!-- TIPO -->
                    <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }} has-feedback">
                        {!! Form::select('tipo', [
                            'Administrador' => 'Administrador',
                            'Asistente'     => 'Asistente',
                            'Docente'       => 'Docente',
                            'Visitante'     => 'Visitante'
                            ], old('tipo'), ['class' => 'form-control', 'placeholder' => 'Tipo de usuario', 'required']) !!}
                        @if ($errors->has('tipo'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('tipo') }}
                            </span>
                        @endif
                    </div>
                    <!-- BOTÓN PARA REGISTRAR -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- JQUERY 2.1.4 -->
        <script src="{{ asset('js/jQuery-2.1.4.min.js') }}"></script>
        <!-- BOOTSTRAP 3.3.5 -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>