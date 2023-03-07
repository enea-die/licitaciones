<div class="modal-header">
    <h5 class="modal-title" id="myModalLabel">Responder Solicitud Dar de Baja Licitación/Cotización N° {{ $licitacion->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
{!! Form::open(['method' => 'POST', 'route' => ['licit-respuesta-solicitud-dar-baja-licitacion'], 'autocomplete' => 'off', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
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
                <hr>
                <div class="row">
                    <div class="col-3">
                        <p>Aceptar Solicitud</p>
                    </div>
                    <div class="col-2">
                        <label><input type="radio" id="respuestasolicitud" name="respuestasolicitud" value="9" checked> Si</label>
                    </div>
                    <div class="col-2">
                        <label><input type="radio" id="respuestasolicitud" name="respuestasolicitud" value="10"> No</label>
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