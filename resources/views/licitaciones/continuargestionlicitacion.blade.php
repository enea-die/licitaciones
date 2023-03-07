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
    <li class="breadcrumb-item text-muted">
        <a href="{{ url($urlbase) }}" class="text-muted text-hover-primary">Licitaciones/Cotizaciones</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Gestionar Licitación/Cotización</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ $licitacion->titulo }}</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <input type="hidden" id="idetapa" value="{{ $licitacion->id_etapa }}">
                <input type="hidden" id="idtipolicitacion" value="{{ $licitacion->id_tipo_licitacion }}">
                <!-- informacion base (folio - fecha creacion - valor - etapa - tipo - empresa - grupo - participantes) -->
                <div class="row" style="font-size: 15px;">
                    <div class="col-6">
                        <strong>Folio N° </strong>{{ $licitacion->id }}
                        <br>
                        <strong>Fecha Creación </strong>{{ $licitacion->fecha_creacion }}
                        <br>
                        <strong>Valor Cotización $ </strong>{{ number_format($licitacion->monto_cotizacion,0,',','.') }}
                        <br>
                        <strong>Etapa: </strong><span class="badge badge-success badge-lg">{{ $licitacion->etapa->nombre }}</span>
                        <br>
                        <strong>Tipo Licitación/Cotización: </strong>{{ $licitacion->tipo->nombre }}
                        <br>
                        <strong>Empresa: </strong>{{ $licitacion->empresa->nombre }}
                        <br>
                        <strong>Siguiente Etapa: </strong><span class="badge badge-success badge-lg">{{ $licitacion->next() }}</span>
                        <br>
                        <strong>Responsable Etapa: </strong><span class="badge badge-success badge-lg">{{ $licitacion->resp() }}</span>
                    </div>
                    <div class="col-6">
                        <strong>Fecha Visita: </strong><?php echo $licitacion->fechavisita; ?>
                        <br>
                        <strong>Fecha Entrega Preguntas y Respuestas: </strong><?php echo $licitacion->fechapreguntayrespuestas; ?>
                        <br>
                        <strong>Fecha Envio Propuesta: </strong><?php echo $licitacion->fechaenviopropuesta; ?>
                        <br>
                        <strong>Planta: </strong><?php if($licitacion->planta){ echo $licitacion->planta->nombre; } ?>
                        <br>
                        <strong>Area: </strong><?php if($licitacion->area){ echo $licitacion->area->nombre; } ?>
                        <br>
                        <strong>PGP: </strong><?php if($licitacion->pgp){ echo $licitacion->pgp->nombre; }else{ echo "N/A"; } ?>
                    </div>
                    <hr>
                    <?php if($licitacion->grupo){ ?>
                    <div class="col-6">
                        <strong>Grupo: </strong>{{ $licitacion->grupo->nombre_grupo }}
                    </div>
                    <?php } ?>
                    <div class="col-6">
                        <?php if($licitacion->jefeoperaciones){ ?><strong>Jefe Operaciones: </strong>{{ $licitacion->jefeoperaciones->name.' '.$licitacion->jefeoperaciones->ap_paterno.' '.$licitacion->jefeoperaciones->ap_materno }}<br><?php } ?>
                        <?php if($licitacion->responsable){ ?><strong>Responsable (Administrador de Terreno): </strong>{{ $licitacion->responsable->name.' '.$licitacion->responsable->ap_paterno.' '.$licitacion->responsable->ap_materno }}<br><?php } ?>
                        <?php if($licitacion->planificador){ ?><strong>Planificación: </strong>{{ $licitacion->planificador->name.' '.$licitacion->planificador->ap_paterno.' '.$licitacion->planificador->ap_materno }}<br><?php } ?>
                        <?php if($licitacion->contabilidad){ ?><strong>Contabilidad: </strong>{{ $licitacion->contabilidad->name.' '.$licitacion->contabilidad->ap_paterno.' '.$licitacion->contabilidad->ap_materno }}<br><?php } ?>
                    </div>
                    <hr>
                </div>
                <!-- informacion visita -->
                <div class="col-12">
                    <h3>Información Visita</h3>
                    <div class="table-responsive">
                        <table class="table table-info table-row-bordered">
                            <thead>
                                <th>Responsable (Administrador de Terreno)</th>
                                <th>Registra Visita</th>
                                <th>Bases Técnicas</th>
                                <th>Archivo Visita</th>
                                <th>Observaciones</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php if($licitacion->responsable) echo $licitacion->responsable->name.' '.$licitacion->responsable->ap_paterno.' '.$licitacion->responsable->ap_materno; ?></td>
                                    <td><?php if ($licitacion->aceptacion_con_visita == 1) {
                                            echo "SI";
                                        } else {
                                            echo "NO";
                                        } ?></td>
                                    <td><a href="{{ url('/') }}{{ $licitacion->url_bases }}" target="_blank">{{ $licitacion->nombre_archivo_bases_tecnicas }}</a></td>
                                    <td><a href="{{ url('/') }}{{ $licitacion->url_visita }}" target="_blank">{{ $licitacion->nombre_archivo_visita }}</a></td>
                                    <td>{{ $licitacion->observaciones }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- archivos adicionales -->
                <div class="col-12">
                    <h3>Archivos Adicionales</h3>
                    <div class="table-responsive">
                        <table class="table table-info table-row-bordered">
                            <thead>
                                <th>Cotización</th>
                                <th>Invitación</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php if ($licitacion_documentos != null) { ?><a href="{{ url('/') }}{{ $licitacion_documentos->d1_url_cotizacion }}" target="_blank">{{ $licitacion_documentos->d1_nombre_cotizacion }}</a><?php } ?></td>
                                    <td><?php if ($licitacion->url_archivo_invitacion != null) { ?><a href="{{ url('/') }}{{ $licitacion->url_archivo_invitacion }}" target="_blank">{{ $licitacion->nombre_archivo_invitacion }}</a><?php } ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- documentos asociados -->
                <?php if ($licitacion_documentos != null) { ?>
                    <div class="col-12">
                        <h3>Documentos Asociados</h3>
                        <div class="table-responsive">
                            <table class="table table-info table-row-bordered">
                                <thead>
                                    <th>Tipo Documento</th>
                                    <th>Nombre Documento</th>
                                    <th>Archivo Adjunto</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Carta Gantt</td>
                                        <?php if ($licitacion_documentos->d2_nombre_cartagantt != null) { ?>
                                            <td>{{ $licitacion_documentos->d2_nombre_cartagantt }}</td>
                                            <td><a href="{{ url('/') }}{{ $licitacion_documentos->d2_url_cartagantt }}" target="_blank">VISUALIZAR</a></td>
                                        <?php } else { ?>
                                            <td colspan="2">No existen registro del documento de Carta gantt</td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>Organigrama</td>
                                        <?php if ($licitacion_documentos->d3_nombre_organigrama != null) { ?>
                                            <td>{{ $licitacion_documentos->d3_nombre_organigrama }}</td>
                                            <td><a href="{{ url('/') }}{{ $licitacion_documentos->d3_url_organigrama }}" target="_blank">VISUALIZAR</a></td>
                                        <?php } else { ?>
                                            <td colspan="2">No existen registro del documento de Organigrama</td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>Paso a Paso y Check List</td>
                                        <?php if ($licitacion_documentos->d4_nombre_pasoapaso != null) { ?>
                                            <td>{{ $licitacion_documentos->d4_nombre_pasoapaso }}</td>
                                            <td><a href="{{ url('/') }}{{ $licitacion_documentos->d4_url_pasoapaso }}" target="_blank">VISUALIZAR</a></td>
                                        <?php } else { ?>
                                            <td colspan="2">No existen registro del documento de Paso a Paso y Check List</td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>Matriz de Riesgo y COD</td>
                                        <?php if ($licitacion_documentos->d5_nombre_matrizriesgo != null) { ?>
                                            <td>{{ $licitacion_documentos->d5_nombre_matrizriesgo }}</td>
                                            <td><a href="{{ url('/') }}{{ $licitacion_documentos->d5_url_matrizriesgo }}" target="_blank">VISUALIZAR</a></td>
                                        <?php } else { ?>
                                            <td colspan="2">No existen registro del documento de Matriz de Riesgo y COD</td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <td>Informe Final</td>
                                        <?php if ($licitacion_documentos->d6_nombre_informefinal != null) { ?>
                                            <td>{{ $licitacion_documentos->d6_nombre_informefinal }}</td>
                                            <td><a href="{{ url('/') }}{{ $licitacion_documentos->d6_url_informefinal }}" target="_blank">VISUALIZAR</a></td>
                                        <?php } else { ?>
                                            <td colspan="2">No existen registro del documento de Informe Final</td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
                <!-- etapa 8 -->
                <?php if ($licitacion->id_etapa == 7 || $licitacion->id_etapa == 10 || $licitacion->id_etapa == 13) { ?>
                    <?php if ($licitacion->id_tipo_licitacion == 3) { ?>
                        <!-- si es SPOT -->
                        @if(Auth::user()->can('generar-cotizaciones'))
                            <hr>
                            <form action="{{ route('licit-ingresar-cotizacion') }}" id="formularioenviarcotizacionspot" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="idlicitacion" name="idlicitacion" value="{{ $licitacion->id }}">
                                <h3>Cotización</h3>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="valorcotizacion">
                                                <span class="required" style="color: red;"><b>Valor Total Cotización</b></span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Valor cotización de la licitación"></i>
                                            </label>
                                            <input type="text" class="form-control" name="valorcotizacion" id="valorcotizacion" min="0" value="{{ $licitacion->monto_cotizacion }}" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(valorcotizacion.value, 'valorcotizacion');" onfocus="limpiaPuntoGuion('valorcotizacion')" required/>
                                        </div>
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="evaluacioneconomicacotizacion">
                                                <span class="<?php if($licitacion->id_etapa != 13){ echo "required"; } ?>" style="color: red;"><b>Evaluación Económica</b></span>
                                                <?php if($licitacion->url_archivo_cot_evaluacion_economica != ''){ ?>
                                                <a href="{{ url('/') }}{{ $licitacion->url_archivo_cot_evaluacion_economica }}" target="_blank">Ver Adjunto Anterior</a>
                                                <?php } ?>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Valor cotización de la licitación"></i>
                                            </label>
                                            <input type="file" class="form-control" name="evaluacioneconomicacotizacion" id="evaluacioneconomicacotizacion" min="0" <?php if($licitacion->id_etapa != 13){ echo "required"; } ?> />
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th>PERSONAL</th>
                                            <th>MATERIAL</th>
                                            <th>EQUIPOS Y SERVICIOS</th>
                                            <th>GG. Y UTILIDAD</th>
                                            <th>TOTAL NETO</th>
                                            <th>MARGEN %</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" id="ic_montopersonal" name="ic_montopersonal" value="<?php if ($itempersonas) { echo $itempersonas->valor; } else { echo "0"; } ?>" onchange="javascript:calcularcotizacionmack();" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(ic_montopersonal.value, 'ic_montopersonal');" onfocus="limpiaPuntoGuion('ic_montopersonal')">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="ic_montomaterial" name="ic_montomaterial" value="<?php if ($itemmateriales) { echo $itemmateriales->valor; } else { echo "0"; } ?>" onchange="javascript:calcularcotizacionmack();" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(ic_montomaterial.value, 'ic_montomaterial');" onfocus="limpiaPuntoGuion('ic_montomaterial')">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="ic_montoequipos" name="ic_montoequipos" value="<?php if ($itemservicio) { echo $itemservicio->valor; } else { echo "0"; } ?>" onchange="javascript:calcularcotizacionmack();" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(ic_montoequipos.value, 'ic_montoequipos');" onfocus="limpiaPuntoGuion('ic_montoequipos')">
                                                </td>
                                                <td>
                                                    <div id="ic_ggutilidaddisableddiv" style="display:none;"></div>
                                                    <input type="hidden" class="form-control" id="ic_ggutilidad" name="ic_ggutilidad" value="0">
                                                    <input type="text" class="form-control" id="ic_ggutilidaddisabled" name="ic_ggutilidaddisabled" value="0" disabled>
                                                </td>
                                                <td>
                                                    <div id="ic_totalnetodisableddiv" style="display:none;"></div>
                                                    <input type="hidden" class="form-control" id="ic_totalneto" name="ic_totalneto" value="0">
                                                    <input type="text" class="form-control" id="ic_totalnetodisabled" name="ic_totalnetodisabled" value="0" disabled>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" id="ic_montomargen" name="ic_montomargen" value="<?php if ($itemmargen) { echo $itemmargen->valor; } else { echo "0"; } ?>" min="0" max="100" >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if($licitacion->id_etapa == 13 && $licitacion->observacionesnocotizacionjefecomercial != ''){ ?>
                                    <hr>
                                    <h3>Observaciones Rechazo Sub-Gerente Operaciones</h3>
                                    <p>{{ $licitacion->observacionesnocotizacionjefecomercial }}</p>
                                <?php } ?>
                                <?php if($licitacion->id_etapa == 13 && $licitacion->observacionesnocotizacionjefeoperaciones != ''){ ?>
                                    <hr>
                                    <h3>Observaciones Rechazo Jefe Operaciones</h3>
                                    <p>{{ $licitacion->observacionesnocotizacionjefeoperaciones }}</p>
                                <?php } ?>
                                <?php if($licitacion->id_etapa == 13){ ?>
                                    <hr>
                                    <div class="col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="observacionesreenviorevisioncotizacion">
                                                <span class="">Observaciones Reenvio</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Observaciones del reenvio de la cotización"></i>
                                            </label>
                                            <textarea class="form-control form-control-solid" name="observacionesreenviorevisioncotizacion" id="observacionesreenviorevisioncotizacion"></textarea>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary">Guardar Cotización</button>
                                </div>
                            </form>
                        @endif
                    <?php } ?>
                    <?php if ($licitacion->id_tipo_licitacion == 4) { ?>
                        <!-- si es PGP -->
                        @if(Auth::user()->can('generar-cotizaciones'))
                            <script> calcularcotizacionmack(); </script>
                            <hr>
                            <form action="{{ route('licit-ingresar-cotizacion') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="idlicitacion" name="idlicitacion" value="{{ $licitacion->id }}">
                                <h3>Cotización PGP</h3>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="button" class="btn btn-sm btn-success" id="btnagregarcotizacionPGP" value="Agregar Nueva Cotización">
                                        <div class="table-responsive">
                                            <table id="tablecotizaciones" class="table">
                                                <thead>
                                                    <th>/</th>
                                                    <th>NOMBRE</th>
                                                    <th>VALOR TOTAL COTIZACIÓN</th>
                                                    <th>EVALUACIÓN ECONÓMICA</th>
                                                    <th>PERSONAL</th>
                                                    <th>MATERIAL</th>
                                                    <th>EQUIPOS Y SERVICIOS</th>
                                                    <th>GG. Y UTILIDAD</th>
                                                    <th>TOTAL NETO</th>
                                                    <th>MARGEN %</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $contcot = 0;
                                                        if($listadocotizacionesPGP){
                                                            foreach ($listadocotizacionesPGP as $rowcot) {
                                                                $contcot++;
                                                    ?>
                                                    <tr id="filaCOTpgp<?php echo $contcot; ?>">
                                                        <td><button class="btn btn-sm btn-danger" type="button" onclick="eliminarCotPGP(<?php echo $contcot; ?>);">X</button></td>
                                                        <td>
                                                            <input type="text" class="form-control" id="cot_nombre[<?php echo $contcot; ?>]" name="cot_nombre[<?php echo $contcot; ?>]" value="<?php echo $rowcot->nombre; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="fila_cotizacion[]" id="fila_cotizacion[]" value="<?php echo $contcot; ?>">
                                                            <input type="text" class="form-control" id="cot_valor_total<?php echo $contcot; ?>" name="cot_valor_total[<?php echo $contcot; ?>]" value="<?php echo $rowcot->valor_total_cotizacion; ?>" onchange="javascript:calcularcotizacionmack();" onkeypress="return solo_numeros(event)" onblur="checkValorNumericoCotizacionesPGPValorTotal(<?php echo $contcot; ?>);" onfocus="limpiaPuntoGuionCotizacionesPGPValorTotal(<?php echo $contcot; ?>)">
                                                        </td>
                                                        <td>
                                                            <input type="file" class="form-control" id="cot_ic_evaluacion_economica[<?php echo $contcot; ?>]" name="cot_ic_evaluacion_economica[<?php echo $contcot; ?>][file]" value="<?php echo $rowcot->valor; ?>">
                                                            <?php if($rowcot->url_evaluacion_economica != ''){ ?>
                                                            <a href="{{ url('/') }}{{ $rowcot->url_evaluacion_economica }}" target="_blank">Ver Adjunto Anterior</a>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="cot_ic_montopersonal<?php echo $contcot; ?>" name="cot_ic_montopersonal[<?php echo $contcot; ?>]" value="<?php echo $rowcot->monto_item_personal; ?>" onchange="javascript:calcularcotizacionmack();" onkeypress="return solo_numeros(event)" onblur="checkValorNumericoCotizacionesPGPMontoPersonal(<?php echo $contcot; ?>);" onfocus="limpiaPuntoGuionCotizacionesPGPMontoPersonal(<?php echo $contcot; ?>)">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="cot_ic_montomaterial<?php echo $contcot; ?>" name="cot_ic_montomaterial[<?php echo $contcot; ?>]" value="<?php echo $rowcot->monto_item_material; ?>" onchange="javascript:calcularcotizacionmack();" onkeypress="return solo_numeros(event)" onblur="checkValorNumericoCotizacionesPGPMontoMaterial(<?php echo $contcot; ?>);" onfocus="limpiaPuntoGuionCotizacionesPGPMontoMaterial(<?php echo $contcot; ?>)">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="cot_ic_montoequipos<?php echo $contcot; ?>" name="cot_ic_montoequipos[<?php echo $contcot; ?>]" value="<?php echo $rowcot->monto_item_servicios; ?>" onchange="javascript:calcularcotizacionmack();" onkeypress="return solo_numeros(event)" onblur="checkValorNumericoCotizacionesPGPMontoEquipos(<?php echo $contcot; ?>);" onfocus="limpiaPuntoGuionCotizacionesPGPMontoEquipos(<?php echo $contcot; ?>)">
                                                        </td>
                                                        <td>
                                                            <div id="ic_ggutilidaddisableddiv<?php echo $contcot; ?>" style="display:none;"></div>
                                                            <input type="hidden" class="form-control" id="cot_ic_ggutilidad<?php echo $contcot; ?>" name="cot_ic_ggutilidad[<?php echo $contcot; ?>]" value="<?php echo $rowcot->ggutilidad; ?>">
                                                            <input type="text" class="form-control" id="cot_ic_ggutilidaddisabled<?php echo $contcot; ?>" name="cot_ic_ggutilidaddisabled[<?php echo $contcot; ?>]" value="<?php echo $rowcot->ggutilidad; ?>" disabled>
                                                        </td>
                                                        <td>
                                                            <div id="ic_totalnetodisableddiv<?php echo $contcot; ?>" style="display:none;"></div>
                                                            <input type="hidden" class="form-control" id="cot_ic_totalneto<?php echo $contcot; ?>" name="cot_ic_totalneto[<?php echo $contcot; ?>]" value="<?php echo $rowcot->total_neto; ?>">
                                                            <input type="text" class="form-control" id="cot_ic_totalnetodisabled<?php echo $contcot; ?>" name="cot_ic_totalnetodisabled[<?php echo $contcot; ?>]" value="<?php echo $rowcot->total_neto; ?>" disabled>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" id="cot_ic_montomargen<?php echo $contcot; ?>" name="cot_ic_montomargen[<?php echo $contcot; ?>]" value="<?php echo $rowcot->porcentaje_margen; ?>" min="0" max="100" onchange="javascript:calcularcotizacionmack();">
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2">Totales</td>
                                                        <td><input type="text" id="cottotalesvalortotalescotizacion" class="form-control" value="0" disabled></td>
                                                        <td></td>
                                                        <td><input type="text" id="cottotalvalorpersonal" class="form-control" value="0" disabled></td>
                                                        <td><input type="text" id="cottotalvalormaterial" class="form-control" value="0" disabled></td>
                                                        <td><input type="text" id="cottotalvalorequipos" class="form-control" value="0" disabled></td>
                                                        <td><input type="text" id="cottotalvalorutilidad" class="form-control" value="0" disabled></td>
                                                        <td><input type="text" id="cottotalvalortotalneto" class="form-control" value="0" disabled></td>
                                                        <td><input type="text" id="cottotalvalormargen" name="cottotalvalormargen" class="form-control" value="0"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <input type="hidden" name="cont_cotizaciones_actual" id="cont_cotizaciones_actual" value="<?php echo $contcot ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php if($licitacion->id_etapa == 13 && $licitacion->observacionesnocotizacionjefecomercial != ''){ ?>
                                    <hr>
                                    <h3>Observaciones Rechazo Sub-Gerente Operaciones</h3>
                                    <p>{{ $licitacion->observacionesnocotizacionjefecomercial }}</p>
                                <?php } ?>
                                <?php if($licitacion->id_etapa == 13 && $licitacion->observacionesnocotizacionjefeoperaciones != ''){ ?>
                                    <hr>
                                    <h3>Observaciones Rechazo Jefe Operaciones</h3>
                                    <p>{{ $licitacion->observacionesnocotizacionjefeoperaciones }}</p>
                                <?php } ?>
                                <?php if($licitacion->id_etapa == 13){ ?>
                                    <hr>
                                    <div class="col-12">
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="observacionesreenviorevisioncotizacion">
                                                <span class="">Observaciones Reenvio</span>
                                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Observaciones del reenvio de la cotización"></i>
                                            </label>
                                            <textarea class="form-control form-control-solid" name="observacionesreenviorevisioncotizacion" id="observacionesreenviorevisioncotizacion"></textarea>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary">Guardar Cotización</button>
                                </div>
                            </form>
                        @endif
                    <?php } ?>
                <?php } ?>
                <?php if ($licitacion->id_etapa >= 11 && $licitacion->id_etapa != 13) { ?>
                    <?php if ($licitacion->id_tipo_licitacion == 3) { ?>
                        <!-- si es SPOT -->
                        <div class="row">
                            <div class="col-10">
                                <h3>Cotización</h3>
                            </div>
                            <div class="col-2">
                                <?php if(count($itemhistorial) > 1){ ?>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalHistorialCotizaciones">Historial</button>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="valorcotizacion">
                                        <span style="color: red;"><b>Valor Total Cotización</b></span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Valor cotización de la licitación"></i>
                                    </label>
                                    <label>${{ number_format($licitacion->monto_cotizacion,0,',','.') }}</label>
                                </div>
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="valorcotizacion">
                                        <span style="color: red;"><b>Evaluación Económica</b></span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjunto evaluación económica de la cotización"></i>
                                    </label>
                                    <label><a href="{{ url('/') }}{{ $licitacion->url_archivo_cot_evaluacion_economica }}" target="_blank">Ver Adjunto</a></label>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>PERSONAL</th>
                                    <th>MATERIAL</th>
                                    <th>EQUIPOS Y SERVICIOS</th>
                                    <th>GG. Y UTILIDAD</th>
                                    <th>TOTAL NETO</th>
                                    <th>MARGEN %</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            $<?php if ($itempersonas) { echo number_format($itempersonas->valor,0,',','.'); } else { echo "0"; } ?>
                                            <input type="hidden" class="form-control" id="ic_montopersonal" name="ic_montopersonal" value="<?php if ($itempersonas) { echo number_format($itempersonas->valor,0,',','.'); } else { echo "0"; } ?>" disabled>
                                        </td>
                                        <td>
                                            $<?php if ($itemmateriales) { echo number_format($itemmateriales->valor,0,',','.'); } else { echo "0"; } ?>
                                            <input type="hidden" class="form-control" id="ic_montomaterial" name="ic_montomaterial" value="<?php if ($itemmateriales) { echo number_format($itemmateriales->valor,0,',','.'); } else { echo "0"; } ?>" disabled>
                                        </td>
                                        <td>
                                            $<?php if ($itemservicio) { echo number_format($itemservicio->valor,0,',','.'); } else { echo "0"; } ?>
                                            <input type="hidden" class="form-control" id="ic_montoequipos" name="ic_montoequipos" value="<?php if ($itemservicio) { echo number_format($itemservicio->valor,0,',','.'); } else { echo "0"; } ?>" disabled>
                                        </td>
                                        <td>
                                            <div id="ic_ggutilidaddisableddiv"></div>
                                            <input type="hidden" class="form-control" id="ic_ggutilidad" name="ic_ggutilidad" value="0">
                                            <input type="hidden" class="form-control" id="ic_ggutilidaddisabled" name="ic_ggutilidaddisabled" value="0" disabled>
                                        </td>
                                        <td>
                                            <div id="ic_totalnetodisableddiv"></div>
                                            <input type="hidden" class="form-control" id="ic_totalneto" name="ic_totalneto" value="0">
                                            <input type="hidden" class="form-control" id="ic_totalnetodisabled" name="ic_totalnetodisabled" value="0" disabled>
                                        </td>
                                        <td>
                                            <?php if ($itemmargen) { echo $itemmargen->valor; } else { echo "0"; } ?>%
                                            <input type="hidden" class="form-control" id="ic_montomargen" name="ic_montomargen" value="<?php if ($itemmargen) { echo number_format($itemmargen->valor,0,',','.'); } else { echo "0"; } ?>" disabled>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <?php if ($licitacion->id_tipo_licitacion == 4) { ?>
                        <!-- si es PGP -->
                        <script> calcularcotizacionmack(); </script>
                        <hr>
                        <form action="#" id="formCotizacionPGP" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="idlicitacion" name="idlicitacion" value="{{ $licitacion->id }}">
                            <h3>Cotización PGP</h3>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>NOMBRE</th>
                                                <th>VALOR TOTAL COTIZACIÓN</th>
                                                <th>EVALUACIÓN ECONÓMICA</th>
                                                <th>PERSONAL</th>
                                                <th>MATERIAL</th>
                                                <th>EQUIPOS Y SERVICIOS</th>
                                                <th>GG. Y UTILIDAD</th>
                                                <th>TOTAL NETO</th>
                                                <th>MARGEN %</th>
                                                <?php if($licitacion->id_etapa == 12){ ?>
                                                    <th>Acciones</th>
                                                <?php } ?>
                                                <?php if($licitacion->id_etapa > 12){ ?>
                                                    <th>Estado</th>
                                                <?php } ?>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $contcot = 0;
                                                    if($listadocotizacionesPGP){
                                                        foreach ($listadocotizacionesPGP as $rowcot) {
                                                            $contcot++;

                                                            if($licitacion->id_etapa == 12 && $rowcot->estado_aprobacion == 2){
                                                                $disabled = "";
                                                                $signopeso = "";
                                                            }else{
                                                                $disabled = "disabled";
                                                                $signopeso = "$";
                                                            }
                                                ?>
                                                <tr id="filaCOTpgp<?php echo $contcot; ?>">
                                                    <td>
                                                        <?php if($licitacion->id_etapa == 12 && $rowcot->estado_aprobacion == 2){ ?>
                                                            <input type="hidden" name="fila_cotizacion[]" value="{{$contcot}}">
                                                        <?php }else{ ?>
                                                            <input type="hidden" name="fila_cotizacion_noeditable[]" value="{{$contcot}}">
                                                        <?php } ?>
                                                        <input type="hidden" name="filacotizacionpgp" value="{{$contcot}}">
                                                        <input type="hidden" name="idcotizacionpgp[<?php echo $contcot; ?>]" value="{{$rowcot->id}}">
                                                        {{$rowcot->nombre}}
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cot_valor_total[<?php echo $contcot; ?>]" id="cot_valor_total<?php echo $contcot; ?>" class="form-control" value="<?php echo $signopeso.number_format($rowcot->valor_total_cotizacion,0,',','.'); ?>" onchange='javascript:calcularcotizacionmack();' onkeypress='return solo_numeros(event)' onblur="checkValorNumericoCotizacionesPGPValorTotal(<?php echo $contcot; ?>);" onfocus="limpiaPuntoGuionCotizacionesPGPValorTotal(<?php echo $contcot; ?>)" <?php echo $disabled; ?> >
                                                    </td>
                                                    <td>
                                                        <?php if($rowcot->url_evaluacion_economica != ''){ ?>
                                                        <a href="{{ url('/') }}{{ $rowcot->url_evaluacion_economica }}" target="_blank">Ver Adjunto Anterior</a>
                                                        <?php } ?>
                                                        <?php if($licitacion->id_etapa == 12 && $rowcot->estado_aprobacion == 2){ ?>
                                                            <input type="file" class="form-control" id="cot_ic_evaluacion_economica[<?php echo $contcot; ?>]" name="cot_ic_evaluacion_economica[<?php echo $contcot; ?>][file]" value="<?php echo $rowcot->valor; ?>" onchange="javascript:calcularcotizacionmack();" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(ic_montomaterial.value, 'ic_montomaterial');" onfocus="limpiaPuntoGuion('ic_montomaterial')">
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cot_ic_montopersonal[<?php echo $contcot; ?>]" id="cot_ic_montopersonal<?php echo $contcot; ?>" class="form-control" value="<?php echo $signopeso.number_format($rowcot->monto_item_personal,0,',','.'); ?>" onchange='javascript:calcularcotizacionmack();' onkeypress='return solo_numeros(event)' onblur="checkValorNumericoCotizacionesPGPMontoPersonal(<?php echo $contcot; ?>);" onfocus="limpiaPuntoGuionCotizacionesPGPMontoPersonal(<?php echo $contcot; ?>)" <?php echo $disabled; ?> >
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cot_ic_montomaterial[<?php echo $contcot; ?>]" id="cot_ic_montomaterial<?php echo $contcot; ?>" class="form-control" value="<?php echo $signopeso.number_format($rowcot->monto_item_material,0,',','.'); ?>" onchange='javascript:calcularcotizacionmack();' onkeypress='return solo_numeros(event)' onblur="checkValorNumericoCotizacionesPGPMontoMaterial(<?php echo $contcot; ?>);" onfocus="limpiaPuntoGuionCotizacionesPGPMontoMaterial(<?php echo $contcot; ?>)" <?php echo $disabled; ?> >
                                                    </td>
                                                    <td>
                                                        <input type="text" name="cot_ic_montoequipos[<?php echo $contcot; ?>]" id="cot_ic_montoequipos<?php echo $contcot; ?>" class="form-control" value="<?php echo $signopeso.number_format($rowcot->monto_item_servicios,0,',','.'); ?>" onchange='javascript:calcularcotizacionmack();' onkeypress='return solo_numeros(event)' onblur="checkValorNumericoCotizacionesPGPMontoEquipos(<?php echo $contcot; ?>);" onfocus="limpiaPuntoGuionCotizacionesPGPMontoEquipos(<?php echo $contcot; ?>)" <?php echo $disabled; ?> >
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="cot_ic_ggutilidad[<?php echo $contcot; ?>]" id="cot_ic_ggutilidad<?php echo $contcot; ?>" value="<?php echo $rowcot->ggutilidad; ?>">
                                                        <input type="text" name="cot_ic_ggutilidaddisabled[<?php echo $contcot; ?>]" id="cot_ic_ggutilidaddisabled<?php echo $contcot; ?>" class="form-control" value="<?php echo $signopeso.number_format($rowcot->ggutilidad,0,',','.'); ?>" disabled >
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="cot_ic_totalneto[<?php echo $contcot; ?>]" id="cot_ic_totalneto<?php echo $contcot; ?>" value="<?php echo $rowcot->total_neto; ?>">
                                                        <input type="text" name="cot_ic_totalnetodisabled[<?php echo $contcot; ?>]" id="cot_ic_totalnetodisabled<?php echo $contcot; ?>" class="form-control" value="<?php echo $signopeso.number_format($rowcot->total_neto,0,',','.'); ?>" disabled >
                                                    </td>
                                                    <td>
                                                        <input type="number" name="cot_ic_montomargen[<?php echo $contcot; ?>]" id="cot_ic_montomargen<?php echo $contcot; ?>" class="form-control" value="<?php echo $rowcot->porcentaje_margen; ?>" min="0" max="100" onchange="javascript:calcularcotizacionmack();" <?php echo $disabled; ?> >
                                                    </td>
                                                    <td>
                                                        <?php if($licitacion->id_etapa == 12){ ?>
                                                            <?php if($rowcot->estado_aprobacion == 0){ ?>
                                                                @if(Auth::user()->can('PGP-aprobar-rechazar-revision-cotizaciones'))
                                                                    <a href="{{ url('aprobar-cotizacion-pgp') }}/{{ $licitacion->id }}/{{ $rowcot->id }}" onclick="return confirm('¿Esta seguro que desea aprobar la cotización?')">
                                                                        <button type="button" class="btn btn-primary btn-sm">Aprobar</button>
                                                                    </a>
                                                                    <a href="{{ url('rechazar-cotizacion-pgp') }}/{{ $licitacion->id }}/{{ $rowcot->id }}" onclick="return confirm('¿Esta seguro que desea rechazar la cotización?')">
                                                                        <button type="button" class="btn btn-danger btn-sm">Rechazar</button>
                                                                    </a>
                                                                @endif
                                                            <?php } ?>
                                                            <?php if($rowcot->estado_aprobacion == 1){ ?>
                                                                <span class="badge badge-light-success">Aprobada</span>
                                                            <?php } ?>
                                                            <?php if($rowcot->estado_aprobacion == 2){ ?>
                                                                <span class="badge badge-light-danger">Rechazada</span>
                                                                @if(Auth::user()->can('generar-cotizaciones'))
                                                                    <button type="button" class="btn btn-primary btn-sm" onclick="volveraevaluarcotizacion(<?php echo $contcot; ?>)">Volver a enviar</button>
                                                                @endif
                                                            <?php } ?>
                                                            @if(Auth::user()->can('PGP-eliminar-cotizaciones'))
                                                                <a href="{{ url('eliminar-cotizacion-pgp') }}/{{ $licitacion->id }}/{{ $rowcot->id }}" onclick="return confirm('¿Esta seguro que desea eliminar la cotización?')">
                                                                    <button type="button" class="btn btn-danger btn-sm">Eliminar</button>
                                                                </a>
                                                            @endif
                                                        <?php } ?>
                                                        <?php if($licitacion->id_etapa > 12){ ?>
                                                            <?php if($rowcot->estado_aprobacion == 1){ ?>
                                                                <span class="badge badge-light-success">Aprobada</span>
                                                            <?php } ?>
                                                            <?php if($rowcot->estado_aprobacion == 2){ ?>
                                                                <span class="badge badge-light-danger">Rechazada</span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php } } ?>
                                                <tr>
                                                    <td>Totales</td>
                                                    <td><input type="text" id="cottotalesvalortotalescotizacion" class="form-control" value="0" disabled></td>
                                                    <td></td>
                                                    <td><input type="text" id="cottotalvalorpersonal" class="form-control" value="0" disabled></td>
                                                    <td><input type="text" id="cottotalvalormaterial" class="form-control" value="0" disabled></td>
                                                    <td><input type="text" id="cottotalvalorequipos" class="form-control" value="0" disabled></td>
                                                    <td><input type="text" id="cottotalvalorutilidad" class="form-control" value="0" disabled></td>
                                                    <td><input type="text" id="cottotalvalortotalneto" class="form-control" value="0" disabled></td>
                                                    <td><input type="text" class="form-control" value="{{ $licitacion->PGPcottotalvalormargen }}" disabled></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                    <?php if($licitacion->observacionesreenviorevisioncotizacion){ ?>
                        <hr>
                        <h3>Observaciones Reenvio Cotización</h3>
                        <p>{{ $licitacion->observacionesreenviorevisioncotizacion }}</p>
                        <hr>
                    <?php } ?>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 11 && Auth::user()->can('solicitar-revision-cotizaciones')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ url('/solicitar-revision-cotizacion') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea enviar los valores de cotizacion a revisión?')">
                            <button type="button" class="btn btn-primary">Solicitar Revisión Cotización</button>
                        </a>
                    </div>
                <?php } ?>
                <?php if($licitacion->id_etapa == 12 && $licitacion->id_tipo_licitacion == 3){ ?>
                    <?php if ($licitacion->monto_cotizacion <= $getConfiguraciones->jefeoperacionesmenorque  && Auth::user()->can('responder-revision-cotizaciones')) { ?>
                        <div class="col-6">
                            <button class="btn btn-primary btn-sm" onclick="modalResponderSolicitudRevisionCotizacion({{ $licitacion->id }})">Responder Revisión Cotización (Jefe de Operaciones)</button>
                        </div>
                    <?php } ?>
                    <?php if ($licitacion->monto_cotizacion > $getConfiguraciones->subgerenteoperacionesentre_inicial && $licitacion->monto_cotizacion <= $getConfiguraciones->subgerenteoperacionesentre_final  && Auth::user()->can('responder-revision-cotizaciones')) { ?>
                        <div class="col-6">
                            <button class="btn btn-primary btn-sm" onclick="modalResponderSolicitudRevisionCotizacion({{ $licitacion->id }})">Responder Revisión Cotización (Sub-Gerente Operaciones)</button>
                        </div>
                    <?php } ?>
                    <?php if ($licitacion->monto_cotizacion > $getConfiguraciones->subgerentegeneralentre_inicial && $licitacion->monto_cotizacion <= $getConfiguraciones->subgerentegeneralentre_final && Auth::user()->can('responder-revision-cotizaciones')){ ?>
                        <div class="col-6">
                            <button class="btn btn-primary btn-sm" onclick="modalResponderSolicitudRevisionCotizacion({{ $licitacion->id }})">Responder Revisión Cotización (Sub-Gerente General)</button>
                        </div>
                    <?php } ?>
                    <?php if ($licitacion->monto_cotizacion > $getConfiguraciones->gerentegeneralmayorque && Auth::user()->can('responder-revision-cotizaciones')) { ?>
                            <div class="col-6">
                                <button class="btn btn-primary btn-sm" onclick="modalResponderSolicitudRevisionCotizacion({{ $licitacion->id }})">Responder Revisión Cotización (Gerente General)</button>
                            </div>
                    <?php } ?>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 17 && $licitacion->id_tipo_licitacion == 3 && Auth::user()->can('subir-oferta-plataforma')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ url('/registrar-subida-plataforma-licitacion') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea informar que esta subida o va ha subir la oferta a la plataforma?')">
                            <button type="button" class="btn btn-primary">Oferta subida en la plataforma</button>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 14 && $licitacion->id_tipo_licitacion == 4) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <?php if ($licitacion->pgp_aprobacioncot_subgerenteoperaciones == 0 && Auth::user()->can('PGP-aprobacion-completa-subgerente-operaciones')) { ?>
                            <a href="{{ url('/aprobacionCotizPGPsubgerenteoperaciones') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea aprobar el paquete completo de la cotización?')">
                                <button type="button" class="btn btn-primary">Aprobación Completa Sub-Gerente Operaciones</button>
                            </a>
                        <?php }else{ ?>
                            <?php if ($licitacion->pgp_aprobacioncot_subgerentegeneral == 0 && Auth::user()->can('PGP-aprobacion-completa-subgerente-general')) { ?>
                                <a href="{{ url('/aprobacionCotizPGPsubgerentegeneral') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea aprobar el paquete completo de la cotización?')">
                                    <button type="button" class="btn btn-primary">Aprobación Completa Sub-Gerente General</button>
                                </a>
                            <?php }else{ ?>
                                <?php if ($licitacion->pgp_aprobacioncot_gerentegeneral == 0 && Auth::user()->can('PGP-aprobacion-completa-gerente-general')) { ?>
                                    <a href="{{ url('/aprobacionCotizPGPgerentegeneral') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea aprobar el paquete completo de la cotización?')">
                                        <button type="button" class="btn btn-primary">Aprobación Completa Gerente General</button>
                                    </a>
                                <?php }else{ ?>
                                    <?php if (Auth::user()->can('subir-oferta-plataforma')) { ?>
                                        <a href="{{ url('/registrar-subida-plataforma-licitacion') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea informar que esta subida o va ha subir la oferta a la plataforma?')">
                                            <button type="button" class="btn btn-primary">Oferta subida en la plataforma</button>
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 14 && $licitacion->id_tipo_licitacion == 3 && Auth::user()->can('subir-oferta-plataforma')) { ?>
                    <a href="{{ url('/registrar-subida-plataforma-licitacion') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea informar que esta subida o va ha subir la oferta a la plataforma?')">
                        <button type="button" class="btn btn-primary">Oferta subida en la plataforma</button>
                    </a>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 17 && Auth::user()->can('subir-oferta-plataforma')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ url('/registrar-subida-plataforma-licitacion') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea informar que esta o subio la oferta a la plataforma?')">
                            <button type="button" class="btn btn-primary">Oferta subida en la plataforma</button>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 18 && Auth::user()->can('ingresar-resultado-adjudicacion')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalIngresarResultadoAdjudicacion">Ingresar Resultado Adjudicación</button>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 19) { ?>
                    <hr>
                    <div class="row py-6 px-9">
                        <div class="col-6">
                            No Adjudicada
                        </div>
                        <div class="col-6">
                            {{ $licitacion->observaciones_no_adjudicacion }}
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <?php if ($licitacion->id_etapa >= 20 && $ordencliente && $licitacion->id_tipo_licitacion == 3) { ?>
                    <hr>
                    <strong>Adjudicada</strong>
                    <div class="row py-6 px-9">
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <!--<th>Orden Servicio</th>-->
                                        <th>Monto Adjudicación</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Termino</th>
                                        <th>Adjunto</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--<td>{! $ordencliente->ot_orden !}</td>-->
                                            <td>${{ number_format($licitacion->monto_adjudicacion,0,',','.') }}</td>
                                            <td>{{ $ordencliente->fecha_inicio }}</td>
                                            <td>{{ $ordencliente->fecha_termino }}</td>
                                            <td><a href="{{ url('/') }}{{ $ordencliente->url }}" target="_blank">Visualizar</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>SP/OM</th>
                                        <th>Descripción</th>
                                        <th>$ Monto</th>
                                    </thead>
                                    <tbody>
                                        <?php if($listadoItemSPOM){ foreach ($listadoItemSPOM as $item) { ?>
                                        <tr>
                                            <td>{{ $item->item_spom }}</td>
                                            <td>{{ $item->descripcion }}</td>
                                            <td>${{ number_format($item->monto,0,',','.') }}</td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <?php if ($licitacion->id_etapa >= 20 && $licitacion->id_tipo_licitacion == 4) { ?>
                    <hr>
                    <strong>Adjudicada</strong>
                    <table class="table">
                        <thead>
                            <th>Nombre</th>
                            <th>Adjunto Orden Servicio</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Termino</th>
                            <th>Monto Adjud.</th>
                            <th>SP/OM</th>
                            <th>Descripción</th>
                            <th>$ Monto SP/OM</th>
                        </thead>
                        <tbody>
                            <?php if($listadocotizacionesPGPAprobadas){ foreach ($listadocotizacionesPGPAprobadas as $cotaprob) { ?>
                            <tr>
                                <td>{{$cotaprob->nombre}}</td>
                                <td>
                                    <?php if($cotaprob->adjunto_orden_servicio != ''){ ?>
                                    <a href="{{ url('/') }}{{ $cotaprob->adjunto_orden_servicio }}" target="_blank">Ver Adjunto Anterior</a>
                                    <?php } ?>
                                </td>
                                <td>{{$cotaprob->fecha_inicio_ordenservicio}}</td>
                                <td>{{$cotaprob->fecha_termino_ordenservicio}}</td>
                                <td>${{ number_format($cotaprob->monto_adjudicacion,0,',','.') }}</td>
                                <td>{{$cotaprob->spom_ordenservicio}}</td>
                                <td>{{$cotaprob->descripcion_spom}}</td>
                                <td>${{ number_format($cotaprob->monto_spom,0,',','.') }}</td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 20 && Auth::user()->can('solicitar-centro-costo')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ url('/registrar-solicitud-centrocosto') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea solicitar el centro de costo de la cotizacion?')">
                            <button type="button" class="btn btn-primary" style="margin-right: 10px;">Solicitar Centro Costo</button>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 21 && Auth::user()->can('ingresar-centro-costo')) { ?>
                    <form action="{{ route('licit-ingresar-centro-costo') }}" method="post">
                        @csrf
                        <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="centrocostolicitacion">
                                        <span class="">Centro Costo</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Centro Costo Licitación"></i>
                                    </label>
                                    <input type="text" class="form-control" name="centrocostolicitacion" id="centrocostolicitacion">
                                </div>
                            </div>
                            <div class="col-6">
                                <br>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Guardar Centro Costo</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                <?php if ($licitacion->id_etapa >= 22) { ?>
                    <hr>
                    <div class="row py-6 px-9">
                        <div class="col-6">
                            Centro Costo
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>N°</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Fecha Generación</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $licitacion->centro_costo }}</td>
                                            <td>{{ $licitacion->cc_fecha_solicitud }}</td>
                                            <td>{{ $licitacion->cc_fecha_creacion }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 22 && Auth::user()->can('informar-inicio-servicio')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInformarInicioServicio">Informar Inicio Servicio</button>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa > 22) { ?>
                    <hr>
                    <div class="row py-6 px-9">
                        <div class="col-6">
                            Servicio Ejecutado
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Fecha Inicio Servicio</th>
                                        <?php if ($licitacion->id_etapa >= 24) { ?>
                                        <th>Fecha Termino Servicio</th>
                                        <?php } ?>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $licitacion->fecha_ejecucion_servicio }}</td>
                                            <?php if ($licitacion->id_etapa >= 24) { ?>
                                            <td>{{ $licitacion->fecha_termino_servicio }}</td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 23 && Auth::user()->can('ingresar-trabajos-adicionales')) { ?>
                    <hr>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalIngresarTrabajoAdicional">Agregar Trabajo Adicional</button>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa >= 23 && $listadotrabajosadicionales) { ?>
                    <div class="row py-6 px-9">
                        <div class="col-12">
                            <strong>Trabajos Adicionales Ingresados</strong>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th><strong>Nombre OC</strong></th>
                                        <th><strong>Adjunto OC</strong></th>
                                        <th><strong>OC NUEVA/MISMA</strong></th>
                                        <th><strong>Monto</strong></th>
                                        <th><strong>Descripción</strong></th>
                                        <th><strong>Item SP/OM</strong></th>
                                    </thead>
                                    <tbody>
                                        <?php if($listadotrabajosadicionales){ foreach ($listadotrabajosadicionales as $trab) { ?>
                                        <tr>
                                            <td>{{ $trab->nombre_oc }}</td>
                                            <td><a href="{{ url('/') }}{{ $trab->adjunto_oc }}" target="_blank">Visualizar</a></td>
                                            <td><?php if($trab->oc_nueva == 1){ echo "NUEVA"; }else{ echo "MISMA"; } ?></td>
                                            <td>${{ number_format($trab->monto,0,',','.') }}</td>
                                            <td>{{ $trab->descripcion }}</td>
                                            <td>
                                                <?php
                                                    if($trab->itemsspom){
                                                        foreach ($trab->itemsspom as $item) {
                                                            echo $item->item_spom." / $".number_format($item->monto,0,',','.')." / ".$item->descripcion."<br>";
                                                        }
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 23 && Auth::user()->can('informar-termino-servicio')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInformarTerminoServicio">Informar Termino Servicio</button>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa >= 24) { ?>
                    <div class="row py-6 px-9">
                        <div class="col-12">
                            <h2>SP/OM</h2>
                            <hr>
                        </div>
                        <div class="col-12">
                            <?php if($licitacion->id_tipo_licitacion == 3){ ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th><strong>Numero OC</strong></th>
                                            <th><strong>Item SP/OM</strong></th>
                                            <th><strong>Monto</strong></th>
                                            <th><strong>Descripción</strong></th>
                                            <th><strong>Informe técnico</strong></th>
                                            <th><strong>Número HAS</strong></th>
                                            <th><strong>Factura</strong></th>
                                            <th><strong>Estado</strong></th>
                                            <?php if ($licitacion->id_etapa < 25) { ?>
                                            <th><strong>Acciones</strong></th>
                                            <?php } ?>
                                        </thead>
                                        <tbody>
                                            <?php if($listadoItemSPOM){ foreach ($listadoItemSPOM as $itemspom1) { ?>
                                            <tr>
                                                <td><?php if($itemspom1->orden_cliente_item) echo $itemspom1->orden_cliente_item->ot_orden; ?></td>
                                                <td>{{ $itemspom1->item_spom }}</td>
                                                <td>${{ number_format($itemspom1->monto,0,',','.') }}</td>
                                                <td>{{ $itemspom1->descripcion }}</td>
                                                <td>
                                                    <?php if($itemspom1->url_informe_tecnico != ''){ ?>
                                                        <a href="{{ url('/') }}{{ $itemspom1->url_informe_tecnico }}" target="_blank">Visualizar</a>
                                                    <?php } ?>
                                                </td>
                                                <td>{{ $itemspom1->numero_has }}</td>
                                                <td>
                                                    <?php if($itemspom1->numero_factura != '' && $itemspom1->monto_factura != '' && $itemspom1->url_factura != ''){ ?>
                                                        N°{{ $itemspom1->numero_factura }} - ${{ number_format($itemspom1->monto_factura,0,',','.') }} - <a href="{{ url('/') }}{{ $itemspom1->url_factura }}" target="_blank"><i class="fas fa-file-pdf" style="color:red;font-size:20px"></i></a>
                                                    <?php } ?>
                                                </td>
                                                <td>{{ $itemspom1->estado_item }}</td>
                                                <?php if ($licitacion->id_etapa < 25) { ?>
                                                <td>
                                                    <?php if(Auth::user()->can('adjuntar-informe-tecnico')){ ?>
                                                        <?php if($itemspom1->estado == 0 || $itemspom1->estado == 3) { ?>
                                                            <button class="btn btn-sm btn-primary" onclick="modalAdjuntarInformeTecnicoItemSPOM({{ $itemspom1->id }},0)">Adjuntar Informe Técnico</button>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('aprobar-rechazar-informe-tecnico') && $itemspom1->estado == 1) { ?>
                                                        <a href="{{ url('aprobacion-adjunto-informe-tecnico-spom') }}/{{ $licitacion->id }}/{{ $itemspom1->id }}/0/2" onclick="return confirm('Esta seguro que desea aprobar el informe técnico seleccionado?')"><button class="btn btn-sm btn-success">Aprobar Informe</button></a>
                                                        <a href="{{ url('aprobacion-adjunto-informe-tecnico-spom') }}/{{ $licitacion->id }}/{{ $itemspom1->id }}/0/3" onclick="return confirm('Esta seguro que desea rechazar el informe técnico seleccionado?')"><button class="btn btn-sm btn-danger">Rechazar Informe</button></a>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('ingresar-has') && $itemspom1->estado == 2) { ?>
                                                        <button class="btn btn-sm btn-primary" onclick="modalIngresarHASItemSPOM({{ $itemspom1->id }},0)">Ingresar HAS</button>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('solicitar-facturar-has') && $itemspom1->estado == 4) { ?>
                                                        <a href="{{ url('registrar-solicitud-facturar-spom') }}/{{ $licitacion->id }}/{{ $itemspom1->id }}/0" onclick="return confirm('Esta seguro que desea solicitar facturar el SP/OM seleccionado?')"><button class="btn btn-sm btn-success">Solicitar Facturar</button></a>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('ingresar-factura-has') && $itemspom1->estado == 5) { ?>
                                                        <button class="btn btn-sm btn-primary" onclick="modalIngresarFacturaItemSPOM({{ $itemspom1->id }},0)">Ingresar Factura</button>
                                                    <?php } ?>
                                                </td>
                                                <?php } ?>
                                            </tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                            <?php if($licitacion->id_tipo_licitacion == 4){ ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th><strong>Nombre</strong></th>
                                            <th><strong>Item SP/OM</strong></th>
                                            <th><strong>Monto</strong></th>
                                            <th><strong>Descripción</strong></th>
                                            <th><strong>Informe técnico</strong></th>
                                            <th><strong>Número HAS</strong></th>
                                            <th><strong>Factura</strong></th>
                                            <th><strong>Estado</strong></th>
                                            <?php if ($licitacion->id_etapa < 25) { ?>
                                            <th><strong>Acciones</strong></th>
                                            <?php } ?>
                                        </thead>
                                        <tbody>
                                            <?php if($listadocotizacionesPGPAprobadas){ foreach ($listadocotizacionesPGPAprobadas as $itemspom1) { ?>
                                            <tr>
                                                <td>{{ $itemspom1->nombre }}</td>
                                                <td>{{ $itemspom1->spom_ordenservicio }}</td>
                                                <td>${{ number_format($itemspom1->monto_spom,0,',','.') }}</td>
                                                <td>{{ $itemspom1->descripcion_spom }}</td>
                                                <td>
                                                    <?php if($itemspom1->url_informe_tecnico != ''){ ?>
                                                        <a href="{{ url('/') }}{{ $itemspom1->url_informe_tecnico }}" target="_blank">Visualizar</a>
                                                    <?php } ?>
                                                </td>
                                                <td>{{ $itemspom1->numero_has }}</td>
                                                <td>
                                                    <?php if($itemspom1->numero_factura != '' && $itemspom1->monto_factura != '' && $itemspom1->url_factura != ''){ ?>
                                                        N°{{ $itemspom1->numero_factura }} - ${{ number_format($itemspom1->monto_factura,0,',','.') }} - <a href="{{ url('/') }}{{ $itemspom1->url_factura }}" target="_blank"><i class="fas fa-file-pdf" style="color:red;font-size:20px"></i></a>
                                                    <?php } ?>
                                                </td>
                                                <td>{{ $itemspom1->estado_item }}</td>
                                                <?php if ($licitacion->id_etapa < 25) { ?>
                                                <td>
                                                    <?php if(Auth::user()->can('adjuntar-informe-tecnico')){ ?>
                                                        <?php if($itemspom1->estado == 0 || $itemspom1->estado == 3) { ?>
                                                            <button class="btn btn-sm btn-primary" onclick="modalAdjuntarInformeTecnicoItemSPOMPGP({{ $itemspom1->id }})">Adjuntar Informe Técnico</button>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('aprobar-rechazar-informe-tecnico') && $itemspom1->estado == 1) { ?>
                                                        <a href="{{ url('aprobacion-adjunto-informe-tecnico-spom-PGP') }}/{{ $licitacion->id }}/{{ $itemspom1->id }}/2" onclick="return confirm('Esta seguro que desea aprobar el informe técnico seleccionado?')"><button class="btn btn-sm btn-success">Aprobar Informe</button></a>
                                                        <a href="{{ url('aprobacion-adjunto-informe-tecnico-spom-PGP') }}/{{ $licitacion->id }}/{{ $itemspom1->id }}/3" onclick="return confirm('Esta seguro que desea rechazar el informe técnico seleccionado?')"><button class="btn btn-sm btn-danger">Rechazar Informe</button></a>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('ingresar-has') && $itemspom1->estado == 2) { ?>
                                                        <button class="btn btn-sm btn-primary" onclick="modalIngresarHASItemSPOMPGP({{ $itemspom1->id }})">Ingresar HAS</button>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('solicitar-facturar-has') && $itemspom1->estado == 4) { ?>
                                                        <a href="{{ url('registrar-solicitud-facturar-spom-PGP') }}/{{ $licitacion->id }}/{{ $itemspom1->id }}" onclick="return confirm('Esta seguro que desea solicitar facturar el SP/OM seleccionado?')"><button class="btn btn-sm btn-success">Solicitar Facturar</button></a>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('ingresar-factura-has') && $itemspom1->estado == 5) { ?>
                                                        <button class="btn btn-sm btn-primary" onclick="modalIngresarFacturaItemSPOMPGP({{ $itemspom1->id }})">Ingresar Factura</button>
                                                    <?php } ?>
                                                </td>
                                                <?php } ?>
                                            </tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if($listadoItemSPOMAdicionales){ ?>
                            <div class="col-12">
                                <p><u>Trabajos Adicionales</u></p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th><strong>Numero OC</strong></th>
                                            <th><strong>Item SP/OM</strong></th>
                                            <th><strong>Monto</strong></th>
                                            <th><strong>Descripción</strong></th>
                                            <th><strong>Informe técnico</strong></th>
                                            <th><strong>Número HAS</strong></th>
                                            <th><strong>Factura</strong></th>
                                            <th><strong>Estado</strong></th>
                                            <?php if ($licitacion->id_etapa < 25) { ?>
                                            <th><strong>Acciones</strong></th>
                                            <?php } ?>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($listadoItemSPOMAdicionales as $itemspom2) { ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                        if($itemspom2->orden_cliente_item){
                                                            if($itemspom2->orden_cliente_item->ot_orden){
                                                                echo $itemspom2->orden_cliente_item->ot_orden;
                                                            }else{
                                                                echo $itemspom2->orden_cliente_item->nombre_oc;
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                                <td>{{ $itemspom2->item_spom }}</td>
                                                <td>${{ number_format($itemspom2->monto,0,',','.') }}</td>
                                                <td>{{ $itemspom2->descripcion }}</td>
                                                <td>
                                                    <?php if($itemspom2->url_informe_tecnico != ''){ ?>
                                                        <a href="{{ url('/') }}{{ $itemspom2->url_informe_tecnico }}" target="_blank">Visualizar</a>
                                                    <?php } ?>
                                                </td>
                                                <td>{{ $itemspom2->numero_has }}</td>
                                                <td>
                                                    <?php if($itemspom2->numero_factura != '' && $itemspom2->monto_factura != '' && $itemspom2->url_factura != ''){ ?>
                                                        N°{{ $itemspom2->numero_factura }} - ${{ number_format($itemspom2->monto_factura,0,',','.') }} - <a href="{{ url('/') }}{{ $itemspom2->url_factura }}" target="_blank"><i class="fas fa-file-pdf" style="color:red;font-size:20px"></i></a>
                                                    <?php } ?>
                                                </td>
                                                <td>{{ $itemspom2->estado_item }}</td>
                                                <?php if ($licitacion->id_etapa < 25) { ?>
                                                <td>
                                                    <?php if(Auth::user()->can('adjuntar-informe-tecnico')){ ?>
                                                        <?php if($itemspom2->estado == 0 || $itemspom2->estado == 3) { ?>
                                                            <button class="btn btn-sm btn-primary" onclick="modalAdjuntarInformeTecnicoItemSPOM({{ $itemspom2->id }},1)">Adjuntar Informe Técnico</button>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('aprobar-rechazar-informe-tecnico') && $itemspom2->estado == 1) { ?>
                                                        <a href="{{ url('aprobacion-adjunto-informe-tecnico-spom') }}/{{ $licitacion->id }}/{{ $itemspom2->id }}/1/2" onclick="return confirm('Esta seguro que desea aprobar el informe técnico seleccionado?')"><button class="btn btn-sm btn-success">Aprobar Informe</button></a>
                                                        <a href="{{ url('aprobacion-adjunto-informe-tecnico-spom') }}/{{ $licitacion->id }}/{{ $itemspom2->id }}/1/3" onclick="return confirm('Esta seguro que desea rechazar el informe técnico seleccionado?')"><button class="btn btn-sm btn-danger">Rechazar Informe</button></a>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('ingresar-has') && $itemspom2->estado == 2) { ?>
                                                        <button class="btn btn-sm btn-primary" onclick="modalIngresarHASItemSPOM({{ $itemspom2->id }},1)">Ingresar HAS</button>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('solicitar-facturar-has') && $itemspom2->estado == 4) { ?>
                                                        <a href="{{ url('registrar-solicitud-facturar-spom') }}/{{ $licitacion->id }}/{{ $itemspom2->id }}/1" onclick="return confirm('Esta seguro que desea solicitar facturar el SP/OM seleccionado?')"><button class="btn btn-sm btn-success">Solicitar Facturar</button></a>
                                                    <?php } ?>
                                                    <?php if(Auth::user()->can('ingresar-factura-has') && $itemspom2->estado == 5) { ?>
                                                        <button class="btn btn-sm btn-primary" onclick="modalIngresarFacturaItemSPOM({{ $itemspom2->id }},1)">Ingresar Factura</button>
                                                    <?php } ?>
                                                </td>
                                                <?php } ?>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 24 && Auth::user()->can('solicitar-cierre-proyecto')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ url('/registrar-solicitud-cierre-proyecto') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea solicitar el cierre del proyecto?')">
                            <button type="button" class="btn btn-primary" style="margin-right: 10px;">Solicitar Cierre Proyecto</button>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa > 24) { ?>
                    <hr>
                    <div class="row py-6 px-9">
                        <div class="col-6">
                            Proceso Cierre
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Fecha Solicitud Cierre</th>
                                        <?php if ($licitacion->id_etapa >= 25) { ?>
                                        <th>Fecha Cierre Proyecto</th>
                                        <?php } ?>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $licitacion->fecha_solicitud_cierre_proyecto }}</td>
                                            <?php if ($licitacion->id_etapa >= 25) { ?>
                                            <td>{{ $licitacion->fecha_cierre_proyecto }}</td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 25 && Auth::user()->can('cerrar-proyecto')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ url('/registrar-cierre-proyecto') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea cerrar del proyecto?')">
                            <button type="button" class="btn btn-primary" style="margin-right: 10px;">Cerrar Proyecto</button>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 26 && Auth::user()->can('ingresar-informe-kpi-servicio')) { ?>
                    <hr>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdjuntarInformeKPIServicio">Adjuntar Informe KPI del Servicio</button>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa > 26) { ?>
                    <hr>
                    <div class="row py-6 px-9">
                        <div class="col-12">
                            <h5>Informe KPI Servicio</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Adjunto</th>
                                        <th>Facturado Total Proyecto</th>
                                        <th>Costo Total Mano Obra</th>
                                        <th>Porcentaje CMO</th>
                                        <th>Costo Directo Total</th>
                                        <th>Porcentaje CDO</th>
                                        <th>Costo Total Proyecto</th>
                                        <th>Porcentaje CTP</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="{{ url('/') }}{{ $licitacion->url_informe_kpi_servicio }}" target="_blank">Visualizar</a></td>
                                            <td>${{ number_format($licitacion->costo_facturado_total_proyecto,0,',','.') }}</td>
                                            <td>${{ number_format($licitacion->costo_mano_obra,0,',','.') }}</td>
                                            <td>{{ $licitacion->porcentajecmo }}%</td>
                                            <td>${{ number_format($licitacion->costo_directo_obra,0,',','.') }}</td>
                                            <td>{{ $licitacion->porcentajecostodirectoobra }}%</td>
                                            <td>${{ number_format($licitacion->costo_total_proyecto,0,',','.') }}</td>
                                            <td>{{ $licitacion->porcentajecostototalproyecto }}%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <?php if ($licitacion->id_etapa == 27 && Auth::user()->can('cerrar-centro-costo')) { ?>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ url('/registrar-cierre-centro-costo') }}/{{ $licitacion->id }}" onclick="return confirm('¿Esta seguro que desea cerrar el centro de costo del proyecto?')">
                            <button type="button" class="btn btn-primary" style="margin-right: 10px;">Cerrar Centro Costo</button>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($licitacion->id_etapa > 27) { ?>
                    <hr>
                    <div class="row py-6 px-9">
                        <div class="col-6">
                            Centro Costo
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Fecha Cierre</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $licitacion->f_cierre_centro_costo }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalIngresarResultadoAdjudicacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
                <form method="post" action="{{ route('licit-resultado-adjudicacion') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Ingresar Resultado Adjudicación</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nombre</strong> {{ $licitacion->titulo }}
                            <br>
                            <strong>Folio N°</strong> {{ $licitacion->id }}
                            <br>
                            <strong>Fecha Creación</strong> {{ $licitacion->fecha_creacion }}
                        </div>
                        <div class="col-md-6">
                            <strong>Tipo Licitación/Cotización</strong> {{ $licitacion->tipo->nombre }}
                            <br>
                            <strong>Empresa</strong> {{ $licitacion->empresa->nombre }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="estado_adjudicacion1" style="color:red"><input type="radio" onChange="onchangeadjudicacion(this)" name="estado_adjudicacion" id="estado_adjudicacion1" value="19" checked> <b>No Adjudicada</b></label>
                            <label for="estado_adjudicacion2" style="color:green;"><input type="radio" onChange="onchangeadjudicacion(this)" name="estado_adjudicacion" id="estado_adjudicacion2" value="20"> <b>Adjudicada</b></label>
                        </div>
                    </div>
                    <hr>
                    <div id="divnoAdjudicacion" class="row">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="observaciones_no_adjudicacion">
                                <span class="">Observaciones</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Observaciones no Adjudicación"></i>
                            </label>
                            <textarea id="observaciones_no_adjudicacion" name="observaciones_no_adjudicacion" maxlength="150" class="form-control"></textarea>
                        </div>
                    </div>
                    <div id="divAdjudicacion" style="display:none;" class="row">
                        <?php if($licitacion->id_tipo_licitacion == 3){ ?>
                            <div class="col-6">
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="orden_cliente">
                                        <span class="">Adjunto Orden Servicio</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Orden Cliente Adjudicación"></i>
                                    </label>
                                    <input type="file" class="form-control" name="orden_cliente" id="orden_cliente" required>
                                </div>
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="fechainicio_oc">
                                        <span class="">Fecha Inicio</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Fecha Inicio Adjudicación"></i>
                                    </label>
                                    <input type="date" class="form-control" name="fechainicio_oc" id="fechainicio_oc">
                                </div>
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="fechatermino_oc">
                                        <span class="">Fecha Termino</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Fecha Termino Adjudicación"></i>
                                    </label>
                                    <input type="date" class="form-control" name="fechatermino_oc" id="fechatermino_oc">
                                </div>
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="montoadjudicado">
                                        <span class="">Monto Adjudicado</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Monto Adjudicación"></i>
                                    </label>
                                    <input type="text" class="form-control" name="montoadjudicado" id="montoadjudicado" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(montoadjudicado.value, 'montoadjudicado');" onfocus="limpiaPuntoGuion('montoadjudicado')" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <h2>ITEMS SP/OM</h2>
                                <!--<input type="button" class="btn btn-sm btn-success" id="btnagregaritemspom" value="Agregar Nuevo Item">-->
                                <div class="table-responsive">
                                    <table id="detalles" class="table table-centered mb-0 table-nowrap">
                                        <thead class="thead-light">
                                            <!--<th>/</th>-->
                                            <th>SP/OM</th>
                                            <th>Descripción</th>
                                            <th>$ Monto</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <tr class="selected" id="fila0">
                                                <!--
                                                <td>
                                                    <button class="btn btn-sm btn-danger" type="button" onclick="eliminar(0);">X</button>
                                                </td>
                                                -->
                                                <td>
                                                    <input type="hidden" name="fila_item[]" id="fila_item[]" value="0">
                                                    <input class="form-control" type="text" name="spomitem[0]">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="descripcionitem[0]">
                                                </td>
                                                <td>
                                                    <input class="form-control montoitem0" type="text" name="montoitem[0]" id="montoitem0" onkeypress="return solo_numeros(event)" onblur="checkValorNumericoFactItemSPOM(0);" onfocus="limpiaPuntoGuionItemSPOM(0)">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($licitacion->id_tipo_licitacion == 4){ ?>
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Adjunto Orden Servicio</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Termino</th>
                                        <th>SP/OM</th>
                                        <th>Descripción</th>
                                        <th>$ Monto SP/OM</th>
                                    </thead>
                                    <tbody>
                                        <?php $filaadj = 0; if($listadocotizacionesPGPAprobadas){ foreach ($listadocotizacionesPGPAprobadas as $cotaprob) { $filaadj++; ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="filaadjpgp[]" value="{{$filaadj}}">
                                                <input type="hidden" class="form-control" name="adjpgp_id[{{$filaadj}}]" id="adjpgp_id[{{$filaadj}}]" value="{{$cotaprob->id}}">
                                                {{$cotaprob->nombre}}
                                            </td>
                                            <td><input type="file" class="form-control" id="adjpgp_orden_cliente[{{$filaadj}}]" name="adjpgp_orden_cliente[{{$filaadj}}][file]"></td>
                                            <td><input type="date" class="form-control" name="adjpgp_fechainicio_oc[{{$filaadj}}]" id="adjpgp_fechainicio_oc[{{$filaadj}}]"></td>
                                            <td><input type="date" class="form-control" name="adjpgp_fechatermino_oc[{{$filaadj}}]" id="adjpgp_fechatermino_oc[{{$filaadj}}]"></td>
                                            <td><input type="text" class="form-control" name="adjpgp_spom[{{$filaadj}}]" id="adjpgp_spom[{{$filaadj}}]"></td>
                                            <td><input type="text" class="form-control" name="adjpgp_descripcionspom[{{$filaadj}}]" id="adjpgp_descripcionspom[{{$filaadj}}]"></td>
                                            <td><input type="text" class="form-control" name="adjpgp_montospom[{{$filaadj}}]" id="adjpgp_montospom[{{$filaadj}}]"></td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
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

<div class="modal fade" id="modalInformarInicioServicio" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('registrar-ejecucion-servicio') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Informar Inicio Servicio Licitación</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="fechainicioservicio">
                            <span class="">Fecha Inicio</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Fecha inicio servicio de la licitación"></i>
                        </label>
                        <input type="date" class="form-control form-control-solid" name="fechainicioservicio" id="fechainicioservicio" value="{{ date('Y-m-d') }}"/>
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

<div class="modal fade" id="modalInformarTerminoServicio" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('registrar-termino-servicio') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Informar Termino Servicio Licitación</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="fechaterminoservicio">
                            <span class="">Fecha Termino</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Fecha inicio servicio de la licitación"></i>
                        </label>
                        <input type="date" class="form-control form-control-solid" name="fechaterminoservicio" id="fechaterminoservicio" value="{{ date('Y-m-d') }}"/>
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

<div class="modal fade" id="modalIngresarTrabajoAdicional" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
                <form method="post" action="{{ route('registrar-trabajo-adicional') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Ingresar Trabajo Adicional</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="trabj_adic_nuevaoc" style="color:green;font-size: 20px;"><input type="radio" name="trabajoadicionaloc" id="trabj_adic_nuevaoc" value="1" checked> <b>OC Nueva</b></label>
                            <label for="trabj_adic_mismaoc" style="color:red;font-size: 20px;"><input type="radio" name="trabajoadicionaloc" id="trabj_adic_mismaoc" value="0"> <b>Misma OC</b></label>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="montotrabajoadicional">
                            <span class="">Monto</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Monto Trabajo Adicional"></i>
                        </label>
                        <input type="text" class="form-control" name="montotrabajoadicional" id="montotrabajoadicional" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(montotrabajoadicional.value, 'montotrabajoadicional');" onfocus="limpiaPuntoGuion('montotrabajoadicional')" required>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="descripciontrabajoadicional">
                            <span class="">Descripción</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Descripción del trabajo adicional"></i>
                        </label>
                        <textarea id="descripciontrabajoadicional" name="descripciontrabajoadicional" maxlength="150" class="form-control"></textarea>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="nombre_ordenservicio_trabadic">
                                <span class="">Nombre Orden Servicio (opcional)</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Nombre Orden de Servicio del Trabajo Adicional"></i>
                            </label>
                            <input type="text" class="form-control" name="nombre_ordenservicio_trabadic" id="nombre_ordenservicio_trabadic">
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjunto_orden_servicio_trab_adic">
                                <span class="">Adjunto Orden Servicio (opcional)</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Orden Servicio Trabajo Adicional Adjudicación"></i>
                            </label>
                            <input type="file" class="form-control" name="adjunto_orden_servicio_trab_adic" id="adjunto_orden_servicio_trab_adic">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h2>ITEMS SP/OM</h2>
                            <input type="button" class="btn btn-sm btn-success" id="btnagregaritemspomtrabajoadicional" value="Agregar Nuevo Item">
                            <div class="table-responsive">
                                <table id="detallestrabajoadicional" class="table table-centered mb-0 table-nowrap">
                                    <thead class="thead-light">
                                        <th>/</th>
                                        <th>SP/OM</th>
                                        <th>Descripción</th>
                                        <th>$ Monto</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <tr class="selected" id="filatrabjadic0">
                                            <td>
                                                <button class="btn btn-sm btn-danger" type="button" onclick="eliminartrabadic(0);">X</button>
                                            </td>
                                            <td>
                                                <input type="hidden" name="fila_item[]" id="fila_item[]" value="0">
                                                <input class="form-control" type="text" name="spomitem[0]">
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="descripcionitem[0]">
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="montoitem[0]" id="montoitem0" onkeypress="return solo_numeros(event)" onblur="checkValorNumericoTrabajoAdicional(0);" onfocus="limpiaPuntoGuionTrabajosAdicionales(0)">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

<div class="modal fade" id="modalAdjuntarInformeTecnicoSPOM" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('licit-registrar-adjunto-informe-tecnico-spom') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <input type="hidden" name="idregistroitem" id="spom_idregistroitem" value="">
                    <input type="hidden" name="istrabajoadicional" id="spom_istrabajoadicional" value="">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Adjuntar Informe Técnico SP/OM</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntoinformetecnico">
                            <span class="">Adjunto</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar informe técnico del SP/OM"></i>
                        </label>
                        <input type="file" class="form-control form-control-solid" name="adjuntoinformetecnico" id="adjuntoinformetecnico" required/>
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

<div class="modal fade" id="modalIngresarHASSPOM" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('licit-registrar-has-spom') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <input type="hidden" name="idregistroitem" id="spom_idregistroitem2" value="">
                    <input type="hidden" name="istrabajoadicional" id="spom_istrabajoadicional2" value="">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Ingresar Número HAS SP/OM</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="numerohas">
                            <span class="">HAS</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Número HAS item SP/OM"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="numerohas" id="numerohas" required/>
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

<div class="modal fade" id="modalIngresarFacturaHASSPOM" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('licit-registrar-factura-has-spom') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <input type="hidden" name="idregistroitem" id="spom_idregistroitem3" value="">
                    <input type="hidden" name="istrabajoadicional" id="spom_istrabajoadicional3" value="">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Ingresar Datos Factura HAS SP/OM</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="numerofactura">
                            <span class="">Número Factura</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Número Factura Item SP/OM"></i>
                        </label>
                        <input type="number" class="form-control form-control-solid" name="numerofactura" id="numerofactura" min="0" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="montofactura">
                            <span class="">Monto Factura</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Monto Factura HAS Item SP/OM"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="montofactura" id="montofactura" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(montofactura.value, 'montofactura');" onfocus="limpiaPuntoGuion('montofactura')" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntofacturahas">
                            <span class="">Adjunto Factura</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjunto Factura HAS Item SP/OM"></i>
                        </label>
                        <input type="file" class="form-control form-control-solid" name="adjuntofacturahas" id="adjuntofacturahas" required/>
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

<div class="modal fade" id="modalAdjuntarInformeKPIServicio" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('licit-registrar-adjunto-informe-kpi-servicio') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Adjuntar Informe KPI del Servicio</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="facturado_total_proyecto">
                            <span class="">Facturado Total Proyecto</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Valor facturado total del proyecto"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="facturado_total_proyecto" id="facturado_total_proyecto" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(facturado_total_proyecto.value, 'facturado_total_proyecto');calcularinformekpiservicio();" onfocus="limpiaPuntoGuion('facturado_total_proyecto');" required/>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="costo_mano_obra">
                                    <span class="">Costo Total Mano Obra</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Valor costo total mano de obra del proyecto"></i>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="costo_mano_obra" id="costo_mano_obra" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(costo_mano_obra.value, 'costo_mano_obra');calcularinformekpiservicio();" onfocus="limpiaPuntoGuion('costo_mano_obra');" required/>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="">
                                    <span class="">Porcentaje CMO</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Porcentaje costo total mano de obra"></i>
                                </label>
                                <label id="labelporcentajecmo"></label>
                                <input type="hidden" name="porcentajecmo" id="porcentajecmo"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="costo_directo_obra">
                                    <span class="">Costo Directo Obra</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Valor costo directo total del proyecto"></i>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="costo_directo_obra" id="costo_directo_obra" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(costo_directo_obra.value, 'costo_directo_obra');calcularinformekpiservicio();" onfocus="limpiaPuntoGuion('costo_directo_obra');" required/>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="">
                                    <span class="">Porcentaje CDO</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Porcentaje costo directo de obra"></i>
                                </label>
                                <label id="labelporcentajecostodirectoobra"></label>
                                <input type="hidden" name="porcentajecostodirectoobra" id="porcentajecostodirectoobra"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="">
                                    <span class="">Costo Total Proyecto</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Costo total del proyecto"></i>
                                </label>
                                <label id="labelcostototalproyecto"></label>
                                <input type="hidden" name="costototalproyecto" id="costototalproyecto"/>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="">
                                    <span class="">Porcentaje CTP</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Porcentaje costo total del proyecto"></i>
                                </label>
                                <label id="labelporcentajecostototalproyecto"></label>
                                <input type="hidden" name="porcentajecostototalproyecto" id="porcentajecostototalproyecto"/>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntoinformekpi">
                            <span class="">Adjunto</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar informe kpi del servicio"></i>
                        </label>
                        <input type="file" class="form-control form-control-solid" name="adjuntoinformekpi" id="adjuntoinformekpi" required/>
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

<div class="modal fade" id="modalHistorialCotizaciones" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
                <div class="mb-13 text-center">
                    <h1 class="mb-3">Historial Valores Cotización</h1>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-centered mb-0 table-nowrap">
                                <thead class="thead-light">
                                    <th>Versión</th>
                                    <th>Usuario</th>
                                    <th>Personal</th>
                                    <th>Materiales</th>
                                    <th>Servicios</th>
                                    <th>Margen %</th>
                                    <th>Observaciones</th>
                                    <th>Fecha/Hora</th>
                                </thead>
                                <tbody>
                                    <?php
                                        $totalversiones = count($itemhistorial);
                                        if($itemhistorial){
                                            foreach ($itemhistorial as $historial) {
                                                $totalversiones--;
                                    ?>
                                    <tr class="selected" id="fila0">
                                        <td>
                                            <?php
                                                if($totalversiones == 0){
                                                    echo "Versión Original";
                                                }else{
                                                    echo "V".$totalversiones;
                                                }
                                            ?>
                                        </td>
                                        <td>{{ $historial->usuario->name.' '.$historial->usuario->ap_paterno.' '.$historial->usuario->ap_materno }}</td>
                                        <td>${{ number_format($historial->valor_item_personal,0,',','.') }}</td>
                                        <td>${{ number_format($historial->valor_item_materiales,0,',','.') }}</td>
                                        <td>${{ number_format($historial->valor_itemservicios,0,',','.') }}</td>
                                        <td>${{ number_format($historial->valor_itemmargen,0,',','.') }}</td>
                                        <td>{{ $historial->observacionesreenviorevisioncotizacion }}</td>
                                        <td>{{ $historial->created_at }}</td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--PGP-->
<div class="modal fade" id="modalAdjuntarInformeTecnicoSPOMPGP" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('licit-registrar-adjunto-informe-tecnico-spom-PGP') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <input type="hidden" name="spom_idregistrocotizPGP" id="spom_idregistrocotizPGP" value="">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Adjuntar Informe Técnico SP/OM</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntoinformetecnico">
                            <span class="">Adjunto</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar informe técnico del SP/OM"></i>
                        </label>
                        <input type="file" class="form-control form-control-solid" name="adjuntoinformetecnico" id="adjuntoinformetecnico" required/>
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

<div class="modal fade" id="modalIngresarHASSPOMPGP" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('licit-registrar-has-spom-PGP') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <input type="hidden" name="spom_idregistroitem2PGP" id="spom_idregistroitem2PGP" value="">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Ingresar Número HAS SP/OM</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="numerohas">
                            <span class="">HAS</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Número HAS item SP/OM"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="numerohas" id="numerohas" required/>
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

<div class="modal fade" id="modalIngresarFacturaHASSPOMPGP" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('licit-registrar-factura-has-spom-PGP') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" name="idlicitacion" value="{{ $licitacion->id }}">
                    <input type="hidden" name="idregistroitem" id="spom_idregistroitem3PGP" value="">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Ingresar Datos Factura HAS SP/OM</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="numerofactura">
                            <span class="">Número Factura</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Número Factura Item SP/OM"></i>
                        </label>
                        <input type="number" class="form-control form-control-solid" name="numerofactura" id="numerofactura" min="0" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="montofactura">
                            <span class="">Monto Factura</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Monto Factura HAS Item SP/OM"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" name="montofactura" id="montofactura" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(montofactura.value, 'montofactura');" onfocus="limpiaPuntoGuion('montofactura')" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntofacturahas">
                            <span class="">Adjunto Factura</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjunto Factura HAS Item SP/OM"></i>
                        </label>
                        <input type="file" class="form-control form-control-solid" name="adjuntofacturahas" id="adjuntofacturahas" required/>
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
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("formularioenviarcotizacionspot").addEventListener('submit', validarvalorcotizacionspot); 
    });

    numericosAlCargarCotizacion();
    calcularcotizacionmack();

    var contador = 1;
    var contador2 = 1;
    var contcot = parseInt($("#cont_cotizaciones_actual").val()) + 1;

    function onchangeadjudicacion(sel){
        if(sel.value=="20"){
            $("#divAdjudicacion").show();
            $('#divAdjudicacion *').prop('disabled',false);
            $("#divnoAdjudicacion").hide();
            $('#divnoAdjudicacion *').prop('disabled',true);
        }else{
            $("#divnoAdjudicacion").show();
            $('#divnoAdjudicacion *').prop('disabled',false);
            $("#divAdjudicacion").hide();
            $('#divAdjudicacion *').prop('disabled',true);
        }
    }

    $('#btnagregaritemspom').click(function(){
        var idmontoagregar = 'montoitem'+contador;

        var fila = "<tr class='selected' id='fila"+contador+"'><td><button class='btn btn-sm btn-danger' type='button' onclick='eliminar("+contador+");'>X</button></td><td><input type='hidden' name='fila_item[]' id='fila_item[]' value='"+contador+"'><input class='form-control' type='text' name='spomitem["+contador+"]'></td><td><input class='form-control' type='text' name='descripcionitem["+contador+"]'></td><td><input class='form-control "+idmontoagregar+"' type='text' name='montoitem["+contador+"]' id='"+idmontoagregar+"' onkeypress='return solo_numeros(event)' onblur='checkValorNumericoFactItemSPOM("+contador+");' onfocus='limpiaPuntoGuionItemSPOM("+contador+")'></td></tr>";
        $('#detalles').append(fila);
        contador++;
    });

    function eliminar(index){
        $('#fila'+index).remove();
    }

    $('#btnagregaritemspomtrabajoadicional').click(function(){
        var fila = '<tr class="selected" id="filatrabjadic'+contador2+'"><td><button class="btn btn-sm btn-danger" type="button" onclick="eliminartrabadic('+contador2+');">X</button></td><td><input type="hidden" name="fila_item[]" id="fila_item[]" value="'+contador2+'"><input class="form-control" type="text" name="spomitem['+contador2+']"></td><td><input class="form-control" type="text" name="descripcionitem['+contador2+']"></td><td><input class="form-control" type="text" name="montoitem['+contador2+']" id="montoitem'+contador2+'" onkeypress="return solo_numeros(event)" onblur="checkValorNumericoTrabajoAdicional('+contador2+');" onfocus="limpiaPuntoGuionTrabajosAdicionales('+contador2+')"></td></tr>';
        $('#detallestrabajoadicional').append(fila);
        contador2++;
    });

    function eliminartrabadic(index){
        $('#filatrabjadic'+index).remove();
    }

    //cotizaciones PGP
    $('#btnagregarcotizacionPGP').click(function(){
        var fila = "<tr class='selected' id='filaCOTpgp"+contcot+"'><td><button class='btn btn-sm btn-danger' type='button' onclick='eliminarCotPGP("+contcot+");'>X</button></td><td><input type='text' class='form-control' id='cot_nombre["+contcot+"]' name='cot_nombre["+contcot+"]' value=''></td><td><input type='hidden' name='fila_cotizacion[]' id='fila_cotizacion[]' value='"+contcot+"'><input type='text' class='form-control' id='cot_valor_total"+contcot+"' name='cot_valor_total["+contcot+"]' value='0' onchange='javascript:calcularcotizacionmack();' onkeypress='return solo_numeros(event)' onblur='checkValorNumericoCotizacionesPGPValorTotal("+contcot+");' onfocus='limpiaPuntoGuionCotizacionesPGPValorTotal("+contcot+")'></td><td><input type='file' class='form-control' id='cot_ic_evaluacion_economica["+contcot+"]' name='cot_ic_evaluacion_economica["+contcot+"][file]' value='0' onchange='javascript:calcularcotizacionmack();' onkeypress='return solo_numeros(event)' onblur='checkValorNumerico(ic_montomaterial.value, ic_montomaterial);' onfocus='limpiaPuntoGuion(ic_montomaterial)'></td><td><input type='text' class='form-control' id='cot_ic_montopersonal"+contcot+"' name='cot_ic_montopersonal["+contcot+"]' value='0' onchange='javascript:calcularcotizacionmack();' onkeypress='return solo_numeros(event)' onblur='checkValorNumericoCotizacionesPGPMontoPersonal("+contcot+");' onfocus='limpiaPuntoGuionCotizacionesPGPMontoPersonal("+contcot+")'></td><td><input type='text' class='form-control' id='cot_ic_montomaterial"+contcot+"' name='cot_ic_montomaterial["+contcot+"]' value='0' onchange='javascript:calcularcotizacionmack();' onkeypress='return solo_numeros(event)' onblur='checkValorNumericoCotizacionesPGPMontoMaterial("+contcot+");' onfocus='limpiaPuntoGuionCotizacionesPGPMontoMaterial("+contcot+")'></td><td><input type='text' class='form-control' id='cot_ic_montoequipos"+contcot+"' name='cot_ic_montoequipos["+contcot+"]' value='0' onchange='javascript:calcularcotizacionmack();' onkeypress='return solo_numeros(event)' onblur='checkValorNumericoCotizacionesPGPMontoEquipos("+contcot+");' onfocus='limpiaPuntoGuionCotizacionesPGPMontoEquipos("+contcot+")'></td><td><div id='ic_ggutilidaddisableddiv"+contcot+"' style='display:none;'></div><input type='hidden' class='form-control' id='cot_ic_ggutilidad"+contcot+"' name='cot_ic_ggutilidad["+contcot+"]' value='0'><input type='text' class='form-control' id='cot_ic_ggutilidaddisabled"+contcot+"' name='cot_ic_ggutilidaddisabled["+contcot+"]' value='0' disabled></td><td><div id='ic_totalnetodisableddiv"+contcot+"' style='display:none;'></div><input type='hidden' class='form-control' id='cot_ic_totalneto"+contcot+"' name='cot_ic_totalneto["+contcot+"]' value='0'><input type='text' class='form-control' id='cot_ic_totalnetodisabled"+contcot+"' name='cot_ic_totalnetodisabled["+contcot+"]' value='0' disabled></td><td><input type='number' class='form-control' id='cot_ic_montomargen"+contcot+"' name='cot_ic_montomargen["+contcot+"]' value='0' min='0' max='100' onchange='javascript:calcularcotizacionmack();'></td></tr>";
        $('#tablecotizaciones').append(fila);
        contcot++;
    });

    function eliminarCotPGP(index){
        $('#filaCOTpgp'+index).remove();
    }

</script>

@endsection
