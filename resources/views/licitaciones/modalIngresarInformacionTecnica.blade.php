<div class="modal-header">
    <h5 class="modal-title" id="myModalLabel">Gestionar Información Técnica Licitación/Cotización N° {{ $licitacion->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
{!! Form::open(['method' => 'POST', 'route' => ['licit-ingresar-informacion-tecnica'], 'autocomplete' => 'off', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <input type="hidden" id="idlicitacion" name="idlicitacion" value="<?php echo $licitacion->id ?>">
                <div class="row">
                    <div class="col-6">
                        <strong>Título: </strong>{{ $licitacion->titulo }}<br>
                        <strong>Tipo: </strong>{{ $licitacion->tipo->nombre }}<br>
                        <!--<strong>Monto: </strong>${{ number_format($licitacion->monto_cotizacion,0,',','.') }}<br>-->
                    </div>
                    <div class="col-6">
                        <strong>Empresa: </strong>{{ $licitacion->empresa->nombre }}<br>
                        <strong>Etapa: </strong>{{ $licitacion->etapa->nombre }}<br>
                        <strong>Fecha Creación: </strong>{{ $licitacion->fecha_creacion }}
                    </div>
                    <hr>
                    <div class="col-12">
                        <strong>Grupo: </strong>{{ $licitacion->grupo->nombre_grupo }}
                    </div>
                    <div class="col-6">
                        <strong>Jefe Operaciones: </strong>{{ $licitacion->jefeoperaciones->name.' '.$licitacion->jefeoperaciones->ap_paterno.' '.$licitacion->jefeoperaciones->ap_materno }}<br>
                        <strong>Responsable (Administrador de Terreno): </strong>{{ $licitacion->responsable->name.' '.$licitacion->responsable->ap_paterno.' '.$licitacion->responsable->ap_materno }}<br>
                    </div>
                    <div class="col-6">
                        <strong>Planificación: </strong>{{ $licitacion->planificador->name.' '.$licitacion->planificador->ap_paterno.' '.$licitacion->planificador->ap_materno }}<br>
                        <strong>Contabilidad: </strong>{{ $licitacion->contabilidad->name.' '.$licitacion->contabilidad->ap_paterno.' '.$licitacion->contabilidad->ap_materno }}<br>
                    </div>
                    <hr>
                    <div class="col-12">
                        <strong>Información Visita</strong>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>Responsable (Administrador de Terreno)</th>
                                    <th>Registra Visita</th>
                                    <th>Bases Técnicas</th>
                                    <th>Archivo Visita</th>
                                    <th>Observaciones</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $licitacion->responsable->name.' '.$licitacion->responsable->ap_paterno.' '.$licitacion->responsable->ap_materno }}</td>
                                        <td><?php if($licitacion->aceptacion_con_visita == 1){ echo "SI"; }else{ echo "NO"; } ?></td>
                                        <td><a href="{{ url('/') }}{{ $licitacion->url_bases }}" target="_blank">{{ $licitacion->nombre_archivo_bases_tecnicas }}</a></td>
                                        <td><a href="{{ url('/') }}{{ $licitacion->url_visita }}" target="_blank">{{ $licitacion->nombre_archivo_visita }}</a></td>
                                        <td>{{ $licitacion->observaciones }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3">
                        <p>Archivo Adicionales</p>
                    </div>
                    <div class="col-9">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntocotizacion">
                                <span class="required">Cotización</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento cotización de la licitación"></i>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="adjuntocotizacion" id="adjuntocotizacion" required/>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntoinvitacion">
                                <span>Invitación</span>
                                <?php if($licitacion->url_archivo_invitacion != ''){ ?><a href="{{ url('/') }}{{ $licitacion->url_archivo_invitacion }}" target="_blank">Ver Adjunto Anterior</a><?php } ?>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento invitación de la licitación"></i>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="adjuntoinvitacion" id="adjuntoinvitacion"/>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3">
                        <p>Documentos Asociados</p>
                    </div>
                    <div class="col-9">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntocartagantt">
                                <span>Carta Gantt</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento carta gantt de la licitación"></i>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="adjuntocartagantt" id="adjuntocartagantt"/>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntoorganigrama">
                                <span>Organigrama</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento organigrama de la licitación"></i>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="adjuntoorganigrama" id="adjuntoorganigrama"/>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntopasoapasochecklist">
                                <span>Paso a Paso y Check List</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento paso a paso y check list de la licitación"></i>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="adjuntopasoapasochecklist" id="adjuntopasoapasochecklist"/>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntomatrizriesgo">
                                <span>Matriz de Riesgo y COD</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento matriz de riesgo y cod de la licitación"></i>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="adjuntomatrizriesgo" id="adjuntomatrizriesgo"/>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntoinformefinal">
                                <span>Informe Final</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento informe final de la licitación"></i>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="adjuntoinformefinal" id="adjuntoinformefinal"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary waves-effect">Guardar</button>
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
    </div>
{!! Form::close() !!}