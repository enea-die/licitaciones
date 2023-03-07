@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Configuraciones</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Configuraciones</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Configuraciones</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                @if(Auth::user()->can('gestionar-configuracion-general'))
                    <form method="POST" action="{{ route('guardar_configuracion') }}" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype="multipart/form-data">
                        @csrf
                        <strong>Valores Aprobaciones SPOT</strong>
                        <div class="card-body border-top p-9">
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6" for="jefeoperacionesmenorque">
                                    <span>Jefe de Operaciones (<) $</span>
                                </label>
                                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                    <input type="text" name="jefeoperacionesmenorque" id="jefeoperacionesmenorque" class="form-control form-control-lg form-control-solid" placeholder="Jefe de operaciones menor que" min="0" value="{{ $config->jefeoperacionesmenorque }}" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(jefeoperacionesmenorque.value, 'jefeoperacionesmenorque');" onfocus="limpiaPuntoGuion('jefeoperacionesmenorque')" required>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Subgerente Operaciones (entre) $</span>
                                </label>
                                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                    <input type="tet" name="subgerenteoperacionesentre_inicial" id="subgerenteoperacionesentre_inicial" class="form-control form-control-lg form-control-solid" placeholder="Subgerente operaciones entre inicial" min="0" value="{{ $config->subgerenteoperacionesentre_inicial }}" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(subgerenteoperacionesentre_inicial.value, 'subgerenteoperacionesentre_inicial');" onfocus="limpiaPuntoGuion('subgerenteoperacionesentre_inicial')" required>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                    <input type="text" name="subgerenteoperacionesentre_final" id="subgerenteoperacionesentre_final" class="form-control form-control-lg form-control-solid" placeholder="Subgerente operaciones entre final" min="0" value="{{ $config->subgerenteoperacionesentre_final }}" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(subgerenteoperacionesentre_final.value, 'subgerenteoperacionesentre_final');" onfocus="limpiaPuntoGuion('subgerenteoperacionesentre_final')" required>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Subgerente General (entre) $</span>
                                </label>
                                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                    <input type="tet" name="subgerentegeneralentre_inicial" id="subgerentegeneralentre_inicial" class="form-control form-control-lg form-control-solid" placeholder="Subgerente general entre inicial" min="0" value="{{ $config->subgerentegeneralentre_inicial }}" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(subgerentegeneralentre_inicial.value, 'subgerentegeneralentre_inicial');" onfocus="limpiaPuntoGuion('subgerentegeneralentre_inicial')" required>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                    <input type="text" name="subgerentegeneralentre_final" id="subgerentegeneralentre_final" class="form-control form-control-lg form-control-solid" placeholder="Subgerente general entre final" min="0" value="{{ $config->subgerentegeneralentre_final }}" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(subgerentegeneralentre_final.value, 'subgerentegeneralentre_final');" onfocus="limpiaPuntoGuion('subgerentegeneralentre_final')" required>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6" for="gerentegeneralmayorque">
                                    <span>Gerente General (>) $</span>
                                </label>
                                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                                    <input type="text" name="gerentegeneralmayorque" id="gerentegeneralmayorque" class="form-control form-control-lg form-control-solid" placeholder="Gerente general mayor que" min="0" value="{{ $config->gerentegeneralmayorque }}" onkeypress="return solo_numeros(event)" onblur="checkValorNumerico(gerentegeneralmayorque.value, 'gerentegeneralmayorque');" onfocus="limpiaPuntoGuion('gerentegeneralmayorque')" required>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ url('/configuraciones') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Cancelar</button></a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                        <input type="hidden">
                        <div></div>
                    </form>
                @else
                    <?php \Alert::message('Usted no tiene privilegios para gestionar las configuraciones', 'warning'); ?>
                    {!! Alert::render() !!}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ url('extras/js/general.js') }}"></script>
<script>
    numericosAlCargarConfiguracion();
</script>

@endsection
