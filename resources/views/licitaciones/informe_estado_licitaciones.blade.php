@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Licitaciones/Cotizaciones</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Informe Licitaciones/Cotizaciones</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Informe Licitaciones/Cotizaciones</h3>
            </div>
        </div>
        <div class="card-body p-9">
            @if(Auth::user()->can('visualizar-informes'))
                <div class="row mb-7">
                    <h3>Filtro Búsqueda</h3>
                    <form method="POST" action="{{ route('postfiltroinformeestadolicitaciones') }}" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body border-top p-9">
                            <div class="row mb-6">
                                <div class="col-5">
                                    <label class="col-lg-12 col-form-label required fw-bold fs-6">
                                        <span>Rango Fechas</span>
                                    </label>
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="date" name="fechainicio" class="form-control form-control-lg form-control-solid" placeholder="Fecha Inicio" title="Fecha Inicio Rango" value="{{ $fechainicio }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="date" name="fechatermino" class="form-control form-control-lg form-control-solid" placeholder="Fecha Termino" title="Fecha Termino Rango" value="{{ $fechatermino }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="col-lg-12 col-form-label required fw-bold fs-6">
                                        <span>Estado Licitación/Cotización</span>
                                    </label>
                                    <div class="col-lg-12 fv-row fv-plugins-icon-container">
                                        <select name="estadolicitacion" class="form-control">
                                            <option value="">Todos los estados</option>
                                            <?php if($listado_etapas){ foreach ($listado_etapas as $etapa) { ?>
                                            <option value="{{ $etapa->id }}" <?php if($estadolicitacion == $etapa->id) echo "selected"; ?> >{{ $etapa->nombre }}</option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <br><br>
                                    <a href="{{ url('/informes/estadolicitaciones') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Limpiar</button></a>
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mb-7">
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success" onclick="exportToInforme('xls');" style="width:90%">Exportar a Excel</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="listado_licitaciones">
                            <thead>
                                <th>Folio</th>
                                <th>Fecha Creación</th>
                                <th>Fecha Inicio Ejecución</th>
                                <th>Fecha Termino Ejecución</th>
                                <th>Empresa</th>
                                <th>Licitación/Cotización</th>
                                <th>Tipo</th>
                                <th>Empresa</th>
                                <th>Planta</th>
                                <th>Area</th>
                                <th>PGP</th>
                                <th>Valor Cotización</th>
                                <th>Valor Adjudicación</th>
                                <th>Item Personas</th>
                                <th>Item Materiales</th>
                                <th>Item Servicios</th>
                                <th>Responsable (Administrador de Terreno)</th>
                                <th>Etapa</th>
                                <th>Familia</th>
                                <th>Detalles</th>
                            </thead>
                            <tbody>
                                <?php if ($licitaciones) {
                                    foreach ($licitaciones as $row) { ?>
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->fecha_creacion }}</td>
                                            <td>{{ $row->fecha_ejecucion_servicio }}</td>
                                            <td>{{ $row->fecha_termino_servicio }}</td>
                                            <td>{{ $row->empresa->nombre }}</td>
                                            <td>{{ $row->titulo }}</td>
                                            <td>{{ $row->tipo->nombre }}</td>
                                            <td>{{ $row->empresa->nombre }}</td>
                                            <td><?php if($row->planta){ echo $row->planta->nombre; } ?></td>
                                            <td><?php if($row->area){ echo $row->area->nombre; } ?></td>
                                            <td><?php if($row->pgp){ echo $row->pgp->nombre; }else{ echo "N/A"; } ?></td>
                                            <td>${{ number_format($row->monto_cotizacion,0,',','.') }}</td>
                                            <td>${{ number_format($row->monto_adjudicacion,0,',','.') }}</td>
                                            <td>$<?php if ($row->item_personas) { echo number_format($row->item_personas->valor,0,',','.'); } else { echo "0"; } ?></td>
                                            <td>$<?php if ($row->item_materiales) { echo number_format($row->item_materiales->valor,0,',','.'); } else { echo "0"; } ?></td>
                                            <td>$<?php if ($row->item_servicios) { echo number_format($row->item_servicios->valor,0,',','.'); } else { echo "0"; } ?></td>
                                            <td><?php if($row->responsable){ echo $row->responsable->name.' '.$row->responsable->ap_paterno.' '.$row->responsable->ap_materno; } ?></td>
                                            <td>{{ $row->etapa->nombre }}</td>
                                            <td><?php if($row->familia){ echo $row->familia->nombre; } ?></td>
                                            <td>
                                                <a href="{{ url('/licitaciones/continuar', $row->id) }}/proyectoscerrados"><button class="btn btn-primary btn-sm">Gestionar</button></a>
                                            </td>
                                        </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <?php \Alert::message('Usted no tiene privilegios para visualizar los informes de licitaciones', 'warning'); ?>
                {!! Alert::render() !!}
            @endif
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#listado_licitaciones').DataTable({
            "language": {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
        });
    });

    function exportToInforme(type) {
        $('#listado_licitaciones').tableExport({
            filename: 'Informe_Licitaciones_%DD%-%MM%-%YY%',
            format: type,
            excludeCols: '16'
        });
    }
</script>

@endsection
