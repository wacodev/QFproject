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
@endsection

@section('contenido')

  <div class="box box-success">
    {!! Form::open(['route' => 'ver.asignaturas', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
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
    <!-- CONTROL PICKER -->
   

    <script>
    $(document).ready(function(){
        $(function(){
          $("#fechaRango").daterangepicker();
        });
    });
    </script>

@endpush