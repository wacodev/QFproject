<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-asignatura">
    <!-- FORMULARIO PARA CREAR UNA NUEVA ASIGNATURA -->
    {!! Form::open(['route' => 'store-asignatura', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
    	<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            x
                        </span>
                    </button>
                    <h4 class="modal-title">
                        Agregar asignatura
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group{{ $errors->has('codigo') ? ' has-error' : '' }}">
                        {!! Form::label('codigo', 'Código', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('codigo', old('codigo'), ['class' => 'form-control', 'placeholder' => 'Código de la asignatura', 'required']) !!}
                            @if ($errors->has('codigo'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('codigo') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                        {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-7">
                            {!! Form::text('nombre', old('nombre'), ['class' => 'form-control', 'placeholder' => 'Nombre de la asignatura', 'required']) !!}
                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                    <i class="fa fa-exclamation-triangle icono-margen" aria-hidden="true"></i>
                                    {{ $errors->first('nombre') }}
                                </span>
                            @endif
                        </div>
                    </div>
            	</div>
            	<div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">
	                    Cancelar
	                </button>
	                {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
            	</div>
            </div>
        </div>
    {!! Form::close() !!}
</div>