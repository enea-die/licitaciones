@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Mi perfil</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Mi perfil</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <a class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{ Auth::user()->name }} {{ Auth::user()->ap_paterno }} {{ Auth::user()->ap_materno }}</a>
                            </div>
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <a class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor"></path>
                                            <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    {{ Auth::user()->email }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Detalle Mi Perfil</h3>
            </div>
        </div>
        <div id="kt_account_settings_profile_details" class="collapse show">
            <form method="POST" action="{{ route('update-datos-perfil') }}" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data">
                @csrf
                <div class="card-body border-top p-9">
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">Avatar</label>
                        <div class="col-lg-8">
                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ url('extras/svg/blank.svg') }}')">
                                <?php
                                    if(Auth::user()->avatar != null){
                                        $ruta_avatar = url('/storage/app/').'/'.Auth::user()->avatar; 
                                    }else{
                                        $ruta_avatar = url('/extras/images/userdefault.png');
                                    }
                                ?>
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $ruta_avatar }})"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="" data-bs-original-title="Cambiar avatar">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                    <input type="hidden" name="avatar_remove">
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="" data-bs-original-title="Cancelar avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="" data-bs-original-title="Remover avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                            <div class="form-text">Tipo de extensiones permitidas: png, jpg, jpeg.</div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">
                            <span>Rut</span>
                        </label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input type="text" name="rut" class="form-control form-control-lg form-control-solid" placeholder="Rut" value="{{ Auth::user()->rut }}">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Nombre Completo</label>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                    <input type="text" name="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Nombre" value="{{ Auth::user()->name }}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                    <input type="text" name="ap_paterno" class="form-control form-control-lg form-control-solid" placeholder="Apellido paterno" value="{{ Auth::user()->ap_paterno }}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                    <input type="text" name="ap_materno" class="form-control form-control-lg form-control-solid" placeholder="Apellido materno" value="{{ Auth::user()->ap_materno }}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>Celular</span>
                        </label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Numero celular" value="{{ Auth::user()->phone }}">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>Cargo</span>
                        </label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input type="text" name="cargo" class="form-control form-control-lg form-control-solid" placeholder="Cargo" value="{{ Auth::user()->cargo }}">
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Guardar Cambios</button>
                </div>
                <input type="hidden">
                <div></div>
            </form>
        </div>
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Contraseña</h3>
            </div>
        </div>
        <div id="kt_account_settings_signin_method" class="collapse show">
            <div class="card-body border-top p-9">
                <div class="d-flex flex-wrap align-items-center mb-10">
                    <div id="kt_signin_password" class="">
                        <div class="fs-6 fw-bolder mb-1">Password</div>
                        <div class="fw-bold text-gray-600">************</div>
                    </div>
                    <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                        <form method="POST" action="{{ route('update-password-perfil') }}" id="kt_signin_change_password" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0 fv-plugins-icon-container">
                                        <label for="newpassword" class="form-label fs-6 fw-bolder mb-3">Nueva Contraseña</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword" id="newpassword">
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0 fv-plugins-icon-container">
                                        <label for="confirmpassword" class="form-label fs-6 fw-bolder mb-3">Confirmar Nueva Contraseña</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword_confirmation" id="newpassword_confirmation">
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-text mb-5">La contraseña debe tener al menos 8 caracteres y contener símbolos</div>
                            <div class="d-flex">
                                <button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6">Actualizar Contraseña</button>
                                <button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancelar</button>
                            </div>
                            <div></div>
                        </form>
                    </div>
                    <div id="kt_signin_password_button" class="ms-auto">
                        <button class="btn btn-light btn-active-light-primary">Resetear Contraseña</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ url('extras/js/signin-methods.js') }}"></script>
@endsection
