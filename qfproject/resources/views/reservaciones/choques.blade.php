@extends('layouts.principal')

@section('titulo', 'Reservaciones | Nuevo ciclo')

@section('encabezado', 'Reservaciones')

@section('subencabezado', 'Nuevo ciclo')

@section('breadcrumb')
    <li>
        <i class="fa fa-ticket icono-margen"></i>
        Reservaciones
    </li>
    <li class="active">
        Nuevo ciclo
    </li>
@endsection

@section('contenido')    
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Choques
            </h3>
        </div>
        {!! Form::open(['route' => 'reservaciones.choques', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <p class="text-justify">
                    Marque si desea registrar su reservación, esto hará que el sistema elimine aquellas reservaciones que chocan con la suya.
                </p>
                @for ($i = 0; $i < count($reservaciones_p); $i++)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                Tú reservación:
                            </p>
                            <div class="well well-sm well-parrafo">
                                <p>
                                    <strong>
                                        Local:
                                    </strong>
                                    {{ $reservaciones_p[$i][0]->local->nombre }}
                                    &nbsp;&#8226;&nbsp;
                                    <strong>
                                        Fecha:
                                    </strong>
                                    {{ \Carbon\Carbon::parse($reservaciones_p[$i][0]->fecha)->format('d/m/Y') }}
                                    &nbsp;&#8226;&nbsp;
                                    <strong>
                                        Hora:
                                    </strong>
                                    {{ \Carbon\Carbon::parse($reservaciones_p[$i][0]->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservaciones_p[$i][0]->hora_fin)->format('h:i A') }}
                                </p>
                            </div>
                            <p>
                                Choca con las siguientes reservaciones:
                            </p>
                            @for ($j = 1; $j < count($reservaciones_p[$i]); $j++)
                            <div class="well well-sm well-parrafo">
                                <p>
                                    <strong>
                                        Usuario:
                                    </strong>
                                    {{ $reservaciones_p[$i][$j]->user->name }} {{ $reservaciones_p[$i][$j]->user->lastname }}
                                    &nbsp;&#8226;&nbsp;
                                    <strong>
                                        Local:
                                    </strong>
                                    {{ $reservaciones_p[$i][$j]->local->nombre }}
                                    &nbsp;&#8226;&nbsp;
                                    <strong>
                                        Fecha:
                                    </strong>
                                    {{ \Carbon\Carbon::parse($reservaciones_p[$i][$j]->fecha)->format('d/m/Y') }}
                                    &nbsp;&#8226;&nbsp;
                                    <strong>
                                        Hora:
                                    </strong>
                                    {{ \Carbon\Carbon::parse($reservaciones_p[$i][$j]->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($reservaciones_p[$i][$j]->hora_fin)->format('h:i A') }}
                                </p>
                            </div>
                            @endfor
                            <div class="seleccionar">
                                <input type="checkbox" name="seleccionadas[]" value="{!! $i !!}">
                                <span>
                                    Registrar mi reservación
                                </span>
                            </div>
                        </div>
                    </div>
                @endfor
                @foreach ($reservaciones_p as $rp)
                    @foreach ($rp as $r)
                        @if ($r->id)
                            {!! Form::hidden('r[]', $r->codigo . ',-:' . $r->id) !!}
                        @else
                            {!! Form::hidden('r[]', $r->codigo . ',-:' . $r->user_id . ',-:' . $r->local_id . ',-:' . $r->asignatura_id . ',-:' . $r->actividad_id . ',-:' . $r->fecha . ',-:' . $r->hora_inicio . ',-:' . $r->hora_fin . ',-:' . $r->tema . ',-:' . $r->tipo) !!}
                        @endif
                    @endforeach
                @endforeach
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    {!! Form::submit('Aceptar', ['class' => 'btn btn-success', 'id' => 'boton']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA LAS RESERVACIONES -->
    @include('reservaciones.partials.herramientas')
    <!-- AYUDA DE LA RESERVACIÓN POR CICLO -->
    @include('reservaciones.partials.info-crear-ciclo')
@endsection