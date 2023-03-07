@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Crear Rol</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/roles') }}" class="text-muted text-hover-primary">Listado Roles</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Crear Rol</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Crear Nuevo Rol</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('crear-roles'))
                    <form method="POST" action="{{ route('guardar-nuevo-rol') }}" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                        @csrf
                        <div class="card-body border-top p-9">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Nombre</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <input type="text" name="nombre" class="form-control form-control-lg form-control-solid" placeholder="Nombre Rol" value="">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Permisos</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    {!! Form::select('permission[]', $permissions, old('permission'), ['class' => 'form-control select2 select2-multiple', 'multiple' => 'multiple', 'style' => 'width:100%']) !!}
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ url('/roles') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Cancelar</button></a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                        <input type="hidden">
                        <div></div>
                    </form>
                @else
                    <?php \Alert::message('Usted no tiene privilegios para crear roles', 'warning'); ?>
                    {!! Alert::render() !!}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection