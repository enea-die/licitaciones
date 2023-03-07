@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Editar Tipo</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/tipolicitaciones') }}" class="text-muted text-hover-primary">Listado Tipo Licitaciones</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Editar Tipo</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Editar Tipo Licitaciones</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <form method="POST" action="{{ route('actualizar-tipo-licitacion') }}" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="idtipo" value="{{ $tipo->id }}">
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                <span>Nombre</span>
                            </label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input type="text" name="nombre" class="form-control form-control-lg form-control-solid" placeholder="Nombre" value="{{ $tipo->nombre }}">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                <span>Estado</span>
                            </label>
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <select name="estado" class="form-control form-control-lg form-control-solid">
                                    <option value="1" <?php if($tipo->estado == 1) echo "selected" ?> >Activo</option>
                                    <option value="0" <?php if($tipo->estado == 0) echo "selected" ?> >Inactivo</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ url('/tipolicitaciones') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Cancelar</button></a>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                    <input type="hidden">
                    <div></div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
