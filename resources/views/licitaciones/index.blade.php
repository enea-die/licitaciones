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
    <li class="breadcrumb-item text-muted">Listado Licitaciones/Cotizaciones</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Listado Licitaciones/Cotizaciones</h3>
            </div>
            @if(Auth::user()->can('crear-licitaciones'))
                <button class="btn btn-primary align-self-center" data-bs-toggle="modal" data-bs-target="#modalAddLicitaciones">Crear Licitación/Cotización</button>
            @endif    
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('listar-licitaciones'))
                    <div class="table-responsive">
                        <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="listado_licitaciones">
                            <thead>
                                <th>Folio</th>
                                <th>Fecha creación</th>
                                <th>Licitación/Cotización</th>
                                <th>Tipo</th>
                                <th>Empresa</th>
                                <th>Planta</th>
                                <th>Area</th>
                                <th>PGP</th>
                                <th>Etapa</th>
                                <th>Familia</th>
                                <th>Siguiente etapa</th>
                                <th>Respons. sig. etapa</th>
                                <th>Detalles</th>
                                <th>Herram.</th>
                            </thead>
                            <tbody>
                                <?php if ($licitaciones) {
                                    foreach ($licitaciones as $row) { ?>
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->fecha_creacion }}</td>
                                            <td>{{ $row->titulo }}</td>
                                            <td>{{ $row->tipo->nombre }}</td>
                                            <td>{{ $row->empresa->nombre }}</td>
                                            <td><?php if($row->planta){ echo $row->planta->nombre; } ?></td>
                                            <td><?php if($row->area){ echo $row->area->nombre; } ?></td>
                                            <td><?php if($row->pgp){ echo $row->pgp->nombre; }else{ echo "N/A"; } ?></td>
                                            <td>{{ $row->etapa->nombre }}</td>
                                            <td><?php if($row->familia){ echo $row->familia->nombre; } ?></td>
                                            <td>{{ $row->next() }}</td>
                                            <td>{{ $row->resp() }}</td>
                                            <td>
                                                <a href="{{ url('licitaciones/continuar', $row->id) }}" target="_blank" class="btn btn-primary btn-sm">Visualizar detalles</a>
                                            </td>
                                            <td>
                                                <?php if($row->id_etapa == 1){ ?>
                                                    @if(Auth::user()->can('solicitar-participar-licitacion'))
                                                        <a href="{{ url('solicitud-participar-licitacion', $row->id) }}" onclick="return confirm('Esta seguro que desea enviar una solicitud para participar en esta licitación?')" class="btn btn-primary btn-sm">Solicitar participación</a>
                                                    @endif
                                                    @if(Auth::user()->can('solicitar-no-participar-licitaciones'))
                                                        <button class="btn btn-danger btn-sm" onclick="modalSolicitudNoParticipacion({{ $row->id }})">No participar</button>
                                                    @endif
                                                <?php } ?>
                                                <?php if($row->id_etapa == 2 || $row->id_etapa == 3){ ?>
                                                    @if(Auth::user()->can('responder-solicitud-participacion-licitaciones'))
                                                        <button class="btn btn-primary btn-sm" onclick="modalResponderSolicitudParticipacion({{ $row->id }})">Responder sol. participación</button>
                                                    @endif
                                                <?php } ?>
                                                <?php if($row->id_etapa == 4){ ?>
                                                    @if(Auth::user()->can('autoasignarse-responsable-licitacion'))
                                                        <a href="{{ url('autoasignarse-responsable-licitacion', $row->id) }}" onclick="return confirm('Esta seguro que desea autoasignarse responsable (Administrador de Terreno) de esta licitación?')" class="btn btn-primary btn-sm">Autoasignarme responsable (Administrador de Terreno)</a>
                                                    @endif
                                                    @if(Auth::user()->can('gestionar-responsable-licitaciones'))
                                                        <button class="btn btn-primary btn-sm" onclick="modalAsignarResponsable({{ $row->id }})">Gestionar responsable (Administrador de Terreno)</button>
                                                    @endif
                                                <?php } ?>
                                                @if(Auth::user()->can('eliminar-licitaciones'))
                                                    <a href="{{ url('licitaciones/eliminar', $row->id) }}" onclick="return confirm('Esta seguro que desea eliminar esta licitacion?')" class="btn btn-danger btn-sm">Eliminar</a>
                                                @endif
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
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

<div class="modal fade" id="modalAddLicitaciones" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <form method="post" action="{{ route('licit-guardar-licitacion') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Crear Nueva Licitación/Cotización</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="titulolicitacion">
                            <span class="required">Titulo Licitación</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Ingrese el titulo de la licitación"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Titulo licitación" name="titulolicitacion" id="titulolicitacion" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="empresalicitacion">
                            <span class="required">Empresa</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Seleccione la empresa de la licitación"></i>
                        </label>
                        <select name="empresalicitacion" id="empresalicitacion" class="form-control form-control-solid" required>
                            <option value="">Seleccione</option>
                            <?php if($listado_empresas){ foreach ($listado_empresas as $empresa) { ?>
                                <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="plantalicitacion">
                            <span class="required">Planta</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Seleccione la planta de la licitación"></i>
                        </label>
                        <select name="plantalicitacion" id="plantalicitacion" class="form-control form-control-solid" required>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="arealicitacion">
                            <span>Area</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Seleccione el area de la licitación"></i>
                        </label>
                        <select name="arealicitacion" id="arealicitacion" class="form-control form-control-solid">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="tipolicitacion">
                            <span class="required">Tipo Licitación/Cotización</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Seleccione el tipo de licitación"></i>
                        </label>
                        <select name="tipolicitacion" id="tipolicitacion" class="form-control form-control-solid" required>
                            <option value="">Seleccione</option>
                            <?php if($tipolicitaciones){ foreach ($tipolicitaciones as $tipo) { ?>
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div id="divpgpempresa" style="display: none;">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="pgplicitacion">
                                <span class="required">PGP</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Seleccione la PGP de la licitación"></i>
                            </label>
                            <select name="pgplicitacion" id="pgplicitacion" class="form-control form-control-solid">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="familia">
                            <span class="required">Familia</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Seleccione la familia de la licitación"></i>
                        </label>
                        <select name="familia" id="familia" class="form-control form-control-solid" required>
                            <option value="">Seleccione</option>
                            <?php if($listado_familias){ foreach ($listado_familias as $fam) { ?>
                                <option value="{{ $fam->id }}">{{ $fam->nombre }}</option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntoinvitacionlicitacion">
                            <span class="">Adjunto Invitación</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento de invitación de la licitación"></i>
                        </label>
                        <input type="file" class="form-control form-control-solid" name="adjuntoinvitacionlicitacion" id="adjuntoinvitacionlicitacion"/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntobasestecnicas">
                            <span>Bases Técnicas</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento bases técnicas de la licitación"></i>
                        </label>
                        <input type="file" class="form-control form-control-solid" name="adjuntobasestecnicas" id="adjuntobasestecnicas"/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="fechavisita">
                            <span class="required">Fecha Visita</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Fecha de la visita de la licitación"></i>
                        </label>
                        <input type="date" class="form-control form-control-solid" name="fechavisita" id="fechavisita" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="fechapreguntayrespuestas">
                            <span class="required">Fecha Entrega Preguntas  y Respuestas</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Fecha de entrega de preguntas y respuestas de la licitación"></i>
                        </label>
                        <input type="date" class="form-control form-control-solid" name="fechapreguntayrespuestas" id="fechapreguntayrespuestas" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="fechaenviopropuesta">
                            <span class="required">Fecha Envio Propuesta</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Fecha envio de propuesta de la licitación"></i>
                        </label>
                        <input type="date" class="form-control form-control-solid" name="fechaenviopropuesta" id="fechaenviopropuesta" required/>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Enviar</span>
                        </button>
                    </div>
                </form>
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

    function statusAprobacionEtapa1(status){
        if(status === 1){
            //si es aprobar
            $("#divobservacionesrechazo").css('display','none');
        } else if(status === 2){
            //si es rechazar
            $("#divobservacionesrechazo").css('display','block');
        }else{
            $("#divobservacionesrechazo").css('display','none');
        }
    }
</script>

@endsection
