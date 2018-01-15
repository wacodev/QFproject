@extends('layouts.principal')

@section('titulo', 'Estadísticas')

@section('encabezado', 'Estadísticas')

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
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Asignaturas', 'Cantidad de Reservas'],
          @foreach ($barra as $barras)
        ['{{ $barras->asignatura}}', {{$barras->cantidad}}],
        @endforeach
          
        ]);

        var options = {
          title: 'Estadísticas de Reserva por Asignaturas',
          width: 700,
          legend: { position: 'none' },
          chart: { title: 'Estadísticas de Reserva por Asignaturas' },
          bars: 'horizontal', 
          axes: {
            x: {
              0: { side: 'top', label: 'Cantidad de Reservas'} 
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
    <div id="top_x_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>
@endsection