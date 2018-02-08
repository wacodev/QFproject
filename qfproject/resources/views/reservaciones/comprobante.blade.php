@extends('layouts.principal')

@section('titulo', 'Reservaciones | Nueva reservación')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Nueva reservación')

@section('breadcrumb')
    <li>
        <i class="fa fa-ticket icono-margen"></i>
        Reservaciones
    </li>
    <li class="active">
        Nueva reservación
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Paso 4: Descargar comprobante
            </h3>
        </div>
        {!! Form::open(['route' => 'reservaciones.comprobante', 'autocomplete' => 'off', 'method' => 'GET']) !!}
            <div class="box-body">
                <div class="text-center">
                    <i class="fa fa-cloud-download fa-5x verde-claro" aria-hidden="true"></i>
                    <br>
        	        {!! Form::submit('Descargar comprobante', ['class' => 'btn btn-success']) !!}
                </div>
                @foreach ($rc as $r)
                    {!! Form::hidden('reservaciones[]', $r) !!}
                @endforeach
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    @if (Auth::user()->administrador() || Auth::user()->asistente())
                        <a href="{{ route('reservaciones.index') }}" class="btn btn-default">
                    @else
                        <a href="{{ route('home') }}" class="btn btn-default">
                    @endif
                            Finalizar
                        </a>
        	    </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection