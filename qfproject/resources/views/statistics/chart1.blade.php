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
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
@endsection


