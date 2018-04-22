<!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">
            Herramientas administrativas
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li>
                <a href="{{ route('actividades.index') }}">
                    Actividades
                </a>
            </li>
            <li>
                <a href="{{ route('asignaturas.index') }}">
                    Asignaturas
                </a>
            </li>
            <li>
                <a href="{{ route('asuetos.index') }}">
                    Asuetos
                </a>
            </li>
            <li>
                <a href="{{ route('locales.index') }}">
                    Locales
                </a>
            </li>
            <li>
                <a href="{{ route('suspensiones.index') }}">
                    Suspensiones
                </a>
            </li>
            @if (Auth::user()->administrador())
                <li>
                    <a href="{{ route('users.index') }}">
                        Usuarios
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>