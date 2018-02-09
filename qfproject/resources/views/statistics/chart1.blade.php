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


   //SEGUNDO
       var data1 = google.visualization.arrayToDataTable([
             ['Local', 'Reserva'],
         @foreach ($pastel as $pastels)
        ['{{ $pastels->nombre}}', {{$pastels->id}}],
        @endforeach
        ]);
        var options = {
      
          pieHole: 0.4,
        };
        var chart1 = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart1.draw(data1, options);


        //TERCERO

        var data2 = google.visualization.arrayToDataTable([
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
        var chart2 = new google.visualization.ScatterChart(document.getElementById('chart_div'));
        chart2.draw(data2, options);
      






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
    title: 'Estadísticas de Reserva por Locales',
    subtitle: 'Facultad de Química y Farmacia',
    width: 1000
  });
   };



</script>
</head>
<body>
<div>
<center>
<input id="save-pdf" class="boton_personalizado" type="button" value="Guardar como PDF" disabled />
<br>
<div id="piechart" style="width: 1000px; height: 400px;"></div>
<hr>
<div id="donutchart" style="width: 1000px; height: 400px; "></div>
<hr>
<div id="chart_div" style="width: 1000px; height: 400px;"></div>
</div>
</body>
</html>
@endsection

