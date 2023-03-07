@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Plantas Empresa</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/empresas') }}" class="text-muted text-hover-primary">Listado Empresas</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Plantas Empresa</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Plantas - {{ $empresa->nombre }}</h3>
            </div>
            @if(Auth::user()->can('crear-plantas-empresas'))
                <a href="#" onclick="modalAddPlanta()" class="btn btn-primary align-self-center">Crear Planta</a>
            @endif
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('listar-plantas-empresas'))
                    <div class="table-responsive">
                        <table class="table table-hover table-row-dashed fs-6 gy-5 my-0" id="listado_empresas">
                            <thead>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Areas</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php if($listado_plantas){ foreach ($listado_plantas as $row) { ?>
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nombre }}</td>
                                    <td>
                                        @if(Auth::user()->can('crear-areas-plantas-empresas'))
                                            <a href="#" onclick="modalAddAreaPlanta({{ $row->id }})" class="btn btn-primary btn-sm">Crear Area {{ $row->nombre }}</a>
                                        @endif
                                        @if(Auth::user()->can('listar-areas-plantas-empresas'))
                                            <?php $ia = 0; if($row->areas){ foreach ($row->areas as $area) { $ia++; ?>
                                                <p>
                                                    {{ $ia.'.- '.$area->nombre }} (Contacto: {{ $area->contacto }} - Telefono: {{ $area->telefono }}) 
                                                    @if(Auth::user()->can('editar-areas-plantas-empresas'))
                                                        <a href="#" onclick="modalEditAreaPlanta({{ $row->id }},{{ $area->id }})"><i class="bi bi-pencil-fill fs-7"></i></a> 
                                                    @endif
                                                    @if(Auth::user()->can('eliminar-areas-plantas-empresas'))
                                                        <a href="{{ url('plantaempresaarea/eliminar', $empresa->id) }}/{{ $area->id }}" onclick="return confirm('Esta seguro que desea eliminar esta Area de la Planta?')"><i class="bi bi-x fs-2"></i></a>
                                                    @endif    
                                                </p>
                                            <?php } } ?>
                                        @endif
                                    </td>
                                    <td>
                                        @if(Auth::user()->can('eliminar-plantas-empresas'))
                                            <a href="{{ url('plantaempresa/eliminar', $empresa->id) }}/{{ $row->id }}" onclick="return confirm('Esta seguro que desea eliminar esta Planta de la empresa?')" class="btn btn-danger btn-sm">Eliminar Planta</a>
                                        @endif
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                @else
                    <?php \Alert::message('Usted no tiene privilegios para visualizar las plantas de las empresas', 'warning'); ?>
                    {!! Alert::render() !!}
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddPlanta" tabindex="-1" aria-hidden="true">
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
                <form method="POST" action="{{ route('crear-planta-empresa') }}" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data">
                    @csrf
                    <h3>Crear Nueva Planta</h3>
                    <input type="hidden" name="idempresa" value="{{ $empresa->id }}">
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                <span>Nombre</span>
                            </label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input type="text" name="nombre" class="form-control form-control-lg form-control-solid" placeholder="Nombre" value="">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end px-9">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                    <input type="hidden">
                    <div></div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddArea" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('crear-area-planta') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" id="idempresa" name="idempresa" value="{{ $empresa->id }}">
                    <input type="hidden" id="idplantaAddArea" name="idplanta">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Crear Nueva Area</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="areaplanta">
                            <span class="required">Nombre Area</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Ingrese el nombre del area"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Nombre" name="areaplanta" id="areaplanta" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="areacontacto">
                            <span class="required">Contacto</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Ingrese el contacto del area"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Contacto" name="areacontacto" id="areacontacto" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="areatelefono">
                            <span class="required">Telefono</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Ingrese el telefono del contacto"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Telefono" name="areatelefono" id="areatelefono" required/>
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

<div class="modal fade" id="modalEditArea" tabindex="-1" aria-hidden="true">
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
                <form method="post" action="{{ route('editar-area-planta') }}" class="form" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" id="idempresa" name="idempresa" value="{{ $empresa->id }}">
                    <input type="hidden" id="idplantaEditArea" name="idplanta">
                    <input type="hidden" id="idareaEditArea" name="idarea">
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Editar Area</h1>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="areaplanta">
                            <span class="required">Nombre Area</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Ingrese el nombre del area"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Nombre" name="areaplanta" id="Editareaplanta" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="areacontacto">
                            <span class="required">Contacto</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Ingrese el contacto del area"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Contacto" name="areacontacto" id="Editareacontacto" required/>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2" for="areatelefono">
                            <span class="required">Telefono</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Ingrese el telefono del contacto"></i>
                        </label>
                        <input type="text" class="form-control form-control-solid" placeholder="Telefono" name="areatelefono" id="Editareatelefono" required/>
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
