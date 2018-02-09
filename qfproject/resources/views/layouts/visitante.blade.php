<!-- PANEL DEL PERFIL DE USUARIO -->
<div class="box box-success">
    <div class="box-body box-profile">
        <a href="{{ url('images/users/' . Auth::user()->imagen) }}" target="_blanck">
            <img src="{{ asset('images/users/' . Auth::user()->imagen) }}" class="profile-user-img img-responsive img-circle" alt="Imagen de usuario">
        </a>
       
        <p class="text-muted text-center">
            {{ Auth::user()->tipo }}
        </p>
        
        <a href="{{ route('reservaciones.paso-uno') }}" class="btn btn-success btn-block">
            Nueva reservación
        </a>
        
    </div>
</div>