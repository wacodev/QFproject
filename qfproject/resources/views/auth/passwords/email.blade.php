@extends('layouts.app')

@section('content')
<center>

            <div class="panel panel-default">
                <div class="panel-heading">Restablecer Contraseña</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">Dirección de Correo Electrónico</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            
                                <button type="submit" class="btn btn-success">
                                    Enviar enlace para reestablecer su contraseña
                                </button>
                        </div>
                    </form>
                </div>
            </div>
          

</center>
@endsection
