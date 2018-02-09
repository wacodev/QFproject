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
          <p>
            Sistema desarrollado por estudiantes de la Facultad de Ingeniería y Arquitectura de la Universidad de El Salvador como proyecto social para la cátedra de Técnicas de Programación para Internet.
          </p>
          <p class="text-muted">
            <small>
              Sistema desarrollado con el framework de código abierto <a href="https://laravel.com/" target="_blanck">Laravel 5</a> de Taylor Otwell bajo los términos descritos en la licencia <a href="https://opensource.org/licenses/MIT/" target="_blanck">MIT</a>.
            </small>
          </p>
          <p class="text-muted">
            <small>
              Este sistema implementa la template de código abierto <a href="https://adminlte.io/" target="_blanck">AdminLTE</a> de Abdullah Almsaeed bajo los términos descritos en la licencia <a href="https://opensource.org/licenses/MIT/" target="_blanck">MIT</a>.
            </small>
          </p>
          <p class="text-muted">
            <small>
              &copy; {{ $anho }}
              <a href="http://www.quimicayfarmacia.ues.edu.sv/" target="_blanck">
                Facultad de Química y Farmacia
              </a>
            </small>
          </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>
