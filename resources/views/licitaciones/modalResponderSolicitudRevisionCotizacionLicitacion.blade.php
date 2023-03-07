<div class="modal-header">
    <h5 class="modal-title" id="myModalLabel">Responder Solicitud Revisión Cotización Licitación/Cotización N° {{ $licitacion->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
{!! Form::open(['method' => 'POST', 'route' => ['licit-responder-revision-cotizacion'], 'autocomplete' => 'off', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <input type="hidden" id="idlicitacion" name="idlicitacion" value="<?php echo $licitacion->id ?>">
                <div class="row">
                    <div class="col-6">
                        <strong>Titulo: </strong>{{ $licitacion->titulo }}<br>
                        <strong>Tipo: </strong>{{ $licitacion->tipo->nombre }}<br>
                        <strong>Fecha Creación: </strong>{{ $licitacion->fecha_creacion }}
                    </div>
                    <div class="col-6">
                        <strong>Empresa: </strong>{{ $licitacion->empresa->nombre }}<br>
                        <strong>Etapa: </strong><font color="red"><b>{{ $licitacion->etapa->nombre }}</b></font><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="valorcotizacion">
                                <span style="color: red;"><b>Valor Total Cotización</b></span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Valor cotización de la licitación"></i>
                            </label>
                            <label>${{ number_format($licitacion->monto_cotizacion,0,',','.') }}</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="valorcotizacion">
                                <span style="color: red;"><b>Evaluación Económica</b></span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjunto evaluación económica de la cotización"></i>
                            </label>
                            <label><a href="{{ url('/') }}{{ $licitacion->url_archivo_cot_evaluacion_economica }}" target="_blank">Ver Adjunto</a></label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <?php
                            if ($licitacion->monto_cotizacion <= $getConfiguraciones->jefeoperacionesmenorque) {
                                $rolaprobacion = 'Jefe de Operaciones';
                            }elseif ($licitacion->monto_cotizacion > $getConfiguraciones->subgerenteoperacionesentre_inicial && $licitacion->monto_cotizacion <= $getConfiguraciones->subgerenteoperacionesentre_final ) {
                                $rolaprobacion = 'Sub-Gerente de Operaciones';
                            }elseif ($licitacion->monto_cotizacion > $getConfiguraciones->subgerentegeneralentre_inicial && $licitacion->monto_cotizacion <= $getConfiguraciones->subgerentegeneralentre_final ) {
                                $rolaprobacion = 'Sub-Gerente General';
                            }else{
                                $rolaprobacion = "Gerente General";
                            }
                        ?>
                        <p><b>Aceptar Revisión Como {{$rolaprobacion}}</b></p>
                    </div>
                    <div class="col-2">
                        <label><input type="radio" id="respuestasolicitud" name="respuestasolicitud" value="1" onclick="respuestacotizacionjefecomercial(1)" checked> Si</label>
                    </div>
                    <div class="col-2">
                        <label><input type="radio" id="respuestasolicitud" name="respuestasolicitud" value="2" onclick="respuestacotizacionjefecomercial(2)"> No</label>
                    </div>
                    <div class="col-12" id="divobservacionesnojefecomercial" style="display: none;">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="observacionesnojefecomercial">
                                <span class="">Observaciones</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Observaciones de la solicitud"></i>
                            </label>
                            <textarea class="form-control form-control-solid" name="observacionesnojefecomercial" id="observacionesnojefecomercial"></textarea>
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
