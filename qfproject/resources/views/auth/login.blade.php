<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- TÍTULO -->
        <title>Inicio de sesión</title>
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
                    Sistema de reservación de locales
                </p>
                <!-- FORMULARIO -->
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
                        <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required placeholder="Correo electrónico">
                        <span class="fa fa-envelope-o form-control-feedback"></span>
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('username') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                        <input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña">
                        <span class="fa fa-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    Recordar
                                </label>
                            </div>
                        </div>        
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-success btn-block btn-flat">
                                Acceder
                            </button>
                        </div>
                    </div>
                </form>
                <!-- LOGIN SOCIAL -->
                <!-- 
                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
                </div>
                -->
                <!-- RECUPERAR CONTRASEÑA Y REGISTRAR NUEVO USUARIO -->
                <div class="text-center">
                    <a href="{{ route('password.request') }}">No recuerdo mi contraseña</a><br>
                  
                </div>
            </div>
        </div>
        <!-- JQUERY 2.1.4 -->
        <script src="{{ asset('js/jQuery-2.1.4.min.js') }}"></script>
        <!-- BOOTSTRAP 3.3.5 -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    </body>
</html>