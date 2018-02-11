@extends('layouts.principal')

@section('titulo', 'Ayuda')

@section('encabezado', 'Ayuda')

@section('breadcrumb')
    <li>
       <i class="fa fa-question-circle icono-margen"></i>
        Ayuda
    </li>
    <li class="active">
        Manual de usuario
    </li>
@endsection

@section('contenido-fila')


<div class="tab">
  <button class="tablinks" onclick="abrir(event, 'Inicio')" id="defaultOpen">Inicio</button>
  <button class="tablinks" onclick="abrir(event, 'Home')">Pantalla Principal</button>
  <button class="tablinks" onclick="abrir(event, 'Reservas')">Reservaciones</button>
  @if (Auth::user()->administrador() || Auth::user()->asistente())
  <button class="tablinks" onclick="abrir(event, 'Reportes')">Reportes</button>
  <button class="tablinks" onclick="abrir(event, 'Estadísticas')">Estadísticas</button>
  @endif
  @if (Auth::user()->administrador())
  <button class="tablinks" onclick="abrir(event, 'Configuración')">Configuración</button>
  <button class="tablinks" onclick="abrir(event, 'Usuarios')">Usuarios</button>
  @endif
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
   <p align="justify">El icono de la bandera permite acceder a las notificaciones por acciones en segundo plano, realizadas generalmente cuando se registran múltiples reservaciones (reservaciones por ciclo, semanales o eliminar algún local, asignatura, etc. de la base de datos). Las notificaciones en color amarillo representan aquellas reservaciones que usted decidió no registrar al realizar una reservación por ciclo. Las notificaciones en color rojo representan aquellas reservaciones que fueron eliminadas en alguna acción que usted realizó, especificamente: eliminar un local, asignatura o actividad y reservaciones que usted decidió eliminar al realizar una reservación por ciclo. El fin de estas notificaciones es informarle de aquellas reservaciones que no pudo registrar o tuvo que eliminar por si en algún momento desea registrarlas en otro local o en otra fecha y hora.</p>  
   <br>
   <center>
   <td><img src="{{ url('images/ayuda/acciones.png') }}" style="width: 400px;"></td></center> 
   <hr> 


   <a name="segundo"><h4>Mis Reservaciones</h4></a> 
   <p align="justify">Aquí se muestran las reservaciones hechas por usted que aún estan vigentes, se pueden buscar por local, fecha, asignatura, hora, etc.</p><br>
  <center>
  <td><img src="{{ url('images/ayuda/21.png') }}"></td></center>
  <br>

  <a name="tercero"><h4>Imprimir Comprobante de Reservación</h4></a> 
  <p align="justify">Como algo adicional al seleccionar la pestaña de la reservación, podrá editar la reservación, eliminarla y ver el comprobante en formato pdf para así poder imprimirlo</p><br>
  <center>
  <td><img src="{{ url('images/ayuda/inicio-menu.png') }}"></td></center>
  <br><br>
  <center>
  <td><img src="{{ url('images/ayuda/comprobante.png') }}"></td></center>
  <br> 
</div>




<!--MÓDULO RESERVACIONES -->
<div id="Reservas" class="tabcontent" ><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  <h4><b>Contenido</b></h4>
<div class="contenido"><h4><a href="#uno">Nueva Reservación de Local</a></h4></div>
<div class="contenido"><h4><a href="#dos">Historial de reservaciones</a></h4></div>
@if (Auth::user()->administrador() || Auth::user()->asistente())
<div class="contenido"><h4><a href="#cuatro">Panel de Administración</a></h4></div>
<div class="sangria"><h4><a href="#cinco">Reservación Individual</a></h4></div>
<div class="sangria"><h4><a href="#seis">Exportar reservaciones a excel</a></h4></div>
<div class="sangria"><h4><a href="#siete">Importar reservaciones a excel</a></h4></div>
<div class="sangria"><h4><a href="#ocho">Reservación por ciclo</a></h4></div>
<div class="sangria"><h4><a href="#nueve">Reservación semanal</a></h4></div>
@endif

<hr>
<a name="uno"><h4>Nueva Reserva de Local</h4></a>
<p align="justify">Para realizar una reserva de locales, se deben realizar cuatro pasos en los cuales se muestran los formularios para seleccionar la hora, local, asignatura, entre otras cosas.</p><br>

<b><p>PASO 1: Fecha y Hora. </p></b>
<p align="justify">Se muestra un formulario en el cual se seleccionará la fecha de la reserva, hora de inicio, hora de finalización y tipo de reservación (ordinaria o extraordinaria), este último campo solo está habilitado para administradores y asistentes de administración, en el caso de los docentes y visitantes la reservación será extraordinaria automáticamente. Si se encuentran reservaciones registradas a la fecha y hora seleccionada, y no hay ningún local disponible se mostrará un mensaje advirtiendo que no hay locales disponibles en ese momento. En este paso se debe tomar en cuenta lo siguiente:</p>
<ul>
  <li>Las reservaciones solo pueden registrarse para tiempo posterior al actual.</li>
  <li>Los locales solo están disponibles para ser reservados entre las 7:00 AM y 6:00 PM</li>
  <li>Solo se pueden realizar reservaciones en horas puntuales, por ejemplo, 8:00 AM, 3:00 PM, etc. pero no así 8:30 AM,  3:17 PM, etc.</li>
  <li>El tiempo mínimo para reservar un local debe ser de una hora.</li>
  <li>Debe tener en cuenta que las reservaciones extraordinarias son aquellas que se realizan de forma espontánea y las ordinarias, aquellas que están previamente planificadas dentro del ciclo. Cada tipo de reservación es sometida a un filtro de validaciones diferente. El filtro de las reservaciones extraordinarias es más exigente, pues no permite realizar una reservación en día de asuetos, suspensiones de actividades y los días domingo; mientras que las ordinarias si lo permiten. En la sección de reservaciones por ciclo se explica la razón de ello.</li>
</ul>
<br>
<center>
<td><img src="{{ url('images/ayuda/7.png') }}"></td></center><br>

<b><p>PASO 2: Locales Disponibles </p></b>
<p align="justify">Se muestra una pantalla con todos los locales que están disponibles, el usuario debe seleccionar el local de acuerdo a la capacidad que necesite</p><br>
<center>
<td><img src="{{ url('images/ayuda/8.png') }}"></td></center><br>

<b><p>PASO 3: Detalles </p></b>
<p align="justify">En este formulario se selecciona el nombre de la asignatura, la actividad a realizar; en estos campos se puede agregar un nuevo elemento, si no se encuentra en la lista, al dar click en "+", también se puede agregar el tema a realizar (este campo no es obligatorio) y como algo adicional el usuario administrador o asistente podrá asignar la reserva a otro usuario si lo desea, en caso de querer realizar la reservación para si mismo no deber llenar ese campo; luego hacer click en el botón “Reservar” y mostrará un mensaje de que la reserva se guardó correctamente. </p>
<center>
<td><img src="{{ url('images/ayuda/9.png') }}"></td></center><br>

<b><p>PASO 4: Descargar comprobante </p></b>
<p align="justify">Por último se da la opción de descargar el comprobante de la reservación que se acaba de realizar y al terminar la descarga dar click en finalizar.</p>
<center>
<td><img src="{{ url('images/ayuda/descargar-comprobante.png') }}" style="width: 400px;"></td></center><br>

<a name="dos"><h4>Historial de reservas</h4></a>
<p align="justify">Aquí se muestran todas las reservas vigentes y expiradas realizadas por el usuario </p> 
<center>
<td><img src="{{ url('images/ayuda/historial.png') }}"></td></center>
<br>

@if (Auth::user()->administrador() || Auth::user()->asistente())
<a name="cuatro"><h4>Panel de Administración</h4></a>
<p align="justify">Aquí podemos observar la lista de reservas realizadas por todos los usuarios del sistema, donde tendremos la opción de ver, editar y eliminar las reservas, así como también eliminar varias reservas a la vez seleccionando cada reserva que queremos eliminar y haciendo click en el botón de eliminar seleccionadas.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/17.png') }}"></td></center>
  <br>

  <b>Opciones del panel Herramientas Adicionales</b>
  <a name="cinco"><h4>Reservación Individual</h4></a>
  <p align="justify">Esta opción nos redirige a <a href="#uno">Nueva Reservación de Local</a></p> 
  <br>

  <a name="seis"><h4>Exportar reservaciones a Excel</h4></a>
  <p align="justify">Para exportar reservaciones debemos seleccionar el rango de fecha y además el local del cual queramos exportar, luego hacer click en el botón de Exportar y automáticamente se descargará el archivo .xls  </p> 
  <center>
  <td><img src="{{ url('images/ayuda/excel1.png') }}"></td>
  <hr>
  <td><img src="{{ url('images/ayuda/excel2.png') }}"></td>
  </center>
  <br>

  <a name="siete"><h4>Importar reservaciones a Excel</h4></a>
  <p align="justify">Para importar reservaciones, nos muestra un botón de examinar en el cual al hacer click podemos seleccionar el archivo .xls o .xlsx a importar</p> 
  <center>
  <td><img src="{{ url('images/ayuda/excel3.png') }}"></td></center>
  <br>
  <p align="justify">El archivo debe tener una cabecera con los siguientes datos: local_id, asignatura_id, actividad_id, fecha, hora_inicio, hora_fin, tema y tipo. El orden de los elementos debe ser respetado. En las primeras tres columnas se coloca el identificador del local, asignatura y actividad respectivamente, luego la fecha, hora de inicio y hora de finalización de la reservación, el campo de tema se puede dejar vacío si se desea y el campo de tipo de reservación debe tener la palabra "Ordinaria" o "Extraordinario" según el caso y debe iniciar en mayúscula. En la imagen puede ver un ejemplo correcto del formato que debe tener el archivo.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/excel-reserva.png') }}" style="width: 400px;"></td></center>
  <br>

  <a name="ocho"><h4>Reservación por ciclo</h4></a>
  <p align="justify">Permite registrar todas las reservaciones ordinarias de un ciclo anterior en uno nuevo. Para ello se muestra un pequeño formulario donde se selecciona el rango de fechas (intervalo que comprende el ciclo), la fecha de inicio del nuevo ciclo y la opción de reservar como propias o dejar el propietario anterior en las nuevas reservaciones. Acá es importante destacar que el día de la semana debe coincidir en la fecha del limite inferior del rango de fechas y la fecha de inicio de ciclo para evitar que las reservaciones traslapen y genere errores. Por ejemplo, el sistema no permitirá que se seleccione un día martes en el limite inferior del rango de fechas mientras que el día de la fecha de inicio de ciclo es miércoles, ambos deben ser ya sea martes o miércoles pero no días distintos.</p>
  <p align="justify">En esta herramienta se destaca la importancia del tipo de reservación, ya que aquí solo se toman en cuenta aquellas que son ordinarias. Debido a que este tipo de reservaciones son reutilizadas en nuevos ciclos, el sistema permite que éstas sean registradas en días de asueto, suspensión de actividades e incluso los días domingo, con el fin de que en un ciclo futuro no genere huecos. Esto se puede entender mejor explicando el funcionamiento de esta herramienta.</p>
  <p align="justify">El sistema toma todas las reservaciones que se encuentran comprendidas en el rango de fechas, luego obtiene la diferencia de días entre la fecha inicial del nuevo ciclo y la fecha del limite inferior del rango de fechas, posteriormente suma esa diferencia de días a la fecha original de la reservación, es así como se obtiene la fecha futura y la otra información de la reservación original se deja igual.</p>
  <center>
  <td><img src="{{ url('images/ayuda/reserva-ciclo.png') }}"></td></center>
  <br>
  <p align="justify">Si se diera el caso que hay reservaciones en el rango de fechas del nuevo ciclo que choquen con las que se están registrando con esta herramienta, el sistema le dirigirá a una pantalla con todas aquellas reservaciones que tienen conflictos de choques para que dicida si registrar la suya y eliminar la que ya estaba o no registrarla y conservar la que ya estaba. Posteriormente las acciones que haya tomado en esta sección serán registradas en las notificaciones de acción (icono de la bandera). Los registros de color amarillo serán sus reservaciones que no fueron registradas y las de color rojo las que ya existían y fueron eliminadas para registrar la suya.</p>
  <center>
  <td><img src="{{ url('images/ayuda/choques.png') }}" style="width: 400px;"></td></center>
  <br>

  <a name="nueve"><h4>Reservaciones semanales</h4></a>
  <p align="justify">Aquí podemos realizar reservas con frecuencia de cada semana o cada dos semanas, para un tiempo determinado. Para ello se realizan una serie de pasos.</p><br> 
  <b>PASO 1: Fecha y hora</b>
  <p align="justify">Seleccionamos la fecha inicial, hora de inicio y finalización de la reservación, la frecuencia y el número de semanas en que se quiere reservar. En esta herramienta las reservaciones siempre son de tipo ordinaria.</p>
  <center>
  <td><img src="{{ url('images/ayuda/semanal.png') }}"></td></center>
  <br>

  <b>PASO 2: Locales Disponibles</b>
  <p align="justify">Seleccionamos el local de acuerdo a la capacidad que se requiera.</p>
  <center>
  <td><img src="{{ url('images/ayuda/semanal2.png') }}"></td></center>
  <br>

  <b>PASO 3: Detalles</b>
  <p align="justify">Se completa el pequeño formulario seleccionando el nombre la asignatura, la actividad a realizar; en estos campos se puede agregar un nuevo elemento, si no se encuentra en la lista, al dar click en "+", también se puede agregar el tema a realizar (este campo no es obligatorio) y como algo adicional podrá asignar la reserva a otro usuario si lo desea; luego hacer click en el botón “Reservar” y mostrará un mensaje de que la reserva se guardó correctamente.</p>
  <center>
  <td><img src="{{ url('images/ayuda/semanal3.png') }}"></td></center>
  <br>
@endif

</div>




<!--MÓDULO REPORTES -->
<div id="Reportes" class="tabcontent"><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <h4><b>Contenido</b></h4>
<div class="contenido"><h4><a href="#cero0">Reservas próximas</a></h4></div>
<div class="contenido"><h4><a href="#uno1">Reporte de reservaciones en horario</a></h4></div>
<div class="contenido"><h4><a href="#dos2">Programación por actividad</a></h4></div>
<div class="contenido"><h4><a href="#tres3">Reporte de reservaciones de un usuario</a></h4></div>
<div class="contenido"><h4><a href="#cuatro4">Reporte de ocupación de espacio físico</a></h4></div>

<hr>
  <a name="cero0"><h4>Reservas próximas</h4></a>
  <p align="justify">Al hacer clic sobre esta opción automáticamente se genera un pdf con la lista de reservas del siguiente día</p> 
  <center>
  <td><img src="{{ url('images/ayuda/19.png') }}"></td></center>
  <br>
  <a name="uno1"><h4>Reporte de reservaciones en horario</h4></a>
  <p align="justify">Para obtener un reporte de las reservaciones en formato de horario, seleccionamos la semana, y el local y hacemos click en el botón de Aceptar, y automáticamente nos generará un pdf con el horario de la semana para ese local seleccionado. </p> 
  <center>
  <td><img src="{{ url('images/ayuda/horarios.png') }}"></td></center>
  <br>
  <center>
  <td><img src="{{ url('images/ayuda/horarios2.png') }}"></td></center>
  <br>
  <a name="dos2"><h4>Programación por actividad</h4></a>
  <p align="justify">Para obtener una lista de reservaciones filtrada las actividades realizadas en una asignatura específica, seleccionamos el rango de fechas, la asignatura y la actividad, al hacer clic en Aceptar, se generará automáticamente la lista de reservas en el rango de fechas seleccionado. </p> 
  <center>
  <td><img src="{{ url('images/ayuda/actividad1.png') }}"></td></center>
  <br>
  <center>
  <td><img src="{{ url('images/ayuda/actividad2.png') }}"></td></center>
  <br>
  <a name="tres3"><h4>Reporte de reservaciones de un usuario</h4></a>
  <p align="justify">Para obtener una lista de reservaciones realizadas por un usuario específico en un determinado periodo de tiempo, seleccionamos el rango de fechas y el usuario, al hacer clic en Aceptar, se generará automáticamente la lista de reservas en el rango de fechas seleccionado.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/form-reporte-usuario.png') }}" style="width: 400px;"></td></center>
  <br>
  <center>
  <td><img src="{{ url('images/ayuda/reporte-usuario.png') }}" style="width: 400px;"></td></center>
  <br>
  <a name="cuatro4"><h4>Reporte de ocupación de espacio físico</h4></a>
  <p align="justify">Este reporte presenta el porcentaje de ocupación por bloque de clase de un local en un intervalo de fechas dado. Para obtener el informe, seleccionamos el rango de fechas y el local, al hacer clic en Aceptar, se generará automáticamente el reporte de ocupación de espacio físico en el rango de fechas seleccionado.</p> 
  <p align="justify">La información se obtiene contando el número de reservaciones realizadas en cada bloque de horas y dividiendo dicho número con la cantidad de días que hay en el rango de fechas ingresado.</p>
  <center>
  <td><img src="{{ url('images/ayuda/ocupacion.png') }}" style="width: 400px;"></td></center>
  <br>
  <center>
  <td><img src="{{ url('images/ayuda/ocupacion-reporte.png') }}" style="width: 400px;"></td></center>
</div>



<!--MÓDULO ESTADÍSTICAS -->

<div id="Estadísticas" class="tabcontent"><span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  <h4><b>Contenido</b></h4>
<div class="contenido"><h4><a href="#one">Estadísticas por Actividades</a></h4></div>
<div class="contenido"><h4><a href="#two">Estadísticas por Asignaturas</a></h4></div>
<div class="contenido"><h4><a href="#three">Estadísticas por Locales</a></h4></div>
<div class="contenido"><h4><a href="#four">Estadísticas por Usuarios</a></h4></div>

<hr>

  <b><h4>Estadísticas</h4></b>
  <p align="justify">Para obtener las estadísticas seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas.</p>
   <center>
  <td><img src="{{ url('images/ayuda/estadisticas1.png') }}"></td></center>
  <br>

  <a name="one"><h4>Estadísticas por Actividades</h4></a>
  <p align="justify">Para obtener las estadísticas por actividad, seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas. Al hacer click en Ver estadísticas se mostrarán tres gráficos diferentes con los mismos resultados para mejor comprensión de los resultados obtenidos. </p> 
  <center>
  <td><img src="{{ url('images/ayuda/estadisticas.png') }}"></td></center>
  <br>

  <a name="two"><h4>Estadísticas por Asignaturas</h4></a>
  <p align="justify">Para obtener las estadísticas por asignatura, seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas. Al hacer click en Ver estadísticas se mostrarán tres gráficos diferentes con los mismos resultados para mejor comprensión de los resultados obtenidos.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/estadisticas3.png') }}"></td></center>
  <br>

  <a name="three"><h4>Estadísticas por Locales</h4></a>
  <p align="justify">Para obtener las estadísticas por local, seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas. Al hacer click en Ver estadísticas se mostrarán tres gráficos diferentes con los mismos resultados para mejor comprensión de los resultados obtenidos.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/estadisticas2.png') }}"></td></center>
  <br>

  <a name="four"><h4>Estadísticas por Usuarios</h4></a>
  <p align="justify">Para obtener las estadísticas por usuario, seleccionamos el rangos de fechas y la hora de inicio de finalización de la cual se requiera ver las estadísticas. Al hacer click en Ver estadísticas se mostrarán tres gráficos diferentes con los mismos resultados para mejor comprensión de los resultados obtenidos.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/estadisticas4.png') }}"></td></center>
  <br>
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
  <p align="justify">Para agregar una actividad, hacemos click en el botón “+ Nueva actividad” y nos aparecerá un pequeño formulario, donde podremos ingresar el nombre de la actividad y luego hacemos click en el botón guardar.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/3.png') }}"></td></center>
  <br>

  <a name="c2"><h4>Asignaturas</h4></a>
  <p align="justify">Para agregar una asignatura, hacemos click en el botón “+ Nueva asignatura” y nos aparecerá un pequeño formulario, donde podremos ingresar el código y nombre de la asignatura y luego hacemos click en el botón guardar.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/1.png') }}"></td></center>
  <br>

  <a name="c3"><h4>Asuetos</h4></a>
  <p align="justify">Para agregar un asueto, hacemos click en el botón “+ Nuevo Asueto” y nos aparecerá un pequeño formulario, donde podremos ingresar el nombre y la fecha del asueto, luego hacemos click en el botón guardar y ya se mostrará en la lista de asuetos del ciclo.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/6.png') }}"></td></center>
  <br>
  <p align="justify">También se tiene la opción en el panel de herramientas adicionales de registrar periodos de vacaciones de una forma sencilla y rápida. Simplemente se coloca el nombre de la vacación y se selecciona el rango de fechas que comprende a la misma. Importante, las vaciones al igual que los asuetos se utilizan para impedir que los usuarios reserven en esos días, pero como se sabe, los periodos de vacaciones cambían levemente de un año a otro y por ello es necesario que borre y/o agregue los días que corresponden de las vacaciones de acuerdo al año actual.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/vacaciones.png') }}" style="width: 400px;"></td></center>
  <br>

  <a name="c4"><h4>Locales</h4></a>
  <p align="justify">Para agregar un local, hacemos click en el botón “+ Nuevo local” y nos aparecerá un pequeño formulario, donde podremos ingresar el nombre, la capacidad y una imagen del local (no es obligatoria, sino se ingresa, quedará una imagen por defecto) y luego hacemos clic en el botón guardar, y nos aparecerá la lista de locales agregados.</p> 
  <center>
  <td><img src="{{ url('images/ayuda/4.png') }}"></td></center>
  <br>

   <a name="c5"><h4>Suspensiones</h4></a>
  <p align="justify">Para agregar una suspensión de actividades, hacemos click en el botón “+ Nueva suspensión” y nos aparecerá un pequeño formulario, donde podremos ingresar fecha, hora de inicio y finalización de la suspensión, luego hacemos click en el botón guardar, y nos aparecerá la lista de suspensiones.</p> 
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
  <p align="justify">Para ingresar un nuevo usuario hacemos click en el botón “+ Nuevo usuario” y nos mostrará un formulario donde ingresaremos los datos personales del usuario, así como también se encuentra la opción de agregar una imagen de perfil (no es obligatoria, si no se ingresa se guardará con la imagen por defecto).</p>
  <center>
  <td><img src="{{ url('images/ayuda/13.png') }}"></td></center>
  <br>
  <p align="justify">Para agregar una imágen de perfil, hacemos click en "examinar" y seleccionamos nuestra fotografía.</p>
  <center>
  <td><img src="{{ url('images/ayuda/11.png') }}"></td></center>
  <br>

  <a name="user3"><h4>Importar usuarios desde Excel</h4></a>
  <p align="justify">Para importar usuario, se muestra un botón "examinar" y seleccionamos el archivo .xls o .xlsx, automáticamente se importarán los usuarios y nos mostrará un mensaje de éxito. </p>
  <center>
  <td><img src="{{ url('images/ayuda/user2.png') }}"></td></center>
  <br>
  <p align="justify">El archivo debe tener una cabecera con los siguientes datos: name, lastname, email, password y tipo. El orden de los elementos debe ser respetado. En la imagen puede ver un ejemplo correcto del formato que debe tener el archivo.</p>
  <center>
  <td><img src="{{ url('images/ayuda/excel-usuarios.png') }}" style="width: 400px;"></td></center>
  <br>
</div>
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
     
