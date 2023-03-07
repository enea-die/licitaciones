@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Tipo Licitaciones</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Listado Tipo Licitaciones</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Listado Tipo Licitaciones</h3>
            </div>
            <a href="{{ url('tipolicitaciones/create') }}" class="btn btn-primary align-self-center">Crear Tipo Licitación</a>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <div class="table-responsive">
                    <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="listado_tipo_licitaciones">
                        <thead>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            <?php if($list_tipo_licitaciones){ foreach ($list_tipo_licitaciones as $row) { ?>
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->nombre }}</td>
                                <td><?php if($row->estado == 1) echo "Activo"; else echo "Inactivo"; ?></td>
                                <td>
                                    <a href="{{ url('tipolicitaciones/editar', $row->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                    <a href="{{ url('tipolicitaciones/eliminar', $row->id) }}" onclick="return confirm('Esta seguro que desea eliminar este tipo de licitacion?')" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#listado_tipo_licitaciones').DataTable({
            "language": {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
        });
    });
</script>

@endsection
