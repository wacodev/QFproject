<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- METAINFORMACIÓN -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        <!-- TÍTULO -->
        <title>
            @yield('titulo', 'Química y Farmacia')
        </title>
        <!-- BOOTSTRAP 3.3.5 -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
        <!-- BOOTSTRAP DATE PICKER -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}" />
        <!-- BOOTSTRAP TIME PICKER -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap-timepicker.css') }}" />
        <!-- ESTILO DEL TEMA -->
        <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css')}}" />
        <!-- ADMINLTE SKINS -->
        <link rel="stylesheet" href="{{ asset('css/skin-green.min.css') }}" />
        <!-- MIS ESTILOS -->
        <link rel="stylesheet" href="{{ asset('css/mis-estilos.css') }}" />
        <!-- SECCIÓN PARA AGREGAR ESTILOS -->
        @yield('estilos')
        <!-- FAVICON -->
        <link rel="logo-simple" href="{{ asset('images/sistema/logos-simple.png') }}" />
        <link rel="shortcut icon" href="{{ asset('images/sistema/logo-simple.ico') }}" />
    </head>
    <body class="hold-transition skin-green sidebar-mini" onload="startTime()">
        <!-- NOMBRE CORTO -->
        <?php
            $nombre = explode(' ', Auth::user()->name);
            $apellido = explode(' ', Auth::user()->lastname);
        ?>
        <div class="wrapper">
            <header class="main-header">
                <!-- LOGO -->
                <a href="" class="logo">
                    <!-- MINI LOGO PARA LA MINI BARRA LATERAL -->
                    <span class="logo-mini">
                        <img src="{{ asset('images/sistema/logo-simple-blanco.png') }}" class="mini-logo-barra" alt="Mini logo" />
                    </span>
                    <!-- LOGO PARA ESTADO REGULAR Y DISPOSITIVOS MÓVILES -->
                    <span class="logo-lg">
                        Química y Farmacia
                    </span>
                </a>
                <!-- BARRA DE NAVEGACIÓN DEL ENCABEZADO -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- MENÚ DESPLEGABLE DE LA BARRA LATERAL -->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">
                            Navegación
                        </span>
                    </a>
                    <!-- MENÚ DERECHO DE LA BARRA DE NAVEGACIÓN -->
                    <div class="navbar-custom-menu">         
                        <ul class="nav navbar-nav">
                            <!-- NOTIFICACIONES -->
                            <li class="dropdown notifications-menu"> <!-- Editar -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell"></i>
                                    <span class="label label-danger">
                                        10
                                    </span>
                                </a>
                            </li>
                            <!-- CUENTA DE USUARIO -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ asset('images/users/default_profile.jpg') }}" class="user-image" alt="Imagen de usuario"/>
                                    <span class="hidden-xs">
                                        {{ $nombre[0] . ' ' . $apellido[0] }}
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- IMAGEN DE USUARIO -->
                                    <li class="user-header">
                                        <img src="{{ asset('images/users/default_profile.jpg') }}" class="img-circle" alt="Imagen de usuario"/>
                                        <p>
                                            {{ $nombre[0] . ' ' . $apellido[0] }}
                                            <small>
                                                {{ Auth::user()->tipo }}
                                            </small>
                                        </p>
                                    </li>
                                    <!-- MENÚ DE PIE DE PÁGINA -->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="{{ route('home') }}" class="btn btn-default btn-flat">
                                                Inicio
                                            </a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Cerrar sesión
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- COLUMNA DEL LADO IZQUIERDO -->
            <aside class="main-sidebar">
                <!-- BARRA LATERAL -->
                <section class="sidebar">
                    <!-- PANEL DE USUARIO DE LA BARRA LATERAL -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ asset('images/users/default_profile.jpg') }}" class="img-circle" alt="Imagen de usuario" />
                        </div>
                        <div class="pull-left info">
                            <p>
                                {{ $nombre[0] . ' ' . $apellido[0] }}
                            </p>
                            <p style="font-size: 12px;">
                                {{ Auth::user()->tipo }}
                            </p> <!-- Editar -->
                        </div>
                    </div>
                    <!-- MENÚ DE LA BARRA LATERAL -->
                    <ul class="sidebar-menu">
                        <li>
                            <a href="{{ route('home') }}">
                                <i class="fa fa-home"></i>
                                <span>
                                    Inicio
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#"> <!-- Editar -->
                                <i class="fa fa-bell"></i>
                                <span>
                                    Notificaciones
                                </span>
                                <small class="label pull-right bg-red">
                                    10
                                </small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#"> <!-- Editar -->
                                <i class="fa fa-ticket"></i>
                                <span>
                                    Reservaciones
                                </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Mis reservaciones
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Todas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('reservaciones.paso-uno') }}">
                                        <i class="fa fa-circle-o"></i>
                                        Nueva reservación
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Por paquete
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Historial
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"> <!-- Editar -->
                                <i class="fa fa-file-text"></i>
                                <span>
                                    Reportes
                                </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        General
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Por actividades
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Por asignaturas
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Por locales
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Por usuarios
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"> <!-- Editar -->
                                <i class="fa fa-bar-chart"></i>
                                <span>
                                    Estadísticas
                                </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        General
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Por actividades
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Por asignaturas
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Por locales
                                    </a>
                                </li>
                                <li>
                                    <a href="#"> <!-- Editar -->
                                        <i class="fa fa-circle-o"></i>
                                        Por usuarios
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"> <!-- Editar -->
                                <i class="fa fa-cog"></i>
                                <span>
                                    Configuración
                                </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('actividades.index') }}">
                                        <i class="fa fa-circle-o"></i>
                                        Actividades
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('asignaturas.index') }}">
                                        <i class="fa fa-circle-o"></i>
                                        Asignaturas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('asuetos.index') }}">
                                        <i class="fa fa-circle-o"></i>
                                        Asuetos
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('locales.index') }}">
                                        <i class="fa fa-circle-o"></i>
                                        Locales
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('suspensiones.index') }}">
                                        <i class="fa fa-circle-o"></i>
                                        Suspensiones
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}">
                                <i class="fa fa-users"></i>
                                <span>
                                    Usuarios
                                </span>
                            </a>
                        </li>   
                        <li>
                            <a href="#"> <!-- Editar -->
                                <i class="fa fa-info-circle"></i>
                                <span>
                                    Acerca de
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#"> <!-- Editar -->
                                <i class="fa fa-question-circle"></i>
                                <span>
                                    Ayuda
                                </span>
                            </a>
                        </li>                        
                        <li>
                            <a href="#"> <!-- Editar -->
                                <i class="fa fa-clock-o"></i>
                                <span id="clock"></span>
                            </a>
                        </li>
                        <li>
                            <a href="#"> <!-- Editar -->
                                <i class="fa fa-calendar"></i>
                                <span id="date"></span>
                            </a>
                        </li>
                    </ul>
                </section>
            </aside>
            <!-- CONTENEDOR -->
            <div class="content-wrapper">        
                <!-- MENSAJES FLASH -->        
                <section class="mensaje-flash">
                    @include('flash::message')
                </section>
                <!-- ENCABEZADO DEL CONTENIDO -->      
                <section class="content-header">
                    <h1>
                        @yield('encabezado', 'Encabezado')
                        <small>
                            @yield('subencabezado')
                        </small>
                    </h1>
                    <ol class="breadcrumb">
                        @yield('breadcrumb')
                    </ol>
                </section>
                <!-- SECCIÓN PARA AGREGAR EL CONTENIDO -->        
                <section class="content">
                    @yield('contenido')
                </section>      
            </div>      
            <!-- FOOTER -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Sistema de reservación de locales
                </div>
                <a href="http://www.quimicayfarmacia.ues.edu.sv/" target="_blanck">
                    Facultad de Química y Farmacia
                </a>
                &copy; 2017-2018
            </footer>
        </div>    
        <!-- JQUERY 2.1.4 -->    
        <script src="{{ asset('js/jQuery-2.1.4.min.js') }}"></script>    
        <!-- BOOTSTRAP 3.3.5 -->    
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <!--  BOOTSTRAP DATE PICKER -->
        <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
        <!--  BOOTSTRAP TIME PICKER -->
        <script src="{{ asset('js/bootstrap-timepicker.js') }}"></script>    
        <!-- ADMINLTE APP -->    
        <script src="{{ asset('js/app.min.js') }}"></script>
        <!-- HORA Y FECHA -->    
        <script src="{{ asset('js/hora-y-fecha.js') }}"></script>
        <!-- SECCIÓN PARA AGREGAR SCRIPTS -->
        @stack('scripts')    
    </body>
</html>