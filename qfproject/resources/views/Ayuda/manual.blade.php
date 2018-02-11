@extends('layouts.principal')

@section('titulo', 'Ayuda')

@section('encabezado', 'Ayuda')

@section('breadcrumb')
    <li>
       <i class="fa fa-question-circle"></i>
        Ayuda
    </li>
    <li class="active">
        Manual de usuario
    </li>
@endsection

@section('contenido')


<div class="tab">
  <button class="tablinks" onclick="abrir(event, 'Inicio')" id="defaultOpen">Inicio</button>
  <button class="tablinks" onclick="abrir(event, 'Home')">Pantalla Principal</button>
  <button class="tablinks" onclick="abrir(event, 'Reservas')">Reservaciones</button>
  <button class="tablinks" onclick="abrir(event, 'Reportes')">Reportes</button>
  <button class="tablinks" onclick="abrir(event, 'Estadísticas')">Estadísticas</button>
  <button class="tablinks" onclick="abrir(event, 'Configuración')">Configuración</button>
  <button class="tablinks" onclick="abrir(event, 'Usuarios')">Usuarios</button>
</div>


<!--MÓDULO INICIO -->
<div id="Inicio" class="tabcontent"><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  <h3>Introducción</h3>
  <p align="justify">El sistema de reservación de locales está compuesto por una interfaz que muestra una serie de opciones que el usuario puede seleccionar de acuerdo a su rol, opciones como ingresar locales, asuetos, asignaturas y suspensiones, gestionar usuarios, realizar reservas, entre otras opciones, con el fin de seleccionar el local que más le convenga y evitar que se presenten situaciones en las cuales implique que una actividad se traslape con otra y ocasione inconvenientes, contratiempos, e incluso cancelación de actividades.</p>
</div>



<!--MÓDULO PANTALLA PRINCIPAL -->
<div id="Home" class="tabcontent"><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
<br>
<h4><b>Contenido</b></h4>
<div class="contenido"><h4><a href="#primero">Inicio del sistema</a></h4></div>
<div class="contenido"><h4><a href="#segundo">Mis Reservaciones</a></h4></div>
<div class="contenido"><h4><a href="#tercero">Imprimir Comprobante</a></h4></div>
<hr>
  <a name="primero"><h4>Inicio del sistema</h4></a>
  <p align="justify">Al acceder al sistema se presenta la pantalla de inicio del sistema, el usuario administrador es quien tendrá el control total del sistema, por ello tendrá todas las opciones activas.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/20.png') }}"></td></center>
  <br>
  <p align="justify">Esta compuesto por una serie de módulos:</p> 
   <li>Reservaciones</li>  
   <li>Reportes</li>
   <li>Estadísticas</li>
   <li>Configuración</li>
   <li>Usuarios</li> 
   <br>
   <p align="justify">Además encontramos la información del perfil de su usuario al lado derecho, desde donde podemos realizar una nueva reserva o editar nuestro perfil para hacer cambios de contraseña, fotografía, entre otros. </p>  
   <br>
   <center>
   <td><img src="{{ url('images/ayuda/36.png') }}"></td></center> 
   <hr> 
   <p align="justify">En la barra podemos observar una campana, en la que veremos un número en color rojo cada vez que tengamos una notificación. </p>  
   <br>
   <center>
   <td><img src="{{ url('images/ayuda/33.png') }}"></td></center> 
   <hr> 


   <a name="segundo"><h4>Mis Reservaciones</h4></a> 
   <p align="justify">Aquí se muestran las reservaciones hechas por usted que aún estan vigentes, se pueden buscar por local, fecha, asignatura, hora, etc.</p><br>
  <center>
  <td><img src="{{ url('images/ayuda/21.png') }}"></td></center>
  <br> 

  <a name="tercero"><h4>Imprimir Comprobante de Reservación</h4></a> 
  <p align="justify">Como algo adicional al seleccionar la pestaña de la reservación, podrá editar la reservación, eliminarla y ver el comprobante en formato pdf para así poder imprimirlo</p><br>
  <center>
  <td><img src="{{ url('images/ayuda/comprobante.png') }}"></td></center>
  <br> 
</div>




<!--MÓDULO RESERVACIONES -->
<div id="Reservas" class="tabcontent" ><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  <h4><b>Contenido</b></h4>
<div class="contenido"><h4><a href="#uno">Nueva Reservación de Local</a></h4></div>
<div class="contenido"><h4><a href="#dos">Historial de reservaciones</a></h4></div>
<div class="contenido"><h4><a href="#tres">Reservas próximas</a></h4></div>
<div class="contenido"><h4><a href="#cuatro">Panel de Administración</a></h4></div>
<div class="sangria"><h4><a href="#cinco">Reservación Individual</a></h4></div>
<div class="sangria"><h4><a href="#seis">Exportar reservaciones a excel</a></h4></div>
<div class="sangria"><h4><a href="#siete">Importar reservaciones a excel</a></h4></div>
<div class="sangria"><h4><a href="#ocho">Reservación por ciclo</a></h4></div>
<div class="sangria"><h4><a href="#nueve">Reservación semanal</a></h4></div>

<hr>
<a name="uno"><h4>Nueva Reserva de Local</h4></a>
<p align="justify">Para realizar una reserva de asignaturas, se deben realizar tres pasos en los cuales se muestran los formularios para seleccionar la hora, local, asignatura, entre otras cosas.</p><br>

<b><p>PASO 1: Fecha y Hora. </p></b>
<p align="justify">Se muestra un formulario en el cual se seleccionará la fecha de la reserva, hora de inicio, hora de finalización y tipo de reservación si es ordinaria o extraordinaria. Si se encuentra una reserva a la hora seleccionada, y no hay otro local disponible se mostrará un mensaje de que no hay locales disponibles a esa hora.</p><br>
<center>
<td><img src="{{ url('images/ayuda/7.png') }}"></td></center><br>

<b><p>PASO 2: Locales Disponibles </p></b>
<p align="justify">Se muestra una pantalla con todos los locales que están disponibles, el usuario debe seleccionar el local de acuerdo a la capacidad que necesite</p><br>
<center>
<td><img src="{{ url('images/ayuda/8.png') }}"></td></center><br>

<b><p>PASO 3: Detalles </p></b>
<p align="justify">Se completa el pequeño formulario seleccionando el nombre la asignatura, la actividad a realizar; en estos campos se pueden agregar más de una al hacer click en "+", también se puede agregar el tema a realizar (este campo no es obligatorio) y como algo adicional el usuario administrador podrá asignar la reserva a otro usuario; luego hacer clic en el botón “Reservar” y mostrará un mensaje de que la reserva se guardó correctamente. </p>
<center>
<td><img src="{{ url('images/ayuda/9.png') }}"></td></center><br>

<a name="dos"><h4>Historial de reservas</h4></a>
<p align="justify">Aquí se muestran todas las reservas vigentes y expiradas realizadas por el usuario </p> 
<center>
<td><img src="{{ url('images/ayuda/historial.png') }}"></td></center>
<br>

<a name="tres"><h4>Reservas próximas</h4></a>
<p align="justify">Al hacer clic sobre esta opción automáticamente se genera un pdf con la lista de reservas del siguiente día</p> 
<center>
<td><img src="{{ url('images/ayuda/19.png') }}"></td></center>
<br>

<a name="cuatro"><h4>Panel de Administración</h4></a>
<p align="justify">Aquí podemos observar la lista de reservas realizadas por todos los usuarios del sistema, donde tendremos la opción de ver, editar y eliminar las reservas, así como también eliminar varias reservas a la vez seleccionando cada reserva que queremos eliminar y haciendo click en el botón de eliminar seleccionadas.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/17.png') }}"></td></center>
  <br>

  <b>Opciones del panel Herramientas Adicionales</b>
  <a name="cinco"><h4>Reservación Individual</h4></a>
  <p align="justify">Esta opción nos redirige a <a href="#uno">Nueva Reservación de Local</a></p> 
  <br>

  <a name="seis"><h4>Exportar Reservaciones a Excel</h4></a>
  <p align="justify">Para exportar reservaciones debemos seleccionar el rango de fecha y además el local del cual queramos exportar, luego hacer clic en el botón de Exportar y automáticamente se descargará el archivo .xls  </p> 
  <center>
  <td><img src="{{ url('images/ayuda/excel1.png') }}"></td>
  <hr>
  <td><img src="{{ url('images/ayuda/excel2.png') }}"></td>
  </center>
  <br>

  <a name="siete"><h4>Importar reservaciones a excel</h4></a>
  <p align="justify">Para importar reservaciones, nos muestra un botón de examinar en el cual al hacer clic podemos seleccionar el archivo .xls o .xlsx a importar</p> 
  <center>
  <td><img src="{{ url('images/ayuda/excel3.png') }}"></td></center>
  <br>

  <a name="ocho"><h4>Reservación por ciclo</h4></a>
  <p align="justify">Permite registrar todas las reservaciones ordinarias de un ciclo anterior en uno nuevo, al reservar por este método, todas aquellas reservaciones registradas dentro del nuevo ciclo serán eliminadas. Para ello se muestra un pequeño formulario donde se selecciona el rango de fechas, el inicio del ciclo y si se reservará como propias o se asignará a otro usuario.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/reserva-ciclo.png') }}"></td></center>
  <br>

  <a name="nueve"><h4>Reservación por semanal</h4></a>
  <p align="justify">Aquí podemos realizar reservas con frecuencia de cada semana o cada dos semanas, para un tiempo determinado. Para ello se realizan una serie de pasos.</p><br> 
  <b>PASO 1: Fecha y hora</b>
  <p align="justify">Seleccionamos la fecha inicial, hora de inicio y finalización de la actividad, la frecuencia y el número de semanas en que se quiere reservar</p>
  <center>
  <td><img src="{{ url('images/ayuda/semanal.png') }}"></td></center>
  <br>

  <b>PASO 2: Locales Disponibles</b>
  <p align="justify">Seleccionamos el local de acuerdo a la capacidad que se requiera.</p>
  <center>
  <td><img src="{{ url('images/ayuda/semanal2.png') }}"></td></center>
  <br>

  <b>PASO 3: Detalles</b>
  <p align="justify">Se completa el pequeño formulario seleccionando el nombre la asignatura, la actividad a realizar; en estos campos se pueden agregar más de una al hacer click en "+", también se puede agregar el tema a realizar (este campo no es obligatorio) y como algo adicional el usuario administrador podrá asignar la reserva a otro usuario; luego hacer clic en el botón “Reservar” y mostrará un mensaje de que la reserva se guardó correctamente.</p>
  <center>
  <td><img src="{{ url('images/ayuda/semanal3.png') }}"></td></center>
  <br>


</div>




<!--MÓDULO REPORTES -->
<div id="Reportes" class="tabcontent"><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <h4><b>Contenido</b></h4>
<div class="contenido"><h4><a href="#uno1">Reporte de reservaciones en Horario</a></h4></div>
<div class="contenido"><h4><a href="#dos2">Reporte de reservaciones por Actividad</a></h4></div>

<hr>
  <a name="uno1"><h4>Reporte de reservaciones en Horario</h4></a>
  <p align="justify">Para obtener un reporte de las reservaciones en formato de horario, seleccionamos la semana, y el local y hacemos clic en el botón de Aceptar, y automáticamente nos generará un pdf con el horario de la semana para ese local seleccionado. </p> 
  <center>
  <td><img src="{{ url('images/ayuda/horarios.png') }}"></td></center>
  <br>
  <center>
  <td><img src="{{ url('images/ayuda/horarios2.png') }}"></td></center>
  <br>

  <a name="dos2"><h4>Reporte de reservaciones por Actividad</h4></a>
  <p align="justify">Para obtener una lista de reservaciones por su actividad, seleccionamos el rango de fechas, la asignatura y la actividad, al hacer clic en Aceptar, se generará automáticamente la lista de reservas en el rango de fechas seleccionado. </p> 
  <center>
  <td><img src="{{ url('images/ayuda/actividad1.png') }}"></td></center>
  <br>
  <center>
  <td><img src="{{ url('images/ayuda/actividad2.png') }}"></td></center>
</div>



<!--MÓDULO ESTADÍSTICAS -->

<div id="Estadísticas" class="tabcontent"><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  <h4><b>Contenido</b></h4>
<div class="contenido"><h4><a href="#one">Estadísticas por Actividades</a></h4></div>
<div class="contenido"><h4><a href="#two">Estadísticas por Asignaturas</a></h4></div>
<div class="contenido"><h4><a href="#three">Estadísticas por Locales</a></h4></div>
<div class="contenido"><h4><a href="#four">Estadísticas por Usuarios</a></h4></div>
<div class="contenido"><h4><a href="#five">Imprimir gráficos estadísticos</a></h4></div>

<hr>

  <b><h4>Estadísticas</h4></b>
  <p align="justify">Para obtener las estadísticas seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas.</p>
   <center>
  <td><img src="{{ url('images/ayuda/estadisticas1.png') }}"></td></center>
  <br>

  <a name="one"><h4>Estadísticas por Actividades</h4></a>
  <p align="justify">Para obtener las estadísticas por actividad, seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas. Al hacer clic en Ver estadísticas se mostrarán tres gráficos diferentes con los mismos resultados para mejor comprensión de los resultados obtenidos. </p> 
  <center>
  <td><img src="{{ url('images/ayuda/estadisticas.png') }}"></td></center>
  <br>

  <a name="two"><h4>Estadísticas por Asignaturas</h4></a>
  <p align="justify">Para obtener las estadísticas por asignatura, seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas. Al hacer clic en Ver estadísticas se mostrarán tres gráficos diferentes con los mismos resultados para mejor comprensión de los resultados obtenidos.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/estadisticas3.png') }}"></td></center>
  <br>

  <a name="three"><h4>Estadísticas por Locales</h4></a>
  <p align="justify">Para obtener las estadísticas por local, seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas. Al hacer clic en Ver estadísticas se mostrarán tres gráficos diferentes con los mismos resultados para mejor comprensión de los resultados obtenidos.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/estadisticas2.png') }}"></td></center>
  <br>

  <a name="four"><h4>Estadísticas por Usuarios</h4></a>
  <p align="justify">Para obtener las estadísticas por usuario, seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas. Al hacer clic en Ver estadísticas se mostrarán tres gráficos diferentes con los mismos resultados para mejor comprensión de los resultados obtenidos.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/estadisticas4.png') }}"></td></center>
  <br>

  
  <a name="five"><h4>Imprimir gráficos estadísticos</h4></a>
  <p align="justify">Para imprimir las estadísticas, hacemos clic sobre el botón "Guardar como PDF y automáticamente se generará un archivo .pdf desde donde podrá imprimir.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/estadisticas5.png') }}"></td></center>
  <br>
  <center>
   <td><img src="{{ url('images/ayuda/estadisticas6.png') }}"></td></center>
</div>




<!--MÓDULO CONFIGURACIÓN -->
<div id="Configuración" class="tabcontent"><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
    <h4><b>Contenido</b></h4>
<div class="contenido"><h4><a href="#c1">Actividades</a></h4></div>
<div class="contenido"><h4><a href="#c2">Asignaturas</a></h4></div>
<div class="contenido"><h4><a href="#c3">Asuetos</a></h4></div>
<div class="contenido"><h4><a href="#c4">Locales</a></h4></div>
<div class="contenido"><h4><a href="#c5">Suspensiones</a></h4></div>

<hr>
  <a name="c1"><h4>Actividades</h4></a>
  <p align="justify">Para agregar una actividad, hacemos clic en el botón “+ Nueva actividad” y nos aparecerá un pequeño formulario, donde podremos ingresar el nombre de la actividad y luego hacemos clic en el botón guardar.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/3.png') }}"></td></center>
  <br>

  <a name="c2"><h4>Asignaturas</h4></a>
  <p align="justify">Para agregar una asignatura, hacemos clic en el botón “+ Nueva asignatura” y nos aparecerá un pequeño formulario, donde podremos ingresar el código y nombre de la asignatura y luego hacemos clic en el botón guardar.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/1.png') }}"></td></center>
  <br>

  <a name="c3"><h4>Asuetos</h4></a>
  <p align="justify">Para agregar un asueto, hacemos clic en el botón “+ Nuevo Asueto” y nos aparecerá un pequeño formulario, donde podremos ingresar el nombre y la fecha del asueto, luego hacemos clic en el botón guardar y ya se mostrará en la lista de asuetos del ciclo.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/6.png') }}"></td></center>
  <br>

  <a name="c4"><h4>Locales</h4></a>
  <p align="justify">Para agregar un local, hacemos clic en el botón “+ Nuevo local” y nos aparecerá un pequeño formulario, donde podremos ingresar el nombre, la capacidad y una imagen del local (no es obligatoria, sino se ingresa, quedará una imagen por defecto) y luego hacemos clic en el botón guardar, y nos aparecerá la lista de locales agregados.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/4.png') }}"></td></center>
  <br>

   <a name="c5"><h4>Suspensiones</h4></a>
  <p align="justify">Para agregar una suspensión de actividades, hacemos clic en el botón “+ Nueva suspensión” y nos aparecerá un pequeño formulario, donde podremos ingresar fecha, hora de inicio y finalización de la suspensión, luego hacemos clic en el botón guardar, y nos aparecerá la lista de suspensiones.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/suspensiones.png') }}"></td></center>
  <br>
</div>


<!--MÓDULO USUARIOS -->
<div id="Usuarios" class="tabcontent"><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
 <h4><b>Contenido</b></h4>
 <div class="contenido"><h4><a href="#user1">Panel de Administración</a></h4></div>
 <div class="contenido"><h4><a href="#user2">Nuevo Usuario</a></h4></div>
 <div class="contenido"><h4><a href="#user3">Importar usuarios desde Excel</a></h4></div>
 <hr>
 <a name="user1"><h4>Panel de Administración</h4></a>
  <p align="justify">Encontramos un panel de administración donde podemos realizar la gestión de los usuarios que permitiremos que ingresen al sistema, además desde allí podremos seleccionar las diferentes herramientas administrativas</p><hr>
  <center>
  <td><img src="{{ url('images/ayuda/user1.png') }}"></td></center>
  <br>

  <a name="user2"><h4>Nuevo Usuario</h4></a>
  <p align="justify">Para ingresar un nuevo usuario hacemos clic en el botón “+ Nuevo usuario” y nos mostrará un formulario donde ingresaremos los datos personales de la persona, así como también se encuentra la opción de agregar una imagen de perfil (no es obligatoria, si no se ingresa se guardará con la imagen por defecto).</p>
  <center>
  <td><img src="{{ url('images/ayuda/13.png') }}"></td></center>
  <br>
  <p align="justify">Para agregar una imágen de perfil, hacemos clic en "examinar" y seleccionamos nuestra fotografía.</p>
  <center>
  <td><img src="{{ url('images/ayuda/11.png') }}"></td></center>
  <br>

  <a name="user3"><h4>Importar usuarios desde Excel</h4></a>
  <p align="justify">Para importar usuario, se muestra un botón "examinar" y seleccionamos el archivo .xls o .xlsx, automáticamente se importarán los usuarios y nos mostrará un mensaje de éxito. </p>
  <center>
  <td><img src="{{ url('images/ayuda/user2.png') }}"></td></center>
  <br>
</div>
@endsection

@section('sidebar')
    <!-- PANEL DE INFORMACIÓN -->
    @include('ayuda.info-ayuda')
@endsection


@stack('scripts')
<script>
function abrir(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();
</script>
     
