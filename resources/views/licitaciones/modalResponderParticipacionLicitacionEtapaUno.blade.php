<div class="modal-header">
    <h5 class="modal-title" id="myModalLabel">Responder Solicitud Participación Licitación/Cotización N° {{ $licitacion->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
{!! Form::open(['method' => 'POST', 'route' => ['licit-respuesta-solicitud-participacion-licitacion'], 'autocomplete' => 'off', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
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
                        <?php if($licitacion->id_etapa == 2){ ?>
                        <strong>Etapa: </strong><font color="green"><b>{{ $licitacion->etapa->nombre }}</b></font><br>
                        <?php }else{ ?>
                        <strong>Etapa: </strong><font color="red"><b>{{ $licitacion->etapa->nombre }}</b></font><br>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <?php if($licitacion->id_etapa == 2){ ?>
                <div class="row">
                    <div class="col-3">
                        <p>Aceptar Participar</p>
                    </div>
                    <div class="col-2">
                        <label><input type="radio" id="respuestaparticipacion" name="respuestaparticipacion" value="4" checked> Si</label>
                    </div>
                    <div class="col-2">
                        <label><input type="radio" id="respuestaparticipacion" name="respuestaparticipacion" value="5"> No</label>
                    </div>
                </div>
                <?php } ?>
                <?php if($licitacion->id_etapa == 3){ ?>
                <?php if(count($list_motivos) > 0){ echo "<h3>Motivos</h3>"; } ?>
                <?php if($list_motivos){ foreach ($list_motivos as $mot) { ?>
                    <p>{{ $mot->motivo->nombre }}</p>
                <?php } } ?>
                <hr>
                <h3>Observaciones</h3>
                <p>{{ $licitacion->observaciones_no_participar }}</p>
                <hr>
                <div class="row">
                    <div class="col-3">
                        <p>Aceptar No Participar</p>
                    </div>
                    <div class="col-2">
                        <label><input type="radio" id="respuestaparticipacion" name="respuestaparticipacion" value="5" checked> Si</label>
                    </div>
                    <div class="col-4">
                        <label><input type="radio" id="respuestaparticipacion" name="respuestaparticipacion" value="4"> No, participar de todas maneras</label>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary waves-effect">Guardar</button>
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
    </div>
{!! Form::close() !!}