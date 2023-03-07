@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Crear Grupo</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/grupos') }}" class="text-muted text-hover-primary">Listado Grupos</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Crear Grupo</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Crear Nuevo Grupo</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('crear-grupos'))
                    <form method="POST" action="{{ route('guardar-nuevo-grupo') }}" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data">
                        @csrf
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
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Jefe Operaciones</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <select name="id_jefe_operaciones" class="form-control form-control-lg form-control-solid" required>
                                        <option value="">Seleccione...</option>
                                        <?php if($list_usuarios){ foreach ($list_usuarios as $user1) { if($user1->hasRole('Jefe de Operaciones')){ ?>
                                        <option value="{{ $user1->id }}">{{ $user1->name.' '.$user1->ap_paterno.' '.$user1->ap_materno }}</option>
                                        <?php } } } ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Responsable (Administrador de Terreno)</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <select name="id_responsable" class="form-control form-control-lg form-control-solid" required>
                                        <option value="">Seleccione...</option>
                                        <?php if($list_usuarios){ foreach ($list_usuarios as $user3) { if($user3->hasRole('Responsable')){ ?>
                                        <option value="{{ $user3->id }}">{{ $user3->name.' '.$user3->ap_paterno.' '.$user3->ap_materno }}</option>
                                        <?php } } } ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Planificación</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <select name="id_planificacion" class="form-control form-control-lg form-control-solid" required>
                                        <option value="">Seleccione...</option>
                                        <?php if($list_usuarios){ foreach ($list_usuarios as $user5) { if($user5->hasRole('Planificación')){ ?>
                                        <option value="{{ $user5->id }}">{{ $user5->name.' '.$user5->ap_paterno.' '.$user5->ap_materno }}</option>
                                        <?php } } } ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Contabilidad</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <select name="id_contabilidad" class="form-control form-control-lg form-control-solid" required>
                                        <option value="">Seleccione...</option>
                                        <?php if($list_usuarios){ foreach ($list_usuarios as $user6) { if($user6->hasRole('Contabilidad')){ ?>
                                        <option value="{{ $user6->id }}">{{ $user6->name.' '.$user6->ap_paterno.' '.$user6->ap_materno }}</option>
                                        <?php } } } ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ url('/grupos') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Cancelar</button></a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                        <input type="hidden">
                        <div></div>
                    </form>
                @else
                    <?php \Alert::message('Usted no tiene privilegios para crear grupos', 'warning'); ?>
                    {!! Alert::render() !!}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection