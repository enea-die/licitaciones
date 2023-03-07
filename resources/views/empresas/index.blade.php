@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Empresas</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Listado Empresas</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Listado Empresas</h3>
            </div>
            @if(Auth::user()->can('crear-empresas'))
                <a href="{{ url('empresas/create') }}" class="btn btn-primary align-self-center">Crear Empresa</a>
            @endif
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('listar-empresas'))
                    <div class="table-responsive">
                        <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="listado_empresas">
                            <thead>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>RUT</th>
                                <th>Giro</th>
                                <th>Contacto</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php if($list_empresas){ foreach ($list_empresas as $row) { ?>
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nombre }}</td>
                                    <td>{{ $row->rut }}</td>
                                    <td><?php if($row->giro) echo $row->giro->nombre; ?></td>
                                    <td>{{ $row->contacto }}</td>
                                    <td>{{ $row->telefono }}</td>
                                    <td>
                                        @if(Auth::user()->can('editar-empresas'))
                                            <a href="{{ url('empresas/editar', $row->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                        @endif
                                        @if(Auth::user()->can('listar-pgp-empresas'))
                                            <a href="{{ url('empresas/pgp', $row->id) }}" class="btn btn-primary btn-sm">PGP</a>
                                        @endif
                                        @if(Auth::user()->can('listar-plantas-empresas'))
                                            <a href="{{ url('empresas/plantas', $row->id) }}" class="btn btn-primary btn-sm">Plantas</a>
                                        @endif
                                        @if(Auth::user()->can('eliminar-empresas'))
                                            <a href="{{ url('empresas/eliminar', $row->id) }}" onclick="return confirm('Esta seguro que desea eliminar esta empresa?')" class="btn btn-danger btn-sm">Eliminar</a>
                                        @endif
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                @else
                    <?php \Alert::message('Usted no tiene privilegios para visualizar empresas', 'warning'); ?>
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
        $('#listado_empresas').DataTable({
            "language": {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
        });
    });
</script>

@endsection
