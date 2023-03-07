@extends('layouts.app')

@section('contentHeader')
<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Dashboard</h1>
<span class="h-20px border-gray-300 border-start mx-4"></span>
<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
    <li class="breadcrumb-item text-muted">
        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-300 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">Dashboard</li>
</ul>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">
            @if(Auth::user()->can('visualizar-dashboard'))
                <div class="row mb-7">
                    <h3>Filtro Búsqueda</h3>
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <div class="col-4">
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                    <span>Tipo Informe</span>
                                </label>
                                <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                    <select name="tipoinforme" id="tipoinforme" class="form-control" onchange="tipoinformedashboard()">
                                        <option value="0">Seleccione...</option>
                                        <option value="1">Adjudicaciones Acumuladas Año</option>
                                        <option value="2">Adjudicaciones Mes</option>
                                        <option value="3">Adjudicaciones por Cliente</option>
                                        <option value="4">Adjudicaciones por Planta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div id="divanioinforme" style="display:none">
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                        <span>Año</span>
                                    </label>
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                        <select name="dashb_anio" id="dashb_anio" class="form-control">
                                            <option value="0">Seleccione...</option>
                                            <?php for ($i=date('Y')-5; $i <= date('Y'); $i++) { ?>
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="divmensualinforme" style="display:none">
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                        <span>Mes</span>
                                    </label>
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                        <input type="month" name="dashb_mes" id="dashb_mes" class="form-control">
                                    </div>
                                </div>
                                <div id="divclienteinforme" style="display:none">
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                        <span>Cliente</span>
                                    </label>
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                        <select name="dashb_cliente" id="dashb_cliente" class="form-control">
                                            <option value="0">Seleccione...</option>
                                            <?php if($clientes){ foreach($clientes as $cliente){ ?>
                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="divplantainforme" style="display:none">
                                    <label class="col-lg-4 col-form-label required fw-bold fs-6">
                                        <span>Planta</span>
                                    </label>
                                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                        <select name="dashb_planta" id="dashb_planta" class="form-control">
                                            <option value="0">Seleccione...</option>
                                            <?php if($plantas){ foreach($plantas as $planta){ ?>
                                            <option value="{{ $planta->id }}">{{ $planta->nombre }}</option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <a href="{{ url('dashboard') }}"><button type="button" class="btn btn-light btn-active-light-primary me-2">Limpiar</button></a>
                                <button type="button" class="btn btn-primary" onclick="validarfiltrodashboard()">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-7">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div id="grafico_dashboard_licitaciones_adjudicadas" style="width: 600px;height:400px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div id="grafico_dashboard_licitaciones_ejecutadas" style="width: 600px;height:400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <?php \Alert::message('Usted no tiene privilegios para visualizar el Dashboard', 'warning'); ?>
                {!! Alert::render() !!}
            @endif
        </div>
    </div>
</div>

@endsection

@section('javascript')

@endsection
