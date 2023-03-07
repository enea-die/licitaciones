@inject('request', 'Illuminate\Http\Request')

<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
    <div data-kt-menu-trigger="click" class="menu-item {{ ($request->segment(1) == '')?'here':'' }} menu-accordion">
        <span class="menu-link" onclick="returnHome()">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                    </svg>
                </span>
            </span>
            <span class="menu-title">Home</span>
        </span>
    </div>
    <div class="menu-item">
        <div class="menu-content pt-8 pb-2">
            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Menú Principal</span>
        </div>
    </div>
    @if(Auth::user()->can('listar-usuarios') || Auth::user()->can('crear-usuarios') || Auth::user()->can('listar-roles') || Auth::user()->can('crear-roles'))
    <div data-kt-menu-trigger="click" class="menu-item {{ ($request->segment(1) == 'users' || $request->segment(1) == 'roles')?'here show':'' }} menu-accordion">
        <span class="menu-link">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"></path>
                        <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"></rect>
                    </svg>
                </span>
            </span>
            <span class="menu-title">Gestión Usuarios</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            @if(Auth::user()->can('listar-usuarios') || Auth::user()->can('crear-usuarios'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'users')?'active':'' }}" href="{{ url('/users') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Usuarios</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('listar-roles') || Auth::user()->can('crear-roles'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'roles')?'active':'' }}" href="{{ url('/roles') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Roles</span>
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif
    @if(Auth::user()->can('listar-empresas') || Auth::user()->can('crear-empresas') || Auth::user()->can('listar-grupos') || Auth::user()->can('crear-grupos') || Auth::user()->can('listar-giros') || Auth::user()->can('crear-giros') || Auth::user()->can('listar-familias') || Auth::user()->can('crear-familias'))
    <div data-kt-menu-trigger="click" class="menu-item {{ ($request->segment(1) == 'tipolicitaciones' || $request->segment(1) == 'empresas' || $request->segment(1) == 'grupos' || $request->segment(1) == 'asignaciones' || $request->segment(1) == 'areas' || $request->segment(1) == 'giros' || $request->segment(1) == 'familias')?'here show':'' }} menu-accordion">
        <span class="menu-link">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M18 21.6C16.6 20.4 9.1 20.3 6.3 21.2C5.7 21.4 5.1 21.2 4.7 20.8L2 18C4.2 15.8 10.8 15.1 15.8 15.8C16.2 18.3 17 20.5 18 21.6ZM18.8 2.8C18.4 2.4 17.8 2.20001 17.2 2.40001C14.4 3.30001 6.9 3.2 5.5 2C6.8 3.3 7.4 5.5 7.7 7.7C9 7.9 10.3 8 11.7 8C15.8 8 19.8 7.2 21.5 5.5L18.8 2.8Z" fill="currentColor" />
                        <path opacity="0.3" d="M21.2 17.3C21.4 17.9 21.2 18.5 20.8 18.9L18 21.6C15.8 19.4 15.1 12.8 15.8 7.8C18.3 7.4 20.4 6.70001 21.5 5.60001C20.4 7.00001 20.2 14.5 21.2 17.3ZM8 11.7C8 9 7.7 4.2 5.5 2L2.8 4.8C2.4 5.2 2.2 5.80001 2.4 6.40001C2.7 7.40001 3.00001 9.2 3.10001 11.7C3.10001 15.5 2.40001 17.6 2.10001 18C3.20001 16.9 5.3 16.2 7.8 15.8C8 14.2 8 12.7 8 11.7Z" fill="currentColor" />
                    </svg>
                </span>
            </span>
            <span class="menu-title">Mantenedores</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            @if(Auth::user()->can('listar-empresas') || Auth::user()->can('crear-empresas'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'empresas')?'active':'' }}" href="{{ url('/empresas') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Empresas</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('listar-grupos') || Auth::user()->can('crear-grupos'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'grupos')?'active':'' }}" href="{{ url('/grupos') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Grupos</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('listar-giros') || Auth::user()->can('crear-giros'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'giros')?'active':'' }}" href="{{ url('/giros') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Giros</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('listar-familias') || Auth::user()->can('crear-familias'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'familias')?'active':'' }}" href="{{ url('/familias') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Familias</span>
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif
    <div data-kt-menu-trigger="click" class="menu-item {{ ($request->segment(1) == 'licitaciones' &&  $request->segment(4) != 'informes')?'here show':'' }} menu-accordion">
        <span class="menu-link">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z" fill="currentColor" />
                        <path d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z" fill="currentColor" />
                        <path opacity="0.3" d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z" fill="currentColor" />
                        <path opacity="0.3" d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z" fill="currentColor" />
                    </svg>
                </span>
            </span>
            <span class="menu-title">Licitaciones/Cotizaciones</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            @if(Auth::user()->can('listar-licitaciones') || Auth::user()->can('crear-licitaciones'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'licitaciones' && $request->segment(2) == '')?'active':'' }}" href="{{ url('/licitaciones') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Crear/Aprob./Rech.</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('gestionar-visita-licitacion'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'licitaciones' && $request->segment(2) == 'pendientevisitas')?'active':'' }}" href="{{ url('/licitaciones/pendientevisitas') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Pendiente Visitas</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('solicitar-darse-de-baja-licitacion') || Auth::user()->can('responder-solicitud-darse-de-baja') || Auth::user()->can('generar-cotizaciones') || Auth::user()->can('solicitar-revision-cotizaciones') || Auth::user()->can('responder-revision-cotizaciones'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'licitaciones' && $request->segment(2) == 'cotizaciones' || $request->segment(1) == 'licitaciones' && $request->segment(4) == 'cotizaciones')?'active':'' }}" href="{{ url('/licitaciones/cotizaciones') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Cotización</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('ingresar-resultado-adjudicacion') || Auth::user()->can('solicitar-centro-costo') || Auth::user()->can('ingresar-centro-costo') || Auth::user()->can('informar-inicio-servicio'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'licitaciones' && $request->segment(2) == 'procesoadjudicacion' || $request->segment(1) == 'licitaciones' && $request->segment(4) == 'procesoadjudicacion')?'active':'' }}" href="{{ url('/licitaciones/procesoadjudicacion') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Proceso Adjud. /Centro Costo</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('ingresar-trabajos-adicionales') || Auth::user()->can('informar-termino-servicio'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'licitaciones' && $request->segment(2) == 'procesoejecutados' || $request->segment(1) == 'licitaciones' && $request->segment(4) == 'procesoejecutados')?'active':'' }}" href="{{ url('/licitaciones/procesoejecutados') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">En ejecución</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('adjuntar-informe-tecnico') || Auth::user()->can('aprobar-rechazar-informe-tecnico') || Auth::user()->can('ingresar-has') || Auth::user()->can('solicitar-facturar-has') || Auth::user()->can('ingresar-factura-has') || Auth::user()->can('cerrar-proyecto'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'licitaciones' && $request->segment(2) == 'procesofinalizados' || $request->segment(1) == 'licitaciones' && $request->segment(4) == 'procesofinalizados')?'active':'' }}" href="{{ url('/licitaciones/procesofinalizados') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Servicios Finalizados</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('ingresar-informe-kpi-servicio'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'licitaciones' && $request->segment(2) == 'proyectoscerrados' || $request->segment(1) == 'licitaciones' && $request->segment(4) == 'proyectoscerrados')?'active':'' }}" href="{{ url('/licitaciones/proyectoscerrados') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Proyectos Cerrados</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('cerrar-centro-costo'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'licitaciones' && $request->segment(2) == 'pendientecierrecc' || $request->segment(1) == 'licitaciones' && $request->segment(4) == 'pendientecierrecc')?'active':'' }}" href="{{ url('/licitaciones/pendientecierrecc') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Pendiente Cierre CC</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('listar-licitaciones'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'licitaciones' && $request->segment(2) == 'cccerrados' || $request->segment(1) == 'licitaciones' && $request->segment(4) == 'cccerrados')?'active':'' }}" href="{{ url('/licitaciones/cccerrados') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Centro Costo Cerrado</span>
                </a>
            </div>
            @endif
        </div>
    </div>
    @if(Auth::user()->can('visualizar-dashboard') || Auth::user()->can('visualizar-informes'))
    <div data-kt-menu-trigger="click" class="menu-item {{ ($request->segment(1) == 'informes' || $request->segment(4) == 'informes' || $request->segment(1) == 'dashboard')?'here show':'' }} menu-accordion">
        <span class="menu-link">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.0021 10.9128V3.01281C13.0021 2.41281 13.5021 1.91281 14.1021 2.01281C16.1021 2.21281 17.9021 3.11284 19.3021 4.61284C20.7021 6.01284 21.6021 7.91285 21.9021 9.81285C22.0021 10.4129 21.5021 10.9128 20.9021 10.9128H13.0021Z" fill="currentColor" />
                        <path opacity="0.3" d="M11.0021 13.7128V4.91283C11.0021 4.31283 10.5021 3.81283 9.90208 3.91283C5.40208 4.51283 1.90209 8.41284 2.00209 13.1128C2.10209 18.0128 6.40208 22.0128 11.3021 21.9128C13.1021 21.8128 14.7021 21.3128 16.0021 20.4128C16.5021 20.1128 16.6021 19.3128 16.1021 18.9128L11.0021 13.7128Z" fill="currentColor" />
                        <path opacity="0.3" d="M21.9021 14.0128C21.7021 15.6128 21.1021 17.1128 20.1021 18.4128C19.7021 18.9128 19.0021 18.9128 18.6021 18.5128L13.0021 12.9128H20.9021C21.5021 12.9128 22.0021 13.4128 21.9021 14.0128Z" fill="currentColor" />
                    </svg>
                </span>
            </span>
            <span class="menu-title">Informes</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            @if(Auth::user()->can('visualizar-dashboard'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'dashboard')?'active':'' }}" href="{{ url('dashboard') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>
            @endif
            @if(Auth::user()->can('visualizar-informes'))
            <div class="menu-item">
                <a class="menu-link {{ ($request->segment(1) == 'informes' && $request->segment(2) == 'estadolicitaciones' || $request->segment(4) == 'informes')?'active':'' }}" href="{{ url('/informes/estadolicitaciones') }}">
                    <span class="menu-bullet">
                        <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">Estado Licitaciones</span>
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif
    @if(Auth::user()->can('gestionar-configuracion-general'))
        <div class="menu-item">
            <div class="menu-content pt-8 pb-2">
                <span class="menu-section text-muted text-uppercase fs-8 ls-1">Configuración General</span>
            </div>
        </div>
        <div data-kt-menu-trigger="click" class="menu-item {{ ($request->segment(1) == 'configuraciones')?'here':'' }} menu-accordion">
            <span class="menu-link" onclick="viewConfiguracionGeneral()">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                            <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor"></rect>
                            <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                            <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor"></rect>
                        </svg>
                    </span>
                </span>
                <span class="menu-title">Configuración General</span>
            </span>
        </div>
    @endif
</div>