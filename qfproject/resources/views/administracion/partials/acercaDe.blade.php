<!-- SISTEMA DESARROLLADO POR ELIZABETH RODRÍGUEZ Y WILLIAM COTO -->
<div class="modal fade" id="create">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="btn btn-success" class="close" data-dismiss="modal">
          <span>×</span>
        </button>
        <h4>Acerca de</h4>
      </div>
      <div class="modal-body text-center">
        <img src="{{ url('images/sistema/logo.png') }}"  alt="Logo de la Facultad de Química y Farmacia" class="logo-acerca">
          <p>
            <strong>Sistema de Reservación de Locales</strong>
          </p>
          <div class="text-muted">
            <div class="texto-mini">
              <p>
                Sistema desarrollado por estudiantes de la Facultad de Ingeniería y Arquitectura de la Universidad de El Salvador como proyecto social de la cátedra de Técnicas de Programación para Internet.
              </p>
              <p>
                  Desarrollado con el framework de código abierto <a href="https://laravel.com/" target="_blanck">Laravel</a> de Taylor Otwell bajo los términos descritos en la licencia <a href="https://opensource.org/licenses/MIT/" target="_blanck">MIT</a>.
              </p>
              <p>
                  Este sistema implementa la template <a href="https://adminlte.io/" target="_blanck">AdminLTE</a> de Abdullah Almsaeed bajo los términos descritos en la licencia <a href="https://opensource.org/licenses/MIT/" target="_blanck">MIT</a>.
              </p>
              <p>
                &copy; {{ $anho }}
                <a href="http://www.quimicayfarmacia.ues.edu.sv/" target="_blanck">
                  Facultad de Química y Farmacia
                </a>
              </p>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>
