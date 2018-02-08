@extends('layouts.principal')

@section('titulo', 'Ayuda')

@section('estilos')
    <!-- BOOTSTRAP DATE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
    <!-- BOOTSTRAP TIME PICKER -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-timepicker.css') }}" />

    <style>
* {box-sizing: border-box}
body {font-family: "Lato", sans-serif;}

/* Style the tab */
.tab {
    float: left;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 30%;
    height: 300px;
}

/* Style the buttons inside the tab */
.tab button {
    display: block;
    background-color: inherit;
    color: black;
    padding: 22px 16px;
    width: 100%;
    border: none;
    outline: none;
    text-align: left;
    cursor: pointer;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    float: left;
    padding: 0px 12px;
    border: 1px solid #ccc;
    width: 70%;
    border-left: none;
    height: 300px;
}
</style>
@endsection

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
    <p>Menú</p>

<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'Evento1')">Reservaciones</button>
  <button class="tablinks" onclick="openCity(event, 'Evento2')">Reportes</button>
  <button class="tablinks" onclick="openCity(event, 'Evento3')">Estadísticas</button>
  <button class="tablinks" onclick="openCity(event, 'Evento4')">Configuración</button>
</div>

<div id="Evento1" class="tabcontent">
  <h3>Reservaciones</h3>
  <p>London is the capital city of England.</p>
</div>

<div id="Evento2" class="tabcontent">
  <h3>Reportes</h3>
  <p>Paris is the capital of France.</p> 
</div>

<div id="Evento3" class="tabcontent">
  <h3>Estadísticas</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>

<div id="Evento4" class="tabcontent">
  <h3>Configuración</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>
 
@endsection

 @stack('scripts')
 <script>
function openCity(evt, cityName) {
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