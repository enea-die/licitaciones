<div class="modal-header">
    <h5 class="modal-title" id="myModalLabel">Gestionar Visita Licitación/Cotización N° {{ $licitacion->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
{!! Form::open(['method' => 'POST', 'route' => ['licit-ingresar-gestion-visita'], 'autocomplete' => 'off', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <input type="hidden" id="idlicitacion" name="idlicitacion" value="<?php echo $licitacion->id ?>">
                <div class="row">
                    <div class="col-6">
                        <strong>Titulo: </strong>{{ $licitacion->titulo }}<br>
                        <strong>Tipo: </strong>{{ $licitacion->tipo->nombre }}<br>
                        <strong>Etapa: </strong>{{ $licitacion->etapa->nombre }}<br>
                    </div>
                    <div class="col-6">
                        <strong>Empresa: </strong>{{ $licitacion->empresa->nombre }}<br>
                        <strong>Fecha Creación: </strong>{{ $licitacion->fecha_creacion }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3">
                        <p>Con visita</p>
                    </div>
                    <div class="col-2">
                        <label><input type="radio" id="statusvisita" name="statusvisita" value="1" onclick="statusVisita(1)" checked> Si</label>
                    </div>
                    <div class="col-2">
                        <label><input type="radio" id="statusvisita" name="statusvisita" value="2" onclick="statusVisita(2)"> No</label>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="observaciones">
                                <span>Observaciones</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Observaciones de la visita de la licitación"></i>
                            </label>
                            <textarea id="observaciones" name="observaciones" class="form-control form-control-solid" placeholder="Ingrese las observaciones de la visita"></textarea>
                        </div>
                        <div id="divconvisita" style="display: block;">
                            <div class="d-flex flex-column mb-8 fv-row">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="adjuntovisita">
                                    <span class="">Adjunto visita</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Adjuntar documento visita de la licitación"></i>
                                </label>
                                <input type="file" class="form-control form-control-solid" name="adjuntovisita" id="adjuntovisita"/>
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