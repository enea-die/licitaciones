@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Grupos</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Listado Grupos</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Listado Grupos</h3>
            </div>
            @if(Auth::user()->can('crear-grupos'))
                <a href="{{ url('grupos/create') }}" class="btn btn-primary align-self-center">Crear Grupo</a>
            @endif
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('visualizar-dashboard'))
                    <div class="table-responsive">
                        <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="listado_grupos">
                            <thead>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Jefe Operaciones</th>
                                <th>Responsable<br>(Administrador de Terreno)</th>
                                <th>Planificador</th>
                                <th>Contabilidad</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php if($list_grupos){ foreach ($list_grupos as $row) { ?>
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nombre_grupo }}</td>
                                    <td><?php if($row->jefeoperaciones) echo $row->jefeoperaciones->name.' '.$row->jefeoperaciones->ap_paterno; ?></td>
                                    <td><?php if($row->responsable) echo $row->responsable->name.' '.$row->responsable->ap_paterno; ?></td>
                                    <td><?php if($row->planificador) echo $row->planificador->name.' '.$row->planificador->ap_paterno; ?></td>
                                    <td><?php if($row->contabilidad) echo $row->contabilidad->name.' '.$row->contabilidad->ap_paterno; ?></td>
                                    <td>
                                        @if(Auth::user()->can('editar-grupos'))
                                            <a href="{{ url('grupos/editar', $row->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                        @endif
                                        @if(Auth::user()->can('eliminar-grupos'))
                                            <a href="{{ url('grupos/eliminar', $row->id) }}" onclick="return confirm('Esta seguro que desea eliminar este grupo?')" class="btn btn-danger btn-sm">Eliminar</a>
                                        @endif
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                @else
                    <?php \Alert::message('Usted no tiene privilegios para visualizar grupos', 'warning'); ?>
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
        $('#listado_grupos').DataTable({
            "language": {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
        });
    });
</script>

@endsection
