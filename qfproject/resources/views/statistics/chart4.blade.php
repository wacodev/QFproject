@extends('layouts.principal')

@section('titulo', 'Estadísticas')

@section('encabezado', 'Estadísticas')

@section('subencabezado', 'Gráficos Estadísticos')

@section('breadcrumb')
    <li>
        <i class="fa fa-bar-chart"></i>
        Estadísticas
    </li>
    
@endsection

@section ('estilos')
<style type="text/css">
  .boton_personalizado{
    text-decoration: none;
    padding:5px;
    font-weight: 12;
    font-size: 12px;
    background-color: gray;
    border-radius: 6px;
  }
</style>
@endsection


@section('contenido')
<html>
  <head>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Asignaturas', 'Cantidad de Reservas'],
          @foreach ($pastel as $pastels)
        ['{{ $pastels->name}}', {{$pastels->id}}],
        @endforeach
        ]);
        var options = {
          title: 'Estadísticas de Reserva por Usuarios',
          is3D: true,
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);


        var data = google.visualization.arrayToDataTable([
        ['Local', 'Reserva'],
         @foreach ($pastel as $pastels)
        ['{{ $pastels->name}}', {{$pastels->id}}],
        @endforeach
        ]);

        var options = {
          title: '',
          hAxis: {title: 'Usuarios', minValue: 0, maxValue: 2000},
          vAxis: {title: 'Reservas', minValue: 0, maxValue: 2000},
          legend: 'none'
        };

        var chart2 = new google.visualization.ScatterChart(document.getElementById('chart_div'));

        chart2.draw(data, options);


         var data = new google.visualization.arrayToDataTable([
         ['Usuario', 'Cantidad de Reservas'],
         @foreach ($pastel as $pastels)
        ['{{ $pastels->name}}', {{$pastels->id}}],
        @endforeach
        ]);

        var options = {
 
          width: 1000,
          height: 200,
          legend: { position: 'none' },
          chart: { title: '' },
          bars: 'horizontal', 
          axes: {
            x: {
              0: { side: 'top', label: 'Reservas'} 
            }
          },
          bar: { groupWidth: "10%" }
        };
        var chart1 = new google.charts.Bar(document.getElementById('top_x_div'));
        chart1.draw(data, options);
      


var btnSave = document.getElementById('save-pdf');

  google.visualization.events.addListener(chart, 'ready', function () {
    btnSave.disabled = false;
  });

  btnSave.addEventListener('click', function () {
    var doc = new jsPDF();

    doc.addImage(chart.getImageURI(), 0, 0);
 
    doc.save('gráfico.pdf');
  }, false);

  chart.draw(data, {
    chartArea: {
      bottom: 24,
      left: 100,
      right: 12,
      top: 48,
      width: '100%',
      height: '100%'

    },
    height: 400,
    title: 'Estadísticas de Reserva por Usuarios',
    subtitle: 'Facultad de Química y Farmacia',
    width: 1000
  });
   };


    </script>
  </head>
  <body>
    <input id="save-pdf" class="boton_personalizado" type="button" value="Guardar como PDF" disabled /><br>
    <div id="piechart_3d" style="width: 1000px; height: 400px;"></div>
    <hr>
    <div id="chart_div" style="width: 1000px; height: 400px;"></div>
    <hr>
    <div id="top_x_div" style="width: 1000px; height: 300px;"></div>

  </body>
</html>
@endsection