<div class="modal-header">
    <h5 class="modal-title" id="myModalLabel">Solicitud No Participar Licitación/Cotización N° {{ $licitacion->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
{!! Form::open(['method' => 'POST', 'route' => ['licit-solicitud-no-participacion-licitacion-etapa-uno'], 'autocomplete' => 'off', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
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
                        <strong>Etapa: </strong>{{ $licitacion->etapa->nombre }}<br>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntocartaexcusa">
                                <span class="">Adjunto Carta Excusa</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento carta excusa no participación de la licitación"></i>
                            </label>
                            <input type="file" class="form-control form-control-solid" name="adjuntocartaexcusa" id="adjuntocartaexcusa"/>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="motivosnoparticipar">
                                <span class="">Motivos</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Motivos no participar de la licitación"></i>
                            </label>
                            <?php if($motivos_no_participar){ foreach ($motivos_no_participar as $motivo) { ?>
                                <label><input type="checkbox" name="motivosnoparticipar[]" id="motivosnoparticipar" value="{{ $motivo->id }}"> {{ $motivo->nombre }}</label>
                            <?php } } ?>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="observaciones">
                                <span class="">Observaciones</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Observaciones de la solicitud"></i>
                            </label>
                            <textarea class="form-control form-control-solid" name="observaciones" id="observaciones"></textarea>
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