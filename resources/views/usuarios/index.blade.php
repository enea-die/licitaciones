@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Usuarios</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Listado Usuarios</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Listado Usuarios</h3>
            </div>
            @if(Auth::user()->can('crear-usuarios'))
                <a href="{{ url('users/create') }}" class="btn btn-primary align-self-center">Crear Usuario</a>
            @endif
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('listar-usuarios'))
                    <div class="table-responsive">
                        <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="listado_usuarios">
                            <thead>
                                <th>ID</th>
                                <th>Rut</th>
                                <th>Nombre</th>
                                <th>Ap. Paterno</th>
                                <th>Ap. Materno</th>
                                <th>Email</th>
                                <th>Fono</th>
                                <th>Cargo</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php if($list_usuarios){ foreach ($list_usuarios as $row) { ?>
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->rut }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->ap_paterno }}</td>
                                    <td>{{ $row->ap_materno }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->cargo }}</td>
                                    <td>
                                        @if(Auth::user()->can('editar-usuarios'))
                                            <a href="{{ url('users/editar', $row->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                        @endif
                                        @if(Auth::user()->can('eliminar-usuarios'))
                                            <a href="{{ url('users/eliminar', $row->id) }}" onclick="return confirm('Esta seguro que desea eliminar este usuario?')" class="btn btn-danger btn-sm">Eliminar</a>
                                        @endif
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                @else
                    <?php \Alert::message('Usted no tiene privilegios para visualizar los usuarios', 'warning'); ?>
                    {!! Alert::render() !!}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#listado_usuarios').DataTable({
            "language": {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
        });
    });
</script>

@endsection
