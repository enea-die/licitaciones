<div class="modal-header">
    <h5 class="modal-title" id="myModalLabel">Asignar Responsable (Administrador de Terreno) Licitación/Cotización N° {{ $licitacion->id }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
{!! Form::open(['method' => 'POST', 'route' => ['licit-asignacion-responsable-etapa-uno'], 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <input type="hidden" id="idlicitacion" name="idlicitacion" value="<?php echo $licitacion->id ?>">
                <div class="row">
                    <div class="col-6">
                        <strong>Titulo: </strong>{{ $licitacion->titulo }}<br>
                        <strong>Tipo: </strong>{{ $licitacion->tipo->nombre }}<br>
                        <strong>Etapa: </strong>{{ $licitacion->etapa->nombre }}<br>
                        <!--<strong>Monto: </strong>${{ number_format($licitacion->monto_cotizacion,0,',','.') }}<br>-->
                    </div>
                    <div class="col-6">
                        <strong>Empresa: </strong>{{ $licitacion->empresa->nombre }}<br>
                        <strong>Fecha Creación: </strong>{{ $licitacion->fecha_creacion }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="responsable">
                                <span class="">Responsable (Administrador de Terreno)</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Responsable (Administrador de Terreno) de la licitación"></i>
                            </label>
                            <select id="responsable" name="responsable" class="form-control form-control-solid" required>
                                <option value="">Seleccione...</option>
                                <?php if($usuarios){ foreach ($usuarios as $user) { if($user->hasRole('Responsable')){ ?>
                                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->ap_paterno }} {{ $user->ap_materno }} ({{ $user->rut }})</option>
                                <?php } } } ?>
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="grupo">
                                <span class="">Grupo Trabajo</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Grupo de trabajo de la licitación"></i>
                            </label>
                            <select id="grupo" name="grupo" class="form-control form-control-solid" required>
                                <option value="">Seleccione...</option>
                                <?php if($grupos){ foreach ($grupos as $user) { ?>
                                    <option value="{{ $user->id }}">{{ $user->nombre_grupo }}</option>
                                <?php } } ?>
                            </select>
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
