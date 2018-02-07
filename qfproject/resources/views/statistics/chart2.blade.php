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
@section('contenido')
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.load('current', {'packages':['bar']});

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
             ['Actividad', 'Reservas'],
         @foreach ($pastel as $pastels)
        ['{{ $pastels->nombre}}', {{$pastels->id}}],
        @endforeach
        ]);
        var options = {
          title: 'Estadísticas de Reserva por Actividades',
          pieHole: 0.4,
        };
        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);


        var data = google.visualization.arrayToDataTable([
        ['Actividad', ' Reservas'],
         @foreach ($pastel as $pastels)
        ['{{ $pastels->nombre}}', {{$pastels->id}}],
        @endforeach
        ]);

        var options = {
          hAxis: {title: 'Actividad', minValue: 0, maxValue: 15},
          vAxis: {title: 'Reservas', minValue: 0, maxValue: 15},
          legend: 'none'
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

        chart.draw(data, options);

  
        var data = new google.visualization.arrayToDataTable([
         ['Actividad', 'Cantidad de Reservas'],
         @foreach ($pastel as $pastels)
        ['{{ $pastels->nombre}}', {{$pastels->id}}],
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
        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
    </script>
  </head>
  <body>
    <div id="donutchart" style="width: 1000px; height: 400px;"></div>
    <hr>
    <div id="chart_div" style="width: 1000px; height: 400px;"></div>
    <hr>
    <div id="top_x_div" style="width: 1000px; height: 300px;"></div>
    
   
  </body>
</html>
@endsection