@extends('layouts.principal')

@section('titulo', 'Reservaciones | Nueva reservación')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Nueva reservación')

@section('breadcrumb')
    
    <li><i class="fa fa-ticket icono-margen"></i>Reservaciones</li>
    <li class="active">Nueva reservación</li>

@endsection

@section('contenido')

    <div class="row">
        <div>
            @if ($errors->has('local_id'))
                <div class="alert alert-error alert-dismissible" style="margin-left: 15px; margin-right: 15px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4><i class="fa fa-ban icono-margen-grande" aria-hidden="true"></i>¡Error en ingreso de datos!</h4><p style="padding-left: 30px;">{{ $errors->first('local_id') }}</p>
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Paso 2: Locales disponibles</h3>
                </div>
                {!! Form::open(['route' => 'reservaciones.paso-tres', 'method' => 'GET']) !!}
                    {{ Form::token() }}
                    <div class="box-body">
                        @foreach ($locales_disponibles as $local)
                            <div class="col-sm-6 col-md-4 clearfix">
                                <div class="thumbnail">
                                    @if ($local->imagen != null)
                                        <img src="{{ asset('images/locales/' . $local->imagen) }}" alt="Imagen del local" style="width: 100%; height: 200px;">
                                    @else
                                        <img src="{{ asset('images/locales/local_default.jpg') }}" alt="Imagen del local" style="width: 100%; height: 200px;">
                                    @endif
                                    <div class="caption">
                                        <h4>{{ $local->nombre }}</h4>
                                        <p>Capacidad: {{ $local->capacidad }}</p>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon" style="background-color: #00a65a; border-color: #008d4c; color: #fff;">
                                                <input type="radio" name="local_id" value="{{ $local->id }}">
                                            </span>
                                            <span class="input-group-addon" style="background-color: #00a65a; border-color: #008d4c; color: #fff;">Seleccionar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {!! Form::hidden('fecha', $reservacion->fecha) !!}
                        {!! Form::hidden('hora_inicio', $reservacion->hora_inicio) !!}
                        {!! Form::hidden('hora_fin', $reservacion->hora_fin) !!}
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="{{ route('reservaciones.paso-uno') }}" class="btn btn-default">Cancelar</a>
                            {!! Form::submit('Siguiente', ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @push('scripts')

        <script src="{{ asset('js/pickers-control.js') }}"></script>

    @endpush

@endsection