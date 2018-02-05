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
    <!-- DATE RANGE PICKER -->
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-timepicker.css') }}" />
@endsection

@section('contenido')

  <div class="box box-success">
    {!! Form::open(['route' => 'ver.usuarios', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  <div class="box-body">
      <div class="form-group{{ $errors->has('fecha') ? ' has-error' : '' }}">
          {!! Form::label('fecha', 'Rango de fechas', ['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-7">
                  <input name="fecha" type="text" class="form-control pull-right" id="fechaRango" required="true" placeholder="mm/dd/yyyy - mm/dd/yyyy">
                  @if ($errors->has('fecha'))
                  <span class="help-block">
                  <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                  {{ $errors->first('fecha') }}
                  </span>
             @endif
                    </div>
                </div>
                </div>
    

     <div class="form-group{{ $errors->has('hora_inicio') ? ' has-error' : '' }}">
                    {!! Form::label('hora_inicio', 'Hora de inicio', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        <div class="bootstrap-timepicker">
                            <input name="hora_inicio" type="text" class="form-control timepicker" value="{{ old('hora_inicio') }}" required="true" placeholder="hh:mm XX">
                        </div>
                        @if ($errors->has('hora_inicio'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('hora_inicio') }}
                                </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('hora_fin') ? ' has-error' : '' }}">
                    {!! Form::label('hora_fin', 'Hora de finalización', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        <div class="bootstrap-timepicker">
                            <input name="hora_fin" type="text" class="form-control timepicker" value="{{ old('hora_fin') }}" required="true" placeholder="hh:mm XX">
                        </div>
                        @if ($errors->has('hora_fin'))
                            <span class="help-block">
                                <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                {{ $errors->first('hora_fin') }}
                            </span>
                        @endif
                    </div>
                </div>
            <div class="box-footer">
                <div class="pull-right">
                    {!! Form::submit('Ver Estadísticas', ['class' => 'btn btn-success']) !!}
                </div>
          </div>
   {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <!-- DATE RANGE PICKER -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <!--  BOOTSTRAP TIME PICKER -->
    <script src="{{ asset('js/bootstrap-timepicker.js') }}"></script>
    <!-- CONTROL PICKER -->
   

    <script>
    $(document).ready(function(){
        $(function(){
          $("#fechaRango").daterangepicker();
        });
    });
    </script>

    <script>
        $(function ()
        {            
           
            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false,
                minuteStep: 60,
                defaultTime: '07:00 AM'
            }).on('changeTime.timepicker',
            function(e)
            {
                //Limitando hora de 7:00 AM a 06:00 PM
                var h = e.time.hours;
                var mer = e.time.meridian;
                if (h != 12) {
                    if (mer == 'AM' && h < 7 || mer == 'PM' && h > 6) $('.timepicker').timepicker('setTime', '07:00 AM');
                }
            });
        })
    </script>

@endpush