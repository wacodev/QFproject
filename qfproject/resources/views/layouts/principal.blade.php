<!DOCTYPE html>

<html lang="es">
  
  <head>
    
    <!-- METAINFORMACIÓN -->
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- TÍTULO -->

    <title>@yield('titulo', 'Química y Farmacia')</title>
    
    <!-- DILE AL NAVEGADOR QUE RESPONDA AL ANCHO DE LA PANTALLA -->
    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- BOOTSTRAP 3.3.5 -->
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
    <!-- FONT AWESOME -->
    
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">

    <!-- IONICONS -->
    
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    
    <!-- BOOTSTRAP DATE PICKER -->

    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}}">

    <!-- BOOTSTRAP TIME PICKER -->

    <link rel="stylesheet" href="{{asset('css/bootstrap-timepicker.css')}}">
    
    <!-- ESTILO DEL TEMA -->
    
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">

    <!-- ADMINLTE SKINS - ELIJA UNA MÁSCARA DE LA CARPETA CSS/SKINS EN LUGAR DE DESCARGAR TODAS PARA REDUCIR LA CARGA -->
    
    <link rel="stylesheet" href="{{ asset('css/skin-green.min.css') }}">

    <!-- MIS ESTILOS -->
    
    <link rel="stylesheet" href="{{ asset('css/mis_estilos.css') }}">
    
    <!-- FAVICON -->
    <!-- Editar (Borrar comentario al editar) -->
    
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

  </head>
  
  <body class="hold-transition skin-green sidebar-mini" onload="startTime()">
    
    <div class="wrapper">

      <header class="main-header">

        <!-- LOGO -->
        
        <a href="index2.html" class="logo">
          <!-- Mini logo para la mini barra lateral 50x50 pixels -->
          <span class="logo-mini">UES</span>
          <!-- Logo para estado regular y dispositivos móviles -->
          <span class="logo-lg">Química y Farmacia</span>
        </a>

        <!-- BARRA DE NAVEGACIÓN DEL ENCABEZADO -->
        
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Menú desplegable de la barra lateral -->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          
          <!-- MENÚ DERECHO DE LA BARRA DE NAVEGACIÓN -->
          
          <div class="navbar-custom-menu">         
            <ul class="nav navbar-nav">
              
              <!-- NOTIFICACIONES -->
              <!-- Editar (Borrar comentario al editar) -->
              
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell"></i>
                  <span class="label label-danger">10</span>
                </a>
              </li>
              
              <!-- CUENTA DE USUARIO -->
              
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{ asset('images/users/default_profile.jpg') }}" class="user-image" alt="Imagen de usuario">
                  <span class="hidden-xs">Nombre de usuario</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- Imagen de usuario -->
                  <li class="user-header">
                    <img src="{{ asset('images/users/default_profile.jpg') }}" class="img-circle" alt="Imagen de usuario">
                    <p>Nombre de usuario<small>Tipo de usuario</small></p>
                  </li>
                  
                  <!-- MENÚ DE PIE DE PÁGINA -->
                  
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Perfil</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Cerrar sesión</a>
                    </div>
                  </li>

                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      
      </header>
      
      <!-- COLUMNA DEL LADO IZQUIERDO - CONTIENE EL LOGO Y LA BARRA LATERAL -->
      
      <aside class="main-sidebar">
        
        <!-- BARRA LATERAL -->
        
        <section class="sidebar">
          
          <!-- PANEL DE USUARIO DE LA BARRA LATERAL -->
          
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{ asset('images/users/default_profile.jpg') }}" class="img-circle" alt="Imagen de usuario">
            </div>
            <div class="pull-left info">
              <p>Nombre de usuario</p>
              <p style="font-size: 12px;">Tipo de usuario</p>
            </div>
          </div>

          <!-- MENÚ DE LA BARRA LATERAL -->
          <!-- Editar (Borrar comentario al editar) -->
          
          <ul class="sidebar-menu">
            
            <li>
              <a href="#">
                <i class="fa fa-user"></i><span>Mi perfil</span>
              </a>
            </li>

            <li>
              <a href="#">
                <i class="fa fa-bell"></i><span>Notificaciones</span>
                <small class="label pull-right bg-red">10</small>
              </a>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-ticket"></i>
                <span>Reservaciones</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i>Nueva reservación *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Por paquete *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Historial *</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-file-text"></i>
                <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i>General *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Por actividades *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Por asignaturas *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Por locales *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Por usuarios *</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i>
                <span>Estadísticas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i>General *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Por actividades *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Por asignaturas *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Por locales *</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Por usuarios *</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i>
                <span>Configuración</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route('actividades.index') }}"><i class="fa fa-circle-o"></i>Actividades</a></li>
                <li><a href="{{ route('asignaturas.index') }}"><i class="fa fa-circle-o"></i>Asignaturas</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Asuetos *</a></li>
                <li><a href="{{ route('locales.index') }}"><i class="fa fa-circle-o"></i>Locales</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i>Reservaciones *</a></li>
                <li><a href="{{ route('suspensiones.index') }}"><i class="fa fa-circle-o"></i>Suspensiones</a></li>
              </ul>
            </li>

            <li>
              <a href="#">
                <i class="fa fa-users"></i><span>Usuarios</span>
              </a>
            </li>
            
            <li>
              <a href="#">
                <i class="fa fa-info-circle"></i><span>Acerca de</span>
              </a>
            </li>

            <li>
              <a href="#">
                <i class="fa fa-book"></i><span>Ayuda</span>
              </a>
            </li>
                        
            <li>
              <a href="#">
                <i class="fa fa-clock-o"></i> <span id="clock"></span>
              </a>
            </li>

            <li>
              <a href="#">
                <i class="fa fa-calendar"></i> <span id="date"></span>
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

        <!-- ENCABEZADO DE CONTENIDO -->
        
        <section class="content-header">
          <h1>
            @yield('encabezado', 'Encabezado')
            <small>@yield('subencabezado', '')</small>
          </h1>
          <ol class="breadcrumb">
            @yield('breadcrumb')
          </ol>
        </section>

        <!-- CONTENIDO -->
        
        <section class="content">
            @yield('contenido')
        </section>
      
      </div>
      
      <!-- FOOTER -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          Versión Alpha 1.0
        </div>
        <a href="http://www.quimicayfarmacia.ues.edu.sv/" target="_blanck">Facultad de Química y Farmacia</a> &copy; 2017-2018
      </footer>

    </div>

    <!-- SCRIPTS -->  
    
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

    <!-- SECCIÓN PARA SCRIPTS -->

    @stack('scripts')
    
  </body>

</html>
