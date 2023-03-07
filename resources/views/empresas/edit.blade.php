@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Editar Empresa</h1>
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
    <li class="breadcrumb-item text-muted">Editar Empresa</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Editar Empresa</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('editar-empresas'))
                    <form method="POST" action="{{ route('actualizar-empresa') }}" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="idempresa" value="{{ $empresa->id }}">
                        <div class="card-body border-top p-9">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Nombre</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="text" name="nombre" class="form-control form-control-lg form-control-solid" placeholder="Nombre" value="{{ $empresa->nombre }}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>RUT</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="text" name="rut" class="form-control form-control-lg form-control-solid" placeholder="Rut empresa" value="{{ $empresa->rut }}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Giro</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <select name="giro" class="form-control form-control-lg form-control-solid" required>
                                        <option value="">Seleccione...</option>
                                        <?php if($listado_giros){ foreach ($listado_giros as $giro) { ?>
                                        <option value="{{ $giro->id }}" <?php if($empresa->id_giro == $giro->id) echo "selected" ?> >{{ $giro->nombre }}</option>
                                        <?php } } ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Contacto</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="text" name="contacto" class="form-control form-control-lg form-control-solid" placeholder="Contacto" value="{{ $empresa->contacto }}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Teléfono</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="text" name="telefono" class="form-control form-control-lg form-control-solid" placeholder="Teléfono" value="{{ $empresa->telefono }}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ url('/empresas') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Cancelar</button></a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                        <input type="hidden">
                        <div></div>
                    </form>
                @else
                    <?php \Alert::message('Usted no tiene privilegios para editar empresas', 'warning'); ?>
                    {!! Alert::render() !!}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
