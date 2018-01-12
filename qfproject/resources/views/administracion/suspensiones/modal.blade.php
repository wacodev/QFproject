<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{ $suspension->id }}">
    {!! Form::open(array('action' => array('SuspensionController@destroy', $suspension->id), 'method' => 'delete')) !!}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            x
                        </span>
                    </button>
                    <h4 class="modal-title">
                        ¿Desea eliminar la suspension?
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        Si eliminas la suspensión los usuarios podrán realizar reservaciones en esa fecha y hora.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="submit" class="btn btn-success">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>