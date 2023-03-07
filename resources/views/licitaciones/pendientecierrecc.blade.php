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
    <li class="breadcrumb-item text-muted">Licitaciones/Cotizaciones Pendiente Cierre CC</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Listado Licitaciones/Cotizaciones Pendiente Cierre CC</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('listar-licitaciones'))
                    <div class="table-responsive">
                        <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="listado_licitaciones">
                            <thead>
                                <th>Folio</th>
                                <th>Fecha Creación</th>
                                <th>Fecha Inicio Ejecución</th>
                                <th>Fecha Termino Ejecución</th>
                                <th>Licitación/Cotización</th>
                                <th>Tipo</th>
                                <th>Empresa</th>
                                <th>Planta</th>
                                <th>Area</th>
                                <th>PGP</th>
                                <th>Valor Licitación/Cotización</th>
                                <th>Valor Adjudicación</th>
                                <th>Etapa</th>
                                <th>Familia</th>
                                <th>Siguiente etapa</th>
                                <th>Respons. sig. etapa</th>
                                <th>Herram.</th>
                            </thead>
                            <tbody>
                                <?php if ($licitaciones) {
                                    foreach ($licitaciones as $row) { ?>
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->fecha_creacion }}</td>
                                            <td>{{ $row->fecha_ejecucion_servicio }}</td>
                                            <td>{{ $row->fecha_termino_servicio }}</td>
                                            <td>{{ $row->titulo }}</td>
                                            <td>{{ $row->tipo->nombre }}</td>
                                            <td>{{ $row->empresa->nombre }}</td>
                                            <td><?php if($row->planta){ echo $row->planta->nombre; } ?></td>
                                            <td><?php if($row->area){ echo $row->area->nombre; } ?></td>
                                            <td><?php if($row->pgp){ echo $row->pgp->nombre; }else{ echo "N/A"; } ?></td>
                                            <td>${{ number_format($row->monto_cotizacion,0,',','.') }}</td>
                                            <td>${{ number_format($row->monto_adjudicacion,0,',','.') }}</td>
                                            <td>{{ $row->etapa->nombre }}</td>
                                            <td><?php if($row->familia){ echo $row->familia->nombre; } ?></td>
                                            <td>{{ $row->next() }}</td>
                                            <td>{{ $row->resp() }}</td>
                                            <td>
                                                @if(Auth::user()->can('cerrar-centro-costo'))
                                                    <a href="{{ url('/licitaciones/continuar', $row->id) }}/pendientecierrecc"><button class="btn btn-primary btn-sm">Gestionar</button></a>
                                                @endif    
                                            </td>
                                        </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                @else
                    <?php \Alert::message('Usted no tiene privilegios para visualizar las licitaciones', 'warning'); ?>
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
        $('#listado_licitaciones').DataTable({
            "language": {
                url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
        });
    });
</script>

@endsection
