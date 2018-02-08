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
      google.charts.load('current', {'packages':['bar']});
      google.charts.load('current', {'packages':['corechart']});

      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
              ['NOMBRE', 'CANTIDAD'],
        @foreach ($pastel as $pastels)
        ['{{ $pastels->nombre}}', {{$pastels->id}}],
        @endforeach
        ])
        var options = {
          title: 'Estadísticas de Reserva por Locales'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);


        var data = google.visualization.arrayToDataTable([

             ['Local', 'Reserva'],
         @foreach ($pastel as $pastels)
        ['{{ $pastels->nombre}}', {{$pastels->id}}],
        @endforeach
        ]);
        var options = {
      
          pieHole: 0.4,
        };
        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);


        var data = google.visualization.arrayToDataTable([
        ['Local', 'Reserva'],
         @foreach ($pastel as $pastels)
        ['{{ $pastels->nombre}}', {{$pastels->id}}],
        @endforeach
        ]);

        var options = {
          title: 'Reservas por locales',
          hAxis: {title: 'Local', minValue: 0, maxValue: 2500},
          vAxis: {title: 'Cantidad de Reservas', minValue: 0, maxValue: 2500},
          legend: 'none'
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }


    </script>
  </head>
  <body>
<div>
    <div id="piechart" style="width:1000px; height: 400px; "></div>
    <hr>
    <div id="donutchart" style="width: 1000px; height: 400px; "></div>
    <hr>
    <div id="chart_div" style="width: 1000px; height: 400px;"></div>
  </div>
  </body>
</html>
@endsection


