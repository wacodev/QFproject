{!! Form::open(array('url' => 'administracion/asuetos', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search')) !!}
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-btn">
                <a href="{{ route('asuetos.create') }}" class="btn btn-success"><i class="fa fa-plus icono-margen"></i>Nuevo asueto</a>
            </span>
            <input type="text" class="form-control" name="searchText", placeholder="Buscar", value="{{ $searchText }}"></input>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
            </span>
        </div>
    </div>
{!! Form::close() !!}