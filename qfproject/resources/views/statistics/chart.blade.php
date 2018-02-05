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

@section('estilos')
    <!-- BOOTSTRAP DATE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}" />
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
          ['Year', 'Sales'],
          @foreach ($pastel as $pastels)
          ['{{ $pastel-fecha>}}', {{$pastels->cantidad}}],
          @endforeach
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>


  <div class="box-body">
                <div class="form-group{{ $errors->has('fecha') ? ' has-error' : '' }}">
                    {!! Form::label('fecha', 'Rango de fechas', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        <input name="fecha" type="text" class="form-control pull-right" id="reservation" required="true" placeholder="mm/dd/yyyy - mm/dd/yyyy">
                        @if ($errors->has('fecha'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('fecha') }}
                            </span>
                        @endif
                          <a href="" data-target="" data-toggle="modal"><button class ="btn btn-success">Ver estadísticas</button></a>
              
                    </div>
                </div>
  <hr>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
  </body>
</html>
@endsection


@push('scripts')
    <!--  BOOTSTRAP DATE PICKER -->
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <!-- DATE RANGE PICKER -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <!-- CONTROL PICKER -->
    <script>
        $(function ()
        {            
            //Date range picker
            $('#reservation').daterangepicker()
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                daysOfWeekDisabled: [0],
                language: 'es'
            })
        })
    </script>
@endpush