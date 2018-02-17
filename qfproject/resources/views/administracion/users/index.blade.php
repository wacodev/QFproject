@extends('layouts.principal')

@section('titulo', 'Usuarios')

@section('encabezado', 'Usuarios')

@section('subencabezado', 'Panel de administración')

@section('breadcrumb')
    <li>
        <i class="fa fa-users icono-margen active"></i>
        Usuarios
    </li>
    <li class="active">
        Panel de administración
    </li>
@endsection

@section('contenido')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">
                Panel de administración
            </h3>
        </div>
        <div class="box-body">
            <!-- BARRA DE BÚSQUEDA Y BOTÓN PARA NUEVO USUARIO -->
            @include('administracion.users.search')
            <!-- LISTADO DE USUARIOS -->
            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover tabla-quitar-margen">
                        <thead>
                            <tr>
                                <th>ID</th>
                                 <th>Nombre</th>
                                <th>Username</th>
                                <th>Tipo</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="id-size">
                                        {{ $user->id }}
                                    </td>
                                   
                                    <td>
                                        {{ $user->name }} {{ $user->lastname }}
                                    </td>
                                    <td>
                                        {{ $user->username}}
                                    </td>
                                    <td class="tipo-size">
                                        {{ $user->tipo }}
                                    </td>
                                    <td class="opc-size">
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-default">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-default">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                        </a>
                                        <a href="" data-target="#modal-delete-{{ $user->id }}" data-toggle="modal" class="btn btn-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- MODAL PARA CONFIRMAR ELIMINACIÓN DE ACTIVIDAD -->
                                @include('administracion.users.modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            <!-- MOSTRAR CUANDO NO HAY ACTIVIDADES -->
            @else
                <div class="text-center">
                    <i class="fa fa-frown-o fa-5x verde-claro" aria-hidden="true"></i>
                    <h4 class="verde-claro">
                        No se encontraron usuarios
                    </h4>
                </div>
            @endif
        </div>     
        <div class="box-footer clearfix">
            <div class="text-center">
                <!-- PAGINACIÓN -->
                {!! $users->render() !!}
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <!-- MENÚ DE HERRAMIENTAS ADICIONALES PARA USUARIOS -->
    @include('administracion.partials.herr-usuarios')
    <!-- MENÚ DE HERRAMIENTAS PARA LA GESTIÓN ADMINISTRATIVA -->
    @include('administracion.partials.herramientas')
    <!-- AYUDA DE USUARIOS -->
    @include('administracion.partials.info-usuarios')
@endsection