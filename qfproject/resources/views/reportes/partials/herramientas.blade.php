<!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">
            Reportes
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
                <a href="{{ route('reportes.exportar-horarios') }}">
                    Horarios
                </a>
            </li>
            <li>
                <a href="{{ route('reportes.exportar-reporte-ocupacion') }}">                    
                    Ocupación de locales
                </a>
            </li>
            <li>
                <a href="{{ route('reportes.exportar-lista-actividad') }}">
                    Programación por actividad
                </a>
            </li>
            <li>
                <a href="{{ route('reportes.exportar-lista-usuario') }}">
                    Reservas por usuario
                </a>
            </li>
            <li>
                <a href="{{ route('reportes.reservacion-lista') }}" target="_blanck">
                    <small class="label pull-right bg-red">PDF</small>
                    Reservas próximas
                </a>
            </li>
        </ul>
    </div>
</div>