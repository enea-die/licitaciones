<div class="modal-header">
    <h5 class="modal-title" id="myModalLabel">Aprobar Licitación/Cotización N° {{ $licitacion->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
{!! Form::open(['method' => 'POST', 'route' => ['licit-aprobar-etapa-uno'], 'autocomplete' => 'off', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <input type="hidden" id="idlicitacion" name="idlicitacion" value="<?php echo $licitacion->id ?>">
                <div class="row">
                    <div class="col-6">
                        <strong>Titulo: </strong>{{ $licitacion->titulo }}<br>
                        <strong>Tipo: </strong>{{ $licitacion->tipo->nombre }}<br>
                        <!--<b><strong style="color:red">Monto: </strong>${{ number_format($licitacion->monto_cotizacion,0,',','.') }}</b><br>-->
                    </div>
                    <div class="col-6">
                        <strong>Empresa: </strong>{{ $licitacion->empresa->nombre }}<br>
                        <strong>Etapa: </strong>{{ $licitacion->etapa->nombre }}<br>
                        <strong>Fecha Creación: </strong>{{ $licitacion->fecha_creacion }}
                    </div>
                </div>
                <hr>
                <!--
                    <h1><strong style="color:red">Monto: </strong>${{ number_format($licitacion->monto,0,',','.') }}</b><h1>
                    <hr>
                -->
                <div class="row">
                    <div class="col-4">
                        <label><input type="radio" id="statusaprobacion" name="statusaprobacion" value="1" onclick="statusAprobacionEtapa1(1)" checked> Aprobar</label>
                    </div>
                    <div class="col-4">
                        <label><input type="radio" id="statusaprobacion" name="statusaprobacion" value="2" onclick="statusAprobacionEtapa1(2)"> Rechazar</label>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div id="divobservacionesrechazo" style="display: none;">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntocarta">
                                    <span class="">Adjunto Carta</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento carta de la licitación"></i>
                                </label>
                                <input type="file" class="form-control form-control-solid" name="adjuntocarta" id="adjuntocarta"/>
                            </div>
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="observaciones">
                                    <span class="">Observaciones rechazo</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Observaciones del rechazo de la licitación"></i>
                                </label>
                                <textarea id="observaciones" name="observaciones" class="form-control form-control-solid" placeholder="Ingrese las observaciones del rechazo"></textarea>
                            </div>
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