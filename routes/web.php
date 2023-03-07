<?php

use App\Http\Controllers\AreasController;
use App\Http\Controllers\ConfiguracionesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\FamiliasController;
use App\Http\Controllers\GirosController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\LicitacionesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TipoDocumentosController;
use App\Http\Controllers\TipoLicitacionesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('home', [DashboardController::class, 'index'])->name('home');
Route::get('miperfil', [DashboardController::class, 'miperfil'])->name('miperfil');
Route::post('update-datos-perfil', [DashboardController::class, 'updateDatosPerfil'])->name('update-datos-perfil');
Route::post('update-password-perfil', [DashboardController::class, 'updatePasswordPerfil'])->name('update-password-perfil');

//gestion de usuarios
Route::get('users', [UsersController::class, 'index'])->name('users');
Route::get('users/create', [UsersController::class, 'create']);
Route::post('guardar-nuevo-usuario', [UsersController::class, 'store'])->name('guardar-nuevo-usuario');
Route::get('users/editar/{id}', [UsersController::class, 'edit']);
Route::post('actualizar-usuario', [UsersController::class, 'update'])->name('actualizar-usuario');
Route::get('users/eliminar/{id}', [UsersController::class, 'destroy']);

//gestion de roles
Route::get('roles', [RolesController::class, 'index'])->name('roles');
Route::get('roles/create', [RolesController::class, 'create']);
Route::post('guardar-nuevo-rol', [RolesController::class, 'store'])->name('guardar-nuevo-rol');
Route::get('roles/editar/{id}', [RolesController::class, 'edit']);
Route::post('actualizar-rol', [RolesController::class, 'update'])->name('actualizar-rol');
Route::get('roles/eliminar/{id}', [RolesController::class, 'destroy']);

//gestion de tipo de documentos
Route::get('tipodocumentos', [TipoDocumentosController::class, 'index'])->name('tipodocumentos');
Route::get('tipodocumentos/create', [TipoDocumentosController::class, 'create']);
Route::post('guardar-nuevo-tipo-documento', [TipoDocumentosController::class, 'store'])->name('guardar-nuevo-tipo-documento');
Route::get('tipodocumentos/editar/{id}', [TipoDocumentosController::class, 'edit']);
Route::post('actualizar-tipo-documento', [TipoDocumentosController::class, 'update'])->name('actualizar-tipo-documento');
Route::get('tipodocumentos/eliminar/{id}', [TipoDocumentosController::class, 'destroy']);

//gestion de tipo licitaciones
Route::get('tipolicitaciones', [TipoLicitacionesController::class, 'index'])->name('tipolicitaciones');
Route::get('tipolicitaciones/create', [TipoLicitacionesController::class, 'create']);
Route::post('guardar-nuevo-tipo-licitacion', [TipoLicitacionesController::class, 'store'])->name('guardar-nuevo-tipo-licitacion');
Route::get('tipolicitaciones/editar/{id}', [TipoLicitacionesController::class, 'edit']);
Route::post('actualizar-tipo-licitacion', [TipoLicitacionesController::class, 'update'])->name('actualizar-tipo-licitacion');
Route::get('tipolicitaciones/eliminar/{id}', [TipoLicitacionesController::class, 'destroy']);

//gestion de areas
Route::get('areas', [AreasController::class, 'index'])->name('areas');
Route::get('areas/create', [AreasController::class, 'create']);
Route::post('guardar-nueva-area', [AreasController::class, 'store'])->name('guardar-nueva-area');
Route::get('areas/editar/{id}', [AreasController::class, 'edit']);
Route::post('actualizar-area', [AreasController::class, 'update'])->name('actualizar-area');
Route::get('areas/eliminar/{id}', [AreasController::class, 'destroy']);

//gestion de giros
Route::get('giros', [GirosController::class, 'index'])->name('giros');
Route::get('giros/create', [GirosController::class, 'create']);
Route::post('guardar-nuevo-giro', [GirosController::class, 'store'])->name('guardar-nuevo-giro');
Route::get('giros/editar/{id}', [GirosController::class, 'edit']);
Route::post('actualizar-giro', [GirosController::class, 'update'])->name('actualizar-giro');
Route::get('giros/eliminar/{id}', [GirosController::class, 'destroy']);

//gestion de familias
Route::get('familias', [FamiliasController::class, 'index'])->name('familias');
Route::get('familias/create', [FamiliasController::class, 'create']);
Route::post('guardar-nueva-familia', [FamiliasController::class, 'store'])->name('guardar-nueva-familia');
Route::get('familias/editar/{id}', [FamiliasController::class, 'edit']);
Route::post('actualizar-familia', [FamiliasController::class, 'update'])->name('actualizar-familia');
Route::get('familias/eliminar/{id}', [FamiliasController::class, 'destroy']);

//gestion de empresas
Route::get('empresas', [EmpresasController::class, 'index'])->name('empresas');
Route::get('empresas/create', [EmpresasController::class, 'create']);
Route::post('guardar-nueva-empresa', [EmpresasController::class, 'store'])->name('guardar-nueva-empresa');
Route::get('empresas/editar/{id}', [EmpresasController::class, 'edit']);
Route::post('actualizar-empresa', [EmpresasController::class, 'update'])->name('actualizar-empresa');
Route::get('empresas/eliminar/{id}', [EmpresasController::class, 'destroy']);
Route::get('empresas/pgp/{id}', [EmpresasController::class, 'pgp']);
Route::post('crear-pgp-empresa', [EmpresasController::class, 'crearPgpEmpresa'])->name('crear-pgp-empresa');
Route::get('pgpempresa/eliminar/{idempresa}/{idpgp}', [EmpresasController::class, 'eliminarPGPEmpresa']);
Route::get('empresas/plantas/{id}', [EmpresasController::class, 'plantas']);
Route::post('crear-planta-empresa', [EmpresasController::class, 'crearPlantaEmpresa'])->name('crear-planta-empresa');
Route::get('plantaempresa/eliminar/{idempresa}/{idplanta}', [EmpresasController::class, 'eliminarPlantaEmpresa']);
Route::post('crear-area-planta', [EmpresasController::class, 'crearAreaPlanta'])->name('crear-area-planta');
Route::get('plantaempresaarea/eliminar/{idempresa}/{idarea}', [EmpresasController::class, 'eliminarAreaPlantaEmpresa']);
Route::get('get-area/{idarea}', [EmpresasController::class, 'getAreaPlanta']);
Route::post('editar-area-planta', [EmpresasController::class, 'editarAreaPlanta'])->name('editar-area-planta');

//gestion de grupos
Route::get('grupos', [GruposController::class, 'index'])->name('grupos');
Route::get('grupos/create', [GruposController::class, 'create']);
Route::post('guardar-nuevo-grupo', [GruposController::class, 'store'])->name('guardar-nuevo-grupo');
Route::get('grupos/editar/{id}', [GruposController::class, 'edit']);
Route::post('actualizar-grupo', [GruposController::class, 'update'])->name('actualizar-grupo');
Route::get('grupos/eliminar/{id}', [GruposController::class, 'destroy']);

//gestion de configuraciones generales
Route::get('configuraciones', [ConfiguracionesController::class, 'index']);
Route::post('guardar_configuracion', [ConfiguracionesController::class, 'update'])->name('guardar_configuracion');

//gestion de asignaciones
Route::get('asignaciones', [UsersController::class, 'index']);

//gestion de licitaciones
Route::get('licitaciones', [LicitacionesController::class, 'index']);
Route::get('licitaciones/continuar/{id}/{ruta?}', [LicitacionesController::class, 'continuargestionlicitacion']);
Route::get('licitaciones/pendientevisitas', [LicitacionesController::class, 'pendientevisitas']);
Route::get('licitaciones/cotizaciones', [LicitacionesController::class, 'cotizaciones']);
Route::get('licitaciones/autorizacionescotizaciones', [LicitacionesController::class, 'autorizacionescotizaciones']);
Route::get('licitaciones/procesoadjudicacion', [LicitacionesController::class, 'procesoadjudicacion']);
Route::get('licitaciones/procesoejecutados', [LicitacionesController::class, 'procesoejecutados']);
Route::get('licitaciones/procesofinalizados', [LicitacionesController::class, 'procesofinalizados']);
Route::get('licitaciones/proyectoscerrados', [LicitacionesController::class, 'proyectoscerrados']);
Route::get('licitaciones/pendientecierrecc', [LicitacionesController::class, 'pendientecierrecc']);
Route::get('licitaciones/cccerrados', [LicitacionesController::class, 'cccerrados']);

Route::post('guardar-licitacion', [LicitacionesController::class, 'store'])->name('licit-guardar-licitacion');
Route::get('solicitud-participar-licitacion/{idlicitacion}', [LicitacionesController::class, 'solicitarparticipacionlicitacion']);
Route::get('modal-no-participar-etapa-uno/{id}', [LicitacionesController::class, 'modalnoparticiparlicitacionetapauno']);
Route::post('solicitud-no-participacion-licitacion-etapa-uno', [LicitacionesController::class, 'EnviarSolicitudNoParticipacionEtapaUno'])->name('licit-solicitud-no-participacion-licitacion-etapa-uno');
Route::get('modal-responder-solicitud-participar-etapa-uno/{id}', [LicitacionesController::class, 'modalresponderparticipacionlicitacionetapauno']);
Route::post('respuesta-solicitud-participacion-licitacion', [LicitacionesController::class, 'RespuestaSolicitudParticipacion'])->name('licit-respuesta-solicitud-participacion-licitacion');
Route::get('autoasignarse-responsable-licitacion/{id}', [LicitacionesController::class, 'autoasignarseresponsablelicitacion']);
Route::get('solicitar-dar-baja-licitacion/{id}', [LicitacionesController::class, 'solicitardardebajalicitacion']);
Route::get('modal-responder-solicitud-dar-de-baja/{id}', [LicitacionesController::class, 'modalrespondersolicituddardebajalicitacion']);
Route::post('respuesta-solicitud-dar-baja-licitacion', [LicitacionesController::class, 'RespuestaSolicitudDardeBajaLicitacion'])->name('licit-respuesta-solicitud-dar-baja-licitacion');
Route::get('modal-responder-solicitud-revision-cotizacion/{id}', [LicitacionesController::class, 'modalrespondersolicitudrevisioncotizacion']);
Route::get('modal-aprobar-etapa-uno/{id}', [LicitacionesController::class, 'modalaprobaretapauno']);
Route::post('aprobar-etapa-uno', [LicitacionesController::class, 'AprobarRechazarEtapaUno'])->name('licit-aprobar-etapa-uno');
Route::get('modal-asignar-responsable/{id}', [LicitacionesController::class, 'modalasignarresponsable']);
Route::post('asignacion-responsable-etapa-uno', [LicitacionesController::class, 'asignacionresponsableetapauno'])->name('licit-asignacion-responsable-etapa-uno');
Route::get('modal-gestionar-visita/{id}', [LicitacionesController::class, 'modalgestionarvisita']);
Route::post('ingresar-gestion-visita', [LicitacionesController::class, 'ingresarGestionVisita'])->name('licit-ingresar-gestion-visita');
Route::post('ingresar-cotizacion', [LicitacionesController::class, 'ingresarcotizacion'])->name('licit-ingresar-cotizacion');
Route::get('solicitar-revision-cotizacion/{idlicitacion}', [LicitacionesController::class, 'solicitarrevisioncotizacion']);
Route::post('responder-revision-cotizacion', [LicitacionesController::class, 'registrarrespuestarevisioncotizacion'])->name('licit-responder-revision-cotizacion');
Route::get('solicitud-autorizacion-cotizacion/{idlicitacion}', [LicitacionesController::class, 'solicitudautorizarmontocotizacion']);
Route::get('registrar-autorizacion-cotizacion/{idlicitacion}/{status}', [LicitacionesController::class, 'registrarautorizacioncotizacion']);
Route::get('registrar-subida-plataforma-licitacion/{idlicitacion}', [LicitacionesController::class, 'registrarsubidaofertaplataforma']);

Route::post('resultado-adjudicacion', [LicitacionesController::class, 'ingresarResultadoAdjudicacion'])->name('licit-resultado-adjudicacion');
Route::get('registrar-solicitud-centrocosto/{idlicitacion}', [LicitacionesController::class, 'registrarsolicitudcentrocosto']);
Route::post('ingresar-centro-costo', [LicitacionesController::class, 'ingresarCentroCosto'])->name('licit-ingresar-centro-costo');
Route::post('registrar-ejecucion-servicio', [LicitacionesController::class, 'registrarejecucionservicio'])->name('registrar-ejecucion-servicio');
Route::post('registrar-termino-servicio', [LicitacionesController::class, 'registrarterminoservicio'])->name('registrar-termino-servicio');
Route::post('registrar-trabajo-adicional', [LicitacionesController::class, 'registrarTrabajoAdicional'])->name('registrar-trabajo-adicional');
Route::post('registrar-adjunto-informe-tecnico-spom', [LicitacionesController::class, 'registraradjuntoinformetecnicospom'])->name('licit-registrar-adjunto-informe-tecnico-spom');
Route::get('aprobacion-adjunto-informe-tecnico-spom/{idlicitacion}/{idregistroitem}/{istrabajoadicional}/{resultado}', [LicitacionesController::class, 'registraraprobacioninformetecnicospom']);
Route::post('registrar-has-spom', [LicitacionesController::class, 'registrarHasSPOM'])->name('licit-registrar-has-spom');
Route::get('registrar-solicitud-facturar-spom/{idlicitacion}/{idregistroitem}/{istrabajoadicional}', [LicitacionesController::class, 'registrarsolicitudfacturarspom']);
Route::post('registrar-factura-has-spom', [LicitacionesController::class, 'registrarFacturaHasSPOM'])->name('licit-registrar-factura-has-spom');
Route::get('registrar-solicitud-cierre-proyecto/{idlicitacion}', [LicitacionesController::class, 'registrarsolicitudcierreproyecto']);
Route::get('registrar-cierre-proyecto/{idlicitacion}', [LicitacionesController::class, 'registrarcierreproyecto']);
Route::post('registrar-adjunto-informe-kpi-servicio', [LicitacionesController::class, 'registraradjuntoinformekpiservicio'])->name('licit-registrar-adjunto-informe-kpi-servicio');
Route::get('registrar-cierre-centro-costo/{idlicitacion}', [LicitacionesController::class, 'registrarcierrecentrocosto']);

Route::get('licitaciones/eliminar/{id}', [LicitacionesController::class, 'destroy']);

Route::get('get-pgp-empresa/{idempresa}',[LicitacionesController::class, 'getPGPEmpresa']);
Route::get('get-plantas-empresa/{idempresa}',[LicitacionesController::class, 'getPlantasEmpresa']);
Route::get('get-areas-planta/{idplanta}',[LicitacionesController::class, 'getAreasPlanta']);

//PGP
Route::get('aprobar-cotizacion-pgp/{idlicitacion}/{idcotizacion}', [LicitacionesController::class, 'aprobarcotizacionPGP']);
Route::get('rechazar-cotizacion-pgp/{idlicitacion}/{idcotizacion}', [LicitacionesController::class, 'rechazarcotizacionPGP']);
Route::get('eliminar-cotizacion-pgp/{idlicitacion}/{idcotizacion}', [LicitacionesController::class, 'eliminarcotizacionPGP']);
Route::post('volver-a-enviar-cotizacion-pgp', [LicitacionesController::class, 'volveraenviarcotizacion']);
Route::get('aprobacionCotizPGPsubgerenteoperaciones/{idlicitacion}', [LicitacionesController::class, 'aprobacionCotizPGPsubgerenteoperaciones']);
Route::get('aprobacionCotizPGPsubgerentegeneral/{idlicitacion}', [LicitacionesController::class, 'aprobacionCotizPGPsubgerentegeneral']);
Route::get('aprobacionCotizPGPgerentegeneral/{idlicitacion}', [LicitacionesController::class, 'aprobacionCotizPGPgerentegeneral']);
Route::post('registrar-adjunto-informe-tecnico-spom-PGP', [LicitacionesController::class, 'registraradjuntoinformetecnicospomPGP'])->name('licit-registrar-adjunto-informe-tecnico-spom-PGP');
Route::get('aprobacion-adjunto-informe-tecnico-spom-PGP/{idlicitacion}/{idregistroitem}/{resultado}', [LicitacionesController::class, 'registraraprobacioninformetecnicospomPGP']);
Route::post('registrar-has-spom-PGP', [LicitacionesController::class, 'registrarHasSPOMPGP'])->name('licit-registrar-has-spom-PGP');
Route::get('registrar-solicitud-facturar-spom-PGP/{idlicitacion}/{idregistroitem}', [LicitacionesController::class, 'registrarsolicitudfacturarspomPGP']);
Route::post('registrar-factura-has-spom-PGP', [LicitacionesController::class, 'registrarFacturaHasSPOMPGP'])->name('licit-registrar-factura-has-spom-PGP');


Route::get('informes/estadolicitaciones', [LicitacionesController::class, 'informe_estado_licitaciones']);
Route::post('informes/estadolicitaciones', [LicitacionesController::class, 'postInforme_estado_licitaciones'])->name('postfiltroinformeestadolicitaciones');

Route::get('dashboard', [DashboardController::class, 'informesdashboard']);
Route::get('dashboard_datos_anio/{year}', [DashboardController::class, 'dashboardDatosAnio']);
Route::get('dashboard_datos_mes/{mes}', [DashboardController::class, 'dashboardDatosMes']);
Route::get('dashboard_datos_cliente/{cliente}', [DashboardController::class, 'dashboardDatosCliente']);
Route::get('dashboard_datos_planta/{planta}', [DashboardController::class, 'dashboardDatosPlanta']);

require __DIR__.'/auth.php';
