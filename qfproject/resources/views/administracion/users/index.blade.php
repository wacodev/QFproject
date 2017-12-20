@extends('layouts.principal')

@section('titulo', 'Usuarios')

@section('encabezado', 'Usuarios')

@section('breadcrumb')
    
    <li><i class="fa fa-users icono-margen active"></i>Usuarios</li>
    
@endsection

@section('contenido')
    
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Usuarios</h3>
                </div>
                <div class="box-body">
                    @include('administracion.users.search')
                    @if ($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover tabla-quitar-margen">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Carnet</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="id-size" style="vertical-align: middle;">{{ $user->id }}</td>
                                            <td class="codigo-size" style="vertical-align: middle;">{{ $user->carnet }}</td>
                                            <td style="vertical-align: middle;">{{ $user->name }} {{ $user->lastname }}</td>
                                            <td class="tipo-size" style="vertical-align: middle;">{{ $user->tipo }}</td>
                                            <td class="opc-size">
                                                <div class="btn-group btn-group-justified" role="group">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-default"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-default"><i class="fa fa-wrench" aria-hidden="true"></i></a>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <a href="" data-target="#modal-delete-{{ $user->id }}" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('administracion.users.modal')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="text-center">
                                {!! $users->render() !!}
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                            <h4 class="verde-claro">No se encontraron usuarios</h4>
                        </div>
                    @endif
                </div>     
            </div>
        </div>
    </div>

@endsection