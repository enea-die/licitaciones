<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\AvisoFechasLicitacion;
use App\Mail\AvisoNoParticipar;
use App\Mail\CotizacionCompletaAprobada;
use App\Mail\SolicitudCentroCosto;
use App\Models\User;
use App\Models\Grupos;
use App\Models\Empresas;
use App\Models\Licitaciones;
use App\Models\RegistroEtapas;
use App\Models\Configuraciones;
use App\Models\TipoLicitaciones;
use App\Models\DocumentosAdicionales;
use App\Models\EmpresasPGP;
use App\Models\EmpresasPlantas;
use App\Models\EmpresasPlantasAreas;
use App\Models\Etapas;
use App\Models\ItemsLicitaciones;
use App\Models\ItemsLicitacionesHistorial;
use App\Models\LicitacionesCotizacionesPGP;
use App\Models\LicitacionesItemSPOM;
use App\Models\LicitacionesItemSPOMTrabajosAdicionales;
use App\Models\LicitacionesMotivosNoParticipar;
use App\Models\LicitacionesTrabajosAdicionales;
use App\Models\MFamilias;
use App\Models\MMotivosNoParticipar;
use App\Models\MTipoCentroCosto;
use App\Models\OrdenCliente;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Auth;
use Spatie\Permission\Models\Role;

class LicitacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->hasRole('Responsable')){
            $licitaciones = Licitaciones::where('id_creador',Auth::user()->id)->where('id_etapa','<=',5)->get();
        }else{
            $licitaciones = Licitaciones::where('id_etapa','<=',5)->get();
        }
        $tipolicitaciones = TipoLicitaciones::all();
        $listado_empresas = Empresas::all();
        $listado_tipocentrocosto = MTipoCentroCosto::all();
        $listado_familias = MFamilias::all();

        return view('licitaciones.index',compact('licitaciones','tipolicitaciones','listado_empresas','listado_tipocentrocosto','listado_familias'));
    }

    public function continuargestionlicitacion($id, $ruta = false)
    {
        if($ruta == 'informes'){
            $urlbase = 'informes/estadolicitaciones';
        }else{
            $urlbase = 'licitaciones/'.$ruta;
        }

        $licitacion = Licitaciones::where('id',$id)->first();
        $licitacion_documentos = DocumentosAdicionales::where('id_licitacion',$id)->first();
        $itempersonas = ItemsLicitaciones::where('id_licitacion',$id)->where('id_item',1)->first();
        $itemmateriales = ItemsLicitaciones::where('id_licitacion',$id)->where('id_item',2)->first();
        $itemservicio = ItemsLicitaciones::where('id_licitacion',$id)->where('id_item',3)->first();
        $itemmargen = ItemsLicitaciones::where('id_licitacion',$id)->where('id_item',4)->first();
        $itemhistorial = ItemsLicitacionesHistorial::with('usuario')->where('id_licitacion',$id)->orderBy('id','desc')->get();
        $ordencliente = OrdenCliente::where('id_licitacion',$id)->first();
        $listadoItemSPOM = LicitacionesItemSPOM::with('licitacion')->where('id_licitacion',$id)->get();
        $listadoItemSPOMAdicionales = LicitacionesItemSPOMTrabajosAdicionales::where('id_licitacion',$id)->get();
        $listadotrabajosadicionales = LicitacionesTrabajosAdicionales::with('itemsspom')->where('id_licitacion',$id)->get();
        $listadocotizacionesPGP = LicitacionesCotizacionesPGP::where('id_licitacion',$id)->get();
        $listadocotizacionesPGPAprobadas = LicitacionesCotizacionesPGP::where('id_licitacion',$id)->where('estado_aprobacion',1)->get();
        $getConfiguraciones = Configuraciones::first();

        return view('licitaciones.continuargestionlicitacion',compact('urlbase','licitacion','licitacion_documentos','itempersonas','itemmateriales','itemservicio','itemmargen','itemhistorial','ordencliente','listadoItemSPOM','listadoItemSPOMAdicionales','listadotrabajosadicionales','getConfiguraciones','listadocotizacionesPGP','listadocotizacionesPGPAprobadas'));
    }

    public function store(Request $request)
    {
        if($request->get('tipolicitacion') == 4){
            //Si es PGP
            $lictetapa = 4;
        }else{
            $lictetapa = 1;
        }

        $licitacion = new Licitaciones();
        $licitacion->id_creador = Auth::user()->id;
        $licitacion->titulo = $request->get('titulolicitacion');
        $licitacion->fecha_creacion = date('Y-m-d');
        $licitacion->anio_creacion = date('Y');
        $licitacion->id_tipo_licitacion = $request->get('tipolicitacion');
        $licitacion->id_empresa = $request->get('empresalicitacion');
        $licitacion->id_planta = $request->get('plantalicitacion',null);
        $licitacion->id_area = $request->get('arealicitacion',null);
        $licitacion->id_pgp = $request->get('pgplicitacion',null);
        $licitacion->id_etapa = $lictetapa;
        $licitacion->id_familia = $request->get('familia');
        $licitacion->aprobacion_inicial_automatica = 0;
        $licitacion->fechavisita = $request->get('fechavisita');
        $licitacion->fechapreguntayrespuestas = $request->get('fechapreguntayrespuestas');
        $licitacion->fechaenviopropuesta = $request->get('fechaenviopropuesta');

        //Adjunto Invitacion Licitacion
        if($request->hasFile('adjuntoinvitacionlicitacion')){
            $file = $request->file('adjuntoinvitacionlicitacion');
            $extension = $file->getClientOriginalExtension();
            $filename = $request->get('empresalicitacion').'_'.$request->get('tipolicitacion').'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

            Storage::disk('adjuntoinvitaciones')->put($filename, \File::get($file));

            $licitacion->nombre_archivo_invitacion = $filename;
            $licitacion->url_archivo_invitacion = '/extras/documentacion/adjuntoinvitaciones/'.$filename;
        }

        //adjunto base tecnicas
        if($request->hasFile('adjuntobasestecnicas')){
            $file = $request->file('adjuntobasestecnicas');
            $extension = $file->getClientOriginalExtension();
            $filename = 'LICBASESTEC_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

            Storage::disk('adjuntobasestecnicas')->put($filename, \File::get($file));

            $licitacion->nombre_archivo_bases_tecnicas = $filename;
            $licitacion->url_bases = '/extras/documentacion/adjuntobasestecnicas/'.$filename;
        }

        if($licitacion->save()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $licitacion->id;
            $etapa->id_etapa = 1;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            if($request->get('tipolicitacion') == 4){
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $licitacion->id;
                $etapa->id_etapa = 4;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();
            }

            return redirect('licitaciones')->with('msj','Licitación creada exitosamente');
        }else{
            return redirect('licitaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function solicitarparticipacionlicitacion($idlicitacion){
        $existsLicitacion = Licitaciones::where('id', $idlicitacion)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 2;

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 2;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();

                return redirect('licitaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        } else {
            return redirect('licitaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function modalnoparticiparlicitacionetapauno($id){
        $existsLicitacion = Licitaciones::where('id', $id)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::where('id', $id)->first();
            $motivos_no_participar = MMotivosNoParticipar::all();

            return view('licitaciones.modalNoParticiparLicitacionEtapaUno', compact('licitacion','motivos_no_participar'));
        } else {
            return "<hr><h2 style='text-align:center'>No se encontro la licitación ingresada, favor verificar</h2><hr>";
        }
    }

    public function EnviarSolicitudNoParticipacionEtapaUno(Request $request){
        $idlicitacion = $request->get('idlicitacion');

        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 3;
        $licitacion->observaciones_no_participar = $request->get('observaciones');

        //adjunto carta excusa
        if($request->hasFile('adjuntocartaexcusa')){
            $file = $request->file('adjuntocartaexcusa');
            $extension = $file->getClientOriginalExtension();
            $filename = $idlicitacion.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

            Storage::disk('adjuntocartaexcusa')->put($filename, \File::get($file));

            $licitacion->nombre_archivo_carta_excusa_no_participacion = $filename;
            $licitacion->url_archivo_carta_excusa_no_participacion = '/extras/documentacion/adjuntocartaexcusa/'.$filename;
        }

        if($licitacion->update()){
            //guardar los motivos
            $text_motivos = '';
            if($request->get('motivosnoparticipar')){
                foreach ($request->get('motivosnoparticipar') as $motivo) {
                    $mot = new LicitacionesMotivosNoParticipar();
                    $mot->id_licitacion = $idlicitacion;
                    $mot->id_motivo = $motivo;
                    $mot->save();

                    //obtener informacion motivo
                    $getMotivo = MMotivosNoParticipar::where('id',$motivo)->first();
                    $nombremotivo = isset($getMotivo)?$getMotivo->nombre:null;

                    if($nombremotivo != null){
                        $text_motivos .= $nombremotivo.' / ';
                    }
                }
            }

            //enviar aviso a Sub-Gerente Operaciones y gerente desarrollo de solicitud
            $objDemo = new \stdClass();
            $objDemo->idlicitacion = $idlicitacion;
            $objDemo->nombrelicitacion = $licitacion->titulo;
            $objDemo->descripcion = $request->get('observaciones');
            $objDemo->fechasolicitud = date('Y-m-d');
            $objDemo->usuariosolicitud = Auth::user()->name.' '.Auth::user()->ap_paterno.' '.Auth::user()->ap_materno;
            $objDemo->text_motivos = $text_motivos;

            //buscar rol Sub-Gerente Operaciones y gerente desarrollo
            $listadousuarios = User::all();
            if($listadousuarios){
                foreach ($listadousuarios as $user) {
                    //preguntar si es rol Sub-Gerente Operaciones y gerente desarrollo
                    if($user->hasRole('Sub-Gerente Operaciones') || $user->hasRole('Gerente Desarrollo')){
                        Mail::to($user->email)->send(new AvisoNoParticipar($objDemo));
                    }
                }
            }

            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 3;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function modalresponderparticipacionlicitacionetapauno($id){
        $existsLicitacion = Licitaciones::where('id', $id)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::where('id', $id)->first();
            $list_motivos = LicitacionesMotivosNoParticipar::with('motivo')->where('id_licitacion',$id)->get();

            return view('licitaciones.modalResponderParticipacionLicitacionEtapaUno', compact('licitacion','list_motivos'));
        } else {
            return "<hr><h2 style='text-align:center'>No se encontro la licitación ingresada, favor verificar</h2><hr>";
        }
    }

    public function RespuestaSolicitudParticipacion(Request $request){
        $idlicitacion = $request->get('idlicitacion');
        $idetapa = $request->get('respuestaparticipacion');

        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = $idetapa;

        if($licitacion->update()){
            //enviar al responsable las fechas de la licitacion
            $objDemo = new \stdClass();
            $objDemo->idlicitacion = $idlicitacion;
            $objDemo->nombrelicitacion = $licitacion->titulo;
            $objDemo->fechavisita = $licitacion->fechavisita;
            $objDemo->fechapreguntayrespuestas = $licitacion->fechapreguntayrespuestas;
            $objDemo->fechaenviopropuesta = $licitacion->fechaenviopropuesta;
            $objDemo->usuariosolicitud = Auth::user()->name.' '.Auth::user()->ap_paterno.' '.Auth::user()->ap_materno;

            $listadousuarios = User::all();
            if($listadousuarios){
                foreach ($listadousuarios as $user) {
                    if($user->hasRole('Responsable')){
                        Mail::to($user->email)->send(new AvisoFechasLicitacion($objDemo));
                    }
                }
            }

            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = $idetapa;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function autoasignarseresponsablelicitacion($idlicitacion){
        $existsLicitacion = Licitaciones::where('id', $idlicitacion)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_responsable = Auth::user()->id;
            $licitacion->id_etapa = 6;

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 6;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();

                return redirect('licitaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        } else {
            return redirect('licitaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    //para pasar a la etapa 6 (asignacion responsable)
    public function modalasignarresponsable($id){
        $existsLicitacion = Licitaciones::where('id', $id)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::where('id', $id)->first();
            $usuarios = User::all();
            $grupos = Grupos::all();

            return view('licitaciones.modalAsignarResponsable', compact('licitacion','usuarios','grupos'));
        } else {
            return "<hr><h2 style='text-align:center'>No se encontro la licitación ingresada, favor verificar</h2><hr>";
        }
    }

    public function asignacionresponsableetapauno(Request $request){
        $idlicitacion = $request->get('idlicitacion');
        $grupo = $request->get('grupo');

        //obtener datos del grupo seleccionado
        $getGrupo = Grupos::where('id',$grupo)->first();

        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_grupo = $grupo;
        $licitacion->id_jefe_operaciones = $getGrupo->id_jefe_operaciones;
        $licitacion->id_responsable = $request->get('responsable');
        $licitacion->id_planificacion = $getGrupo->id_planificacion;
        $licitacion->id_contabilidad = $getGrupo->id_contabilidad;
        $licitacion->id_etapa = 6;

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 6;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    //etapa 7 (proceso de visitas)
    public function pendientevisitas()
    {
        $iduser = Auth::user()->id;
        $licitaciones = Licitaciones::where('id_responsable',$iduser)->where('id_etapa',6)->get();

        return view('licitaciones.pendientevisitas',compact('licitaciones'));
    }

    public function modalgestionarvisita($id){
        $existsLicitacion = Licitaciones::where('id', $id)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::where('id', $id)->first();

            return view('licitaciones.modalGestionarVisita', compact('licitacion'));
        } else {
            return "<hr><h2 style='text-align:center'>No se encontro la licitación ingresada, favor verificar</h2><hr>";
        }
    }

    public function ingresarGestionVisita(Request $request){
        $idlicitacion = $request->get('idlicitacion');

        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->observaciones = $request->get('observaciones');
        $licitacion->fecha_aceptacion_lic = date('Y-m-d');
        $licitacion->aceptacion_con_visita = $request->get('statusvisita');
        $licitacion->id_etapa = 7;

        //adjunto visita
        if($request->hasFile('adjuntovisita')){
            $file2 = $request->file('adjuntovisita');
            $extension2 = $file2->getClientOriginalExtension();
            $filename2 = $idlicitacion.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension2;

            Storage::disk('adjuntovisita')->put($filename2, \File::get($file2));

            $licitacion->nombre_archivo_visita = $filename2;
            $licitacion->url_visita = '/extras/documentacion/adjuntovisita/'.$filename2;
        }

        if($licitacion->update()){
            if($licitacion->id_tipo_licitacion == 4){
                //enviar al responsable las fechas de la licitacion
                $objDemo = new \stdClass();
                $objDemo->idlicitacion = $idlicitacion;
                $objDemo->nombrelicitacion = $licitacion->titulo;
                $objDemo->fechavisita = $licitacion->fechavisita;
                $objDemo->fechapreguntayrespuestas = $licitacion->fechapreguntayrespuestas;
                $objDemo->fechaenviopropuesta = $licitacion->fechaenviopropuesta;
                $objDemo->usuariosolicitud = Auth::user()->name.' '.Auth::user()->ap_paterno.' '.Auth::user()->ap_materno;

                $listadousuarios = User::all();
                if($listadousuarios){
                    foreach ($listadousuarios as $user) {
                        if($user->hasRole('Responsable')){
                            Mail::to($user->email)->send(new AvisoFechasLicitacion($objDemo));
                        }
                    }
                }
            }

            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 7;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/pendientevisitas')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/pendientevisitas')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    //etapas desde 7 hasta la 17 (informacion tecnica, cotizacion y solicitar autorizacion)
    public function cotizaciones()
    {
        $iduser = Auth::user()->id;

        if(Auth::user()->hasRole('Responsable')){
            $licitaciones = Licitaciones::where('id_responsable',$iduser)->where('id_etapa','>=',7)->where('id_etapa','<=',17)->get();
        }else{
            $licitaciones = Licitaciones::where('id_etapa','>=',7)->where('id_etapa','<=',17)->get();
        }

        return view('licitaciones.cotizaciones',compact('licitaciones'));
    }

    public function solicitardardebajalicitacion($idlicitacion){
        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 8;

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 8;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/cotizaciones')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function modalrespondersolicituddardebajalicitacion($id){
        $existsLicitacion = Licitaciones::where('id', $id)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::where('id', $id)->first();

            return view('licitaciones.modalResponderSolicitudDardeBajaLicitacion', compact('licitacion'));
        } else {
            return "<hr><h2 style='text-align:center'>No se encontro la licitación ingresada, favor verificar</h2><hr>";
        }
    }

    public function RespuestaSolicitudDardeBajaLicitacion(Request $request){
        $idlicitacion = $request->get('idlicitacion');
        $idetapa = $request->get('respuestasolicitud');

        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = $idetapa;

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = $idetapa;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/cotizaciones')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    //etapa ingresar cotizacion
    public function ingresarcotizacion(Request $request)
    {
        $idlicitacion = $request->get('idlicitacion');
        $getlicitacion = Licitaciones::where('id',$idlicitacion)->first();

        if($getlicitacion->id_tipo_licitacion == 3){
            //si es SPOT
            //eliminar registros antiguos
            ItemsLicitaciones::where('id_licitacion',$idlicitacion)->delete();

            //item personas
            $item = new ItemsLicitaciones();
            $item->id_licitacion = $idlicitacion;
            $item->id_item = 1;
            $item->valor = str_replace('.','',$request->get('ic_montopersonal'));
            $item->save();

            //item materiales
            $item = new ItemsLicitaciones();
            $item->id_licitacion = $idlicitacion;
            $item->id_item = 2;
            $item->valor = str_replace('.','',$request->get('ic_montomaterial'));
            $item->save();

            //item servicio
            $item = new ItemsLicitaciones();
            $item->id_licitacion = $idlicitacion;
            $item->id_item = 3;
            $item->valor = str_replace('.','',$request->get('ic_montoequipos'));
            $item->save();

            //item margen
            $item = new ItemsLicitaciones();
            $item->id_licitacion = $idlicitacion;
            $item->id_item = 4;
            $item->valor = str_replace('.','',$request->get('ic_montomargen'));
            $item->save();

            //comprobar la etapa del monto
            $montolicitacion = str_replace('.','',$request->get('valorcotizacion'));
            $idetapalicitacion = 11;
            $lict_aprobacion_inicial_automatica = 0;

            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = $idetapalicitacion;
            $licitacion->aprobacion_inicial_automatica = $lict_aprobacion_inicial_automatica;
            $licitacion->monto_cotizacion = $montolicitacion;
            $licitacion->observacionesreenviorevisioncotizacion = $request->get('observacionesreenviorevisioncotizacion',null);

            //Adjunto Evaluación Economica
            if($request->hasFile('evaluacioneconomicacotizacion')){
                $file = $request->file('evaluacioneconomicacotizacion');
                $extension = $file->getClientOriginalExtension();
                $filename = $idlicitacion.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

                Storage::disk('evaluacioneconomicacotizacion')->put($filename, \File::get($file));

                $licitacion->nombre_archivo_cot_evaluacion_economica = $filename;
                $licitacion->url_archivo_cot_evaluacion_economica = '/extras/documentacion/evaluacioneconomicacotizacion/'.$filename;
            }

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = $idetapalicitacion;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();

                //registrar historial cotizacion
                $historialitem = new ItemsLicitacionesHistorial();
                $historialitem->id_usuario = Auth::user()->id;
                $historialitem->id_licitacion = $idlicitacion;
                $historialitem->valor_item_personal = str_replace('.','',$request->get('ic_montopersonal'));
                $historialitem->valor_item_materiales = str_replace('.','',$request->get('ic_montomaterial'));
                $historialitem->valor_itemservicios = str_replace('.','',$request->get('ic_montoequipos'));
                $historialitem->valor_itemmargen = str_replace('.','',$request->get('ic_montomargen'));
                $historialitem->observacionesreenviorevisioncotizacion = $request->get('observacionesreenviorevisioncotizacion',null);
                $historialitem->save();

                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        }elseif($getlicitacion->id_tipo_licitacion == 4){
            //si es PGP
            //eliminar registros anteriores
            LicitacionesCotizacionesPGP::where('id_licitacion',$idlicitacion)->delete();

            $errorsdoc = 0;

            $filas_cotizaciones = $request->get('fila_cotizacion');
            $cot_nombre = $request->get('cot_nombre');
            $cot_valor_total = $request->get('cot_valor_total');
            $cot_ic_montomaterial = $request->get('cot_ic_montomaterial');
            $cot_ic_montopersonal = $request->get('cot_ic_montopersonal');
            $cot_ic_montoequipos = $request->get('cot_ic_montoequipos');
            $cot_ic_ggutilidad = $request->get('cot_ic_ggutilidad');
            $cot_ic_totalneto = $request->get('cot_ic_totalneto');
            $cot_ic_montomargen = $request->get('cot_ic_montomargen');

            if($filas_cotizaciones){
                foreach ($filas_cotizaciones as $keycotiz) {
                    $licitcot = new LicitacionesCotizacionesPGP();
                    $licitcot->id_licitacion = $idlicitacion;
                    $licitcot->nombre = $cot_nombre[$keycotiz];
                    $licitcot->valor_total_cotizacion = str_replace('.','',$cot_valor_total[$keycotiz]);
                    $licitcot->monto_item_material = str_replace('.','',$cot_ic_montomaterial[$keycotiz]);
                    $licitcot->monto_item_personal = str_replace('.','',$cot_ic_montopersonal[$keycotiz]);
                    $licitcot->monto_item_servicios = str_replace('.','',$cot_ic_montoequipos[$keycotiz]);
                    $licitcot->ggutilidad = str_replace('.','',$cot_ic_ggutilidad[$keycotiz]);
                    $licitcot->total_neto = str_replace('.','',$cot_ic_totalneto[$keycotiz]);
                    $licitcot->porcentaje_margen = str_replace('.','',$cot_ic_montomargen[$keycotiz]);
                    $licitcot->estado = 0;
                    $licitcot->estado_aprobacion = 0;

                    $existefile = isset($request->file('cot_ic_evaluacion_economica')[$keycotiz])?1:0;
                    if($existefile == 1){
                        try {
                            $files = $request->file('cot_ic_evaluacion_economica');

                            $file = $files[$keycotiz]['file'];
                            $extension = $file->getClientOriginalExtension();
                            $filename = $idlicitacion.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

                            Storage::disk('evaluacioneconomicacotizacion')->put($filename, \File::get($file));

                            $licitcot->url_evaluacion_economica = '/extras/documentacion/evaluacioneconomicacotizacion/'.$filename;
                            $licitcot->extension_adjunto = $extension;
                        } catch (\Throwable $th) {
                            $errorsdoc++;
                        }
                    }

                    if($licitcot->save()){
                        //registrar historial cotizacion
                        $historialitem = new ItemsLicitacionesHistorial();
                        $historialitem->id_usuario = Auth::user()->id;
                        $historialitem->id_licitacion = $idlicitacion;
                        $historialitem->valor_item_personal = str_replace('.','',$cot_ic_montopersonal[$keycotiz]);
                        $historialitem->valor_item_materiales = str_replace('.','',$cot_ic_montomaterial[$keycotiz]);
                        $historialitem->valor_itemservicios = str_replace('.','',$cot_ic_montoequipos[$keycotiz]);
                        $historialitem->valor_itemmargen = str_replace('.','',$cot_ic_montomargen[$keycotiz]);
                        $historialitem->observacionesreenviorevisioncotizacion = null;
                        $historialitem->save();
                    }
                }
            }

            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 11;
            $licitacion->PGPcottotalvalormargen = $request->get("cottotalvalormargen");

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 11;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();

                if($errorsdoc == 0){
                    return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Licitación actualizada exitosamente');
                }else{
                    return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Licitación actualizada exitosamente, pero algunos adjunto no se lograron subir al servidor');
                }
            }else{
                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        }else{
            return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición, tipo no definido');
        }
    }

    public function aprobarcotizacionPGP($idlicitacion, $idcotizacion)
    {
        $cotizacion = LicitacionesCotizacionesPGP::findOrFail($idcotizacion);
        $cotizacion->estado_aprobacion = 1;
        $cotizacion->update();

        //contar si existen mas por aprobar
        $countpendientes = LicitacionesCotizacionesPGP::where('id_licitacion',$idlicitacion)->where('estado_aprobacion',0)->count();
        $countrechazadas = LicitacionesCotizacionesPGP::where('id_licitacion',$idlicitacion)->where('estado_aprobacion',2)->count();

        if($countpendientes == 0 && $countrechazadas == 0){
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 14;

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 14;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();
            }
        }

        return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Cotización actualizada exitosamente');
    }

    public function rechazarcotizacionPGP($idlicitacion, $idcotizacion)
    {
        $cotizacion = LicitacionesCotizacionesPGP::findOrFail($idcotizacion);
        $cotizacion->estado_aprobacion = 2;
        $cotizacion->update();

        //contar si existen mas por aprobar
        $countpendientes = LicitacionesCotizacionesPGP::where('id_licitacion',$idlicitacion)->where('estado_aprobacion',0)->count();
        $countrechazadas = LicitacionesCotizacionesPGP::where('id_licitacion',$idlicitacion)->where('estado_aprobacion',2)->count();

        if($countpendientes == 0 && $countrechazadas == 0){
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 14;

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 14;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();
            }
        }

        return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Cotización actualizada exitosamente');
    }

    public function eliminarcotizacionPGP($idlicitacion, $idcotizacion)
    {
        $cotizacion = LicitacionesCotizacionesPGP::where('id',$idcotizacion)->delete();

        //contar si existen mas por aprobar
        $countpendientes = LicitacionesCotizacionesPGP::where('id_licitacion',$idlicitacion)->where('estado_aprobacion',0)->count();
        $countrechazadas = LicitacionesCotizacionesPGP::where('id_licitacion',$idlicitacion)->where('estado_aprobacion',2)->count();

        if($countpendientes == 0 && $countrechazadas == 0){
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 14;

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 14;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();
            }
        }

        return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Cotización actualizada exitosamente');
    }

    public function volveraenviarcotizacion(Request $request)
    {
        $idlicitacion = $request->get('idlicitacion');
        $index = $request->get('index');

        $errorsdoc = 0;

        $cot_id = $request->get('idcotizacionpgp');
        $cot_valor_total = $request->get('cot_valor_total');
        $cot_ic_montopersonal = $request->get('cot_ic_montopersonal');
        $cot_ic_montomaterial = $request->get('cot_ic_montomaterial');
        $cot_ic_montoequipos = $request->get('cot_ic_montoequipos');
        $cot_ic_ggutilidad = $request->get('cot_ic_ggutilidad');
        $cot_ic_totalneto = $request->get('cot_ic_totalneto');
        $cot_ic_montomargen = $request->get('cot_ic_montomargen');

        $idcotizacionPGP = $cot_id[$index];

        $licitcot = LicitacionesCotizacionesPGP::findOrFail($idcotizacionPGP);
        $licitcot->valor_total_cotizacion = str_replace('.','',$cot_valor_total[$index]);
        $licitcot->monto_item_material = str_replace('.','',$cot_ic_montomaterial[$index]);
        $licitcot->monto_item_personal = str_replace('.','',$cot_ic_montopersonal[$index]);
        $licitcot->monto_item_servicios = str_replace('.','',$cot_ic_montoequipos[$index]);
        $licitcot->ggutilidad = str_replace('.','',$cot_ic_ggutilidad[$index]);
        $licitcot->total_neto = str_replace('.','',$cot_ic_totalneto[$index]);
        $licitcot->porcentaje_margen = str_replace('.','',$cot_ic_montomargen[$index]);
        $licitcot->estado_aprobacion = 0;

        $existefile = isset($request->file('cot_ic_evaluacion_economica')[$index])?1:0;
        if($existefile == 1){
            try {
                $files = $request->file('cot_ic_evaluacion_economica');

                $file = $files[$index]['file'];
                $extension = $file->getClientOriginalExtension();
                $filename = $idlicitacion.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

                Storage::disk('evaluacioneconomicacotizacion')->put($filename, \File::get($file));

                $licitcot->url_evaluacion_economica = '/extras/documentacion/evaluacioneconomicacotizacion/'.$filename;
                $licitcot->extension_adjunto = $extension;
            } catch (\Throwable $th) {
                $errorsdoc++;
            }
        }

        if($licitcot->update()){
            //registrar historial cotizacion
            $historialitem = new ItemsLicitacionesHistorial();
            $historialitem->id_usuario = Auth::user()->id;
            $historialitem->id_licitacion = $idlicitacion;
            $historialitem->valor_item_personal = str_replace('.','',$cot_ic_montopersonal[$index]);
            $historialitem->valor_item_materiales = str_replace('.','',$cot_ic_montomaterial[$index]);
            $historialitem->valor_itemservicios = str_replace('.','',$cot_ic_montoequipos[$index]);
            $historialitem->valor_itemmargen = str_replace('.','',$cot_ic_montomargen[$index]);
            $historialitem->observacionesreenviorevisioncotizacion = null;
            $historialitem->save();

            return response()->json([
                'estado'    => 'success'
            ]);
        }else{
            return response()->json([
                'estado'    => 'error'
            ]);
        }
    }

    public function aprobacionCotizPGPsubgerenteoperaciones($idlicitacion){
        $existsLicitacion = Licitaciones::where('id', $idlicitacion)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->pgp_aprobacioncot_subgerenteoperaciones = 1;

            if($licitacion->update()){
                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        } else {
            return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function aprobacionCotizPGPsubgerentegeneral($idlicitacion){
        $existsLicitacion = Licitaciones::where('id', $idlicitacion)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->pgp_aprobacioncot_subgerentegeneral = 1;

            if($licitacion->update()){
                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        } else {
            return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function aprobacionCotizPGPgerentegeneral($idlicitacion){
        $existsLicitacion = Licitaciones::where('id', $idlicitacion)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->pgp_aprobacioncot_gerentegeneral = 1;

            if($licitacion->update()){

                //enviar aviso a Sub-Gerente Operaciones y gerente desarrollo de solicitud
                $objDemo = new \stdClass();
                $objDemo->idlicitacion = $idlicitacion;
                $objDemo->nombrelicitacion = $licitacion->titulo;
                $objDemo->montolicitacion = "$".number_format($licitacion->monto_cotizacion,0,',','.');
                $objDemo->empresalicitacion = $licitacion->empresa->nombre;
                $objDemo->fechasolicitud = date('Y-m-d');
                $objDemo->usuariosolicitud = Auth::user()->name.' '.Auth::user()->ap_paterno.' '.Auth::user()->ap_materno;

                $listadousuarios = User::all();
                if($listadousuarios){
                    foreach ($listadousuarios as $user) {
                        if($user->hasRole('Responsable')){
                            Mail::to($user->email)->send(new CotizacionCompletaAprobada($objDemo));
                        }
                    }
                }

                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        } else {
            return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function solicitarrevisioncotizacion($idlicitacion){
        $existsLicitacion = Licitaciones::where('id', $idlicitacion)->exists();
        if ($existsLicitacion) {
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 12;

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 12;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();

                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        } else {
            return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function modalrespondersolicitudrevisioncotizacion($id){
        $existsLicitacion = Licitaciones::where('id', $id)->exists();
        if ($existsLicitacion) {
            $getConfiguraciones = Configuraciones::first();
            $licitacion = Licitaciones::where('id', $id)->first();

            return view('licitaciones.modalResponderSolicitudRevisionCotizacionLicitacion', compact('licitacion','getConfiguraciones'));
        } else {
            return "<hr><h2 style='text-align:center'>No se encontro la licitación ingresada, favor verificar</h2><hr>";
        }
    }

    public function registrarrespuestarevisioncotizacion(Request $request)
    {
        $idlicitacion = $request->get('idlicitacion');

        $licitacion = Licitaciones::findOrFail($idlicitacion);

        //si uno de los 2 roles rechazo
        if($request->get('respuestasolicitud') == 2){
            $id_etapa = 13;
            $licitacion->observacionesnocotizacionjefecomercial = $request->get('observacionesnojefecomercial');
        }else{
            $id_etapa = 14;
        }

        $licitacion->id_etapa = $id_etapa;

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = $id_etapa;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            if($request->get('respuestasolicitud') == 1){
                //enviar aviso a gerente gerenal
                $getlicitacion = Licitaciones::findOrFail($idlicitacion);

                $objDemo = new \stdClass();
                $objDemo->idlicitacion = $idlicitacion;
                $objDemo->nombrelicitacion = $getlicitacion->titulo;
                $objDemo->montolicitacion = "$".number_format($getlicitacion->monto_cotizacion,0,',','.');
                $objDemo->empresalicitacion = $getlicitacion->empresa->nombre;
                $objDemo->fechasolicitud = date('Y-m-d');
                $objDemo->usuariosolicitud = Auth::user()->name.' '.Auth::user()->ap_paterno.' '.Auth::user()->ap_materno;

                Mail::to('cosorio@ackservicios.cl')->send(new CotizacionCompletaAprobada($objDemo));
            }

            return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function solicitudautorizarmontocotizacion($idlicitacion)
    {
        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 15;

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 15;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/continuar/'.$idlicitacion.'/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function autorizacionescotizaciones()
    {
        $getConfiguraciones = Configuraciones::first();
        //$idrolcotizacionbasica = $getConfiguraciones->idrol_autorizacion_cotizacion_basica;
        //$idrolcotizacionavanzada = $getConfiguraciones->idrol_autorizacion_cotizacion_avanzada;

        //$monto_maximo_aprobacion_automatica = $getConfiguraciones->monto_maximo_aprobacion_automatica;
        //$monto_maximo_autorizacion_cotizacion_basica = $getConfiguraciones->monto_maximo_autorizacion_cotizacion_basica;
        //$monto_maximo_autorizacion_cotizacion_avanzada = $getConfiguraciones->monto_maximo_autorizacion_cotizacion_avanzada;

        //$rolcotizacionbasica = Role::where('id',$idrolcotizacionbasica)->first()->name;
        //$rolcotizacionavanzada = Role::where('id',$idrolcotizacionavanzada)->first()->name;

        //if(Auth::user()->hasRole($rolcotizacionbasica)){
            //$licitaciones = Licitaciones::where('id_etapa',15)->where('monto_cotizacion','>',$monto_maximo_aprobacion_automatica)->where('monto_cotizacion','<=',$monto_maximo_autorizacion_cotizacion_basica)->get();
            $licitaciones = Licitaciones::where('id_etapa',15)->get();
        //}elseif(Auth::user()->hasRole($rolcotizacionavanzada)){
            //$licitaciones = Licitaciones::where('id_etapa',15)->where('monto_cotizacion','>',$monto_maximo_autorizacion_cotizacion_basica)->get();
        //}else{
            //$licitaciones = [];
        //}

        return view('licitaciones.autorizacionescotizaciones',compact('licitaciones'));
    }

    public function registrarautorizacioncotizacion($idlicitacion, $status)
    {
        if($status == 'autorizar'){
            //etapa 17
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 17;

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 17;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();

                return redirect('licitaciones/autorizacionescotizaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones/autorizacionescotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }

        }else if($status == 'rechazar'){
            //etapa 16
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 16;

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 16;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();

                return redirect('licitaciones/autorizacionescotizaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones/autorizacionescotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        }else if($status == 'volverevaluar'){
            //etapa 7
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 7;
            $licitacion->aprobacion_revision_cotizacion_jefe_comercial = null;
            $licitacion->aprobacion_revision_cotizacion_jefe_operaciones = null;
            $licitacion->aprobacion_inicial_automatica = 0;

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 7;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();

                return redirect('licitaciones/autorizacionescotizaciones')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones/autorizacionescotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
            }
        }else{
            return redirect('licitaciones/autorizacionescotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function registrarsubidaofertaplataforma($idlicitacion)
    {
        //etapa 18
        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 18;

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 18;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/cotizaciones')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/cotizaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }

    }

    //etapa 20
    public function procesoadjudicacion()
    {
        $licitaciones = Licitaciones::where('id_etapa','>=',18)->where('id_etapa','<=',22)->get();

        return view('licitaciones.procesoadjudicacion',compact('licitaciones'));
    }

    public function ingresarResultadoAdjudicacion(Request $request){
		$idlicitacion = $request->get('idlicitacion');
		$id_etapa = $request->get('estado_adjudicacion');

        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = $id_etapa;

        //estado de no adjudicacion de la licitacion
        if($id_etapa == 19){
            $licitacion->observaciones_no_adjudicacion = $request->get('observaciones_no_adjudicacion');
        }

        //estado de adjudicacion de la licitacion
        if($id_etapa == 20){
            if($licitacion->id_tipo_licitacion == 3){

                $licitacion->monto_adjudicacion = str_replace('.','',$request->get('montoadjudicado'));

                $orden = new OrdenCliente();
                $orden->id_licitacion = $idlicitacion;
                $orden->id_usuario_modificacion = Auth::user()->id;
                $orden->fecha_inicio = $request->get('fechainicio_oc');
                $orden->fecha_termino = $request->get('fechatermino_oc');
                //$orden->ot_orden = $request->get('ot_orden');

                if($request->hasFile('orden_cliente')){
                    $file = $request->file('orden_cliente');
                    $extension = $file->getClientOriginalExtension();
                    $filename = $idlicitacion.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

                    Storage::disk('adjuntoordencliente')->put($filename, \File::get($file));

                    $orden->nombre_archivo = $filename;
                    $orden->url = '/extras/documentacion/adjuntoordencliente/'.$filename;
                }

                $orden->save();

                //guardar los item de SP/OM de la adjudicacion
                $listadofilasitemspom = $request->get('fila_item');
                $spomitem = $request->get('spomitem');
                $descripcionitem = $request->get('descripcionitem');
                $montoitem = $request->get('montoitem');

                if($listadofilasitemspom){
                    foreach ($listadofilasitemspom as $key) {
                        $item = new LicitacionesItemSPOM();
                        $item->id_licitacion = $idlicitacion;
                        $item->item_spom = $spomitem[$key];
                        $item->descripcion = $descripcionitem[$key];
                        $item->monto = str_replace('.','',$montoitem[$key]);
                        $item->estado = 0;
                        $item->save();
                    }
                }
            }
            
            if($licitacion->id_tipo_licitacion == 4){
                $filaadjpgp = $request->get('filaadjpgp');
                $adjpgp_id = $request->get('adjpgp_id');
                $adjpgp_fechainicio_oc = $request->get('adjpgp_fechainicio_oc');
                $adjpgp_fechatermino_oc = $request->get('adjpgp_fechatermino_oc');
                $adjpgp_spom = $request->get('adjpgp_spom');
                $adjpgp_descripcionspom = $request->get('adjpgp_descripcionspom');
                $adjpgp_montospom = $request->get('adjpgp_montospom');

                if($filaadjpgp){
                    foreach ($filaadjpgp as $key2) {
                        $idcotpgp = $adjpgp_id[$key2];

                        $cotizacion = LicitacionesCotizacionesPGP::findOrFail($idcotpgp);

                        $existefile = isset($request->file('adjpgp_orden_cliente')[$key2])?1:0;
                        if($existefile == 1){
                            try {
                                $files = $request->file('adjpgp_orden_cliente');

                                $file = $files[$key2]['file'];
                                $extension = $file->getClientOriginalExtension();
                                $filename = $idlicitacion.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

                                Storage::disk('adjuntoordencliente')->put($filename, \File::get($file));

                                $cotizacion->adjunto_orden_servicio = '/extras/documentacion/adjuntoordencliente/'.$filename;
                                $cotizacion->extension_adjunto_orden_servicio = $extension;
                            } catch (\Throwable $th) {
                            }
                        }

                        $cotizacion->fecha_inicio_ordenservicio = $adjpgp_fechainicio_oc[$key2];
                        $cotizacion->fecha_termino_ordenservicio = $adjpgp_fechatermino_oc[$key2];
                        $cotizacion->monto_adjudicacion = $adjpgp_montospom[$key2];
                        $cotizacion->spom_ordenservicio = $adjpgp_spom[$key2];
                        $cotizacion->descripcion_spom = $adjpgp_descripcionspom[$key2];
                        $cotizacion->monto_spom = $adjpgp_montospom[$key2];
                        $cotizacion->update();
                    }
                }

            }
        }

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = $id_etapa;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/continuar/'.$idlicitacion.'/procesoadjudicacion')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/continuar/'.$idlicitacion.'/procesoadjudicacion')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function registrarsolicitudcentrocosto($idlicitacion)
    {
        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 21;
		$licitacion->cc_fecha_solicitud = date('Y-m-d');

        if($licitacion->update()){
            //enviar aviso a contabilidad de solicitud
            $objDemo = new \stdClass();
            $objDemo->idlicitacion = $idlicitacion;
            $objDemo->nombrelicitacion = $licitacion->titulo;
            $objDemo->fechasolicitud = date('Y-m-d');
            $objDemo->usuariosolicitud = Auth::user()->name.' '.Auth::user()->ap_paterno.' '.Auth::user()->ap_materno;

            //buscar rol contabilidad
            $listadousuarios = User::all();
            if($listadousuarios){
                foreach ($listadousuarios as $user) {
                    //preguntar si es rol Contabilidad
                    if($user->hasRole('Contabilidad')){
                        Mail::to($user->email)->send(new SolicitudCentroCosto($objDemo));
                    }
                }
            }

            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 21;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/continuar/'.$idlicitacion.'/procesoadjudicacion')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/continuar/'.$idlicitacion.'/procesoadjudicacion')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function ingresarCentroCosto(Request $request){
		$idlicitacion = $request->get('idlicitacion');

        $validated = $request->validate([
            'centrocostolicitacion' => 'required',
        ],[
            'centrocostolicitacion.required' => 'El número de centro de costo es obligatorio',
        ]);

        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 22;
        $licitacion->centro_costo = $request->get('centrocostolicitacion');
		$licitacion->cc_fecha_creacion = date('Y-m-d');

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 22;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/continuar/'.$idlicitacion.'/procesoadjudicacion')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/continuar/'.$idlicitacion.'/procesoadjudicacion')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function registrarejecucionservicio(Request $request)
    {
        $idlicitacion = $request->get('idlicitacion');
        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 23;
		$licitacion->fecha_ejecucion_servicio = $request->get('fechainicioservicio');

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 23;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/procesoadjudicacion')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/procesoadjudicacion')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function registrarterminoservicio(Request $request)
    {
        $idlicitacion = $request->get('idlicitacion');
        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 24;
		$licitacion->fecha_termino_servicio = $request->get('fechaterminoservicio');

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 24;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/procesoejecutados')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/procesoejecutados')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function procesoejecutados()
    {
        $licitaciones = Licitaciones::where('id_etapa',23)->get();

        return view('licitaciones.procesoejecutados',compact('licitaciones'));
    }

    public function registrarTrabajoAdicional(Request $request){
		$idlicitacion = $request->get('idlicitacion');
		$trabajoadicionaloc = $request->get('trabajoadicionaloc');

        $trabaj = new LicitacionesTrabajosAdicionales();
        $trabaj->id_licitacion = $idlicitacion;
        $trabaj->monto = str_replace('.','',$request->get('montotrabajoadicional'));
        $trabaj->descripcion = $request->get('descripciontrabajoadicional');
        $trabaj->nombre_oc = $request->get('nombre_ordenservicio_trabadic');

        if($request->hasFile('adjunto_orden_servicio_trab_adic')){
            $file = $request->file('adjunto_orden_servicio_trab_adic');
            $extension = $file->getClientOriginalExtension();
            $filename = $idlicitacion.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

            Storage::disk('adjunto_orden_servicio_trab_adic')->put($filename, \File::get($file));

            $trabaj->adjunto_oc = '/extras/documentacion/adjuntoordenserviciotrabadic/'.$filename;

            if($trabajoadicionaloc == 0){
                //si es la misma OC
                $getregistrocc = OrdenCliente::where('id_licitacion', $idlicitacion)->first();
                $idregistrocc = isset($getregistrocc->id)?$getregistrocc->id:null;
                if($idregistrocc != null){
                    $ordenantigua = OrdenCliente::findOrFail($idregistrocc);
                    $ordenantigua->nombre_archivo = $filename;
                    $ordenantigua->url = '/extras/documentacion/adjuntoordenserviciotrabadic/'.$filename;
                    $ordenantigua->update();
                }
            }
        }

        $trabaj->oc_nueva = $trabajoadicionaloc;
        $trabaj->save();

        //guardar los item de SP/OM de la adjudicacion
        $listadofilasitemspom = $request->get('fila_item');
        $spomitem = $request->get('spomitem');
        $descripcionitem = $request->get('descripcionitem');
        $montoitem = $request->get('montoitem');

        if($listadofilasitemspom){
            foreach ($listadofilasitemspom as $key) {
                if($trabajoadicionaloc == 0){
                    //si es la misma OC
                    $item = new LicitacionesItemSPOM();
                    $item->id_licitacion = $idlicitacion;
                    $item->item_spom = $spomitem[$key];
                    $item->descripcion = $descripcionitem[$key];
                    $item->monto = str_replace('.','',$montoitem[$key]);
                    $item->estado = 0;
                    $item->save();
                }

                if($trabajoadicionaloc == 1){
                    //si es una OC nueva
                    $item = new LicitacionesItemSPOMTrabajosAdicionales();
                    $item->id_licitacion = $idlicitacion;
                    $item->id_trabajo_adicional = $trabaj->id;
                    $item->item_spom = $spomitem[$key];
                    $item->estado = 0;
                    $item->descripcion = $descripcionitem[$key];
                    $item->monto = str_replace('.','',$montoitem[$key]);
                    $item->save();
                }
            }
        }

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesoejecutados')->with('msj','Licitación actualizada exitosamente');
    }

    public function procesofinalizados()
    {
        $licitaciones = Licitaciones::where('id_etapa',24)->orWhere('id_etapa',25)->get();

        return view('licitaciones.procesofinalizados',compact('licitaciones'));
    }

    public function registraradjuntoinformetecnicospom(Request $request)
    {
        //etapa 24
        $idlicitacion = $request->get('idlicitacion');
        $idregistroitem = $request->get('idregistroitem');
        $istrabajoadicional = $request->get('istrabajoadicional');

        if($istrabajoadicional == 0){
            //si no es de un trabajo adicional
            $item = LicitacionesItemSPOM::findOrFail($idregistroitem);
            $item->estado = 1;

            if($request->hasFile('adjuntoinformetecnico')){
                $file = $request->file('adjuntoinformetecnico');
                $extension = $file->getClientOriginalExtension();
                $filename = $idlicitacion.'_'.$idregistroitem.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;
    
                Storage::disk('adjunto_informe_tecnico_spom')->put($filename, \File::get($file));
    
                $item->url_informe_tecnico = '/extras/documentacion/adjuntoinformetecnicospom/'.$filename;
            }

            $item->update();
        }else{
            //si es de un trabajo adicional
            $item = LicitacionesItemSPOMTrabajosAdicionales::findOrFail($idregistroitem);
            $item->estado = 1;

            if($request->hasFile('adjuntoinformetecnico')){
                $file = $request->file('adjuntoinformetecnico');
                $extension = $file->getClientOriginalExtension();
                $filename = $idlicitacion.'_'.$idregistroitem.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;
    
                Storage::disk('adjunto_informe_tecnico_spom')->put($filename, \File::get($file));
    
                $item->url_informe_tecnico = '/extras/documentacion/adjuntoinformetecnicospom/'.$filename;
            }

            $item->update();
        }

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

    public function registraraprobacioninformetecnicospom($idlicitacion,$idregistroitem,$istrabajoadicional,$resultado)
    {
        //etapa 24
        if($istrabajoadicional == 0){
            //si no es de un trabajo adicional
            $item = LicitacionesItemSPOM::findOrFail($idregistroitem);
            $item->estado = $resultado;
            $item->update();
        }else{
            //si es de un trabajo adicional
            $item = LicitacionesItemSPOMTrabajosAdicionales::findOrFail($idregistroitem);
            $item->estado = $resultado;
            $item->update();
        }

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

    public function registrarHasSPOM(Request $request)
    {
        //etapa 24
        $idlicitacion = $request->get('idlicitacion');
        $idregistroitem = $request->get('idregistroitem');
        $istrabajoadicional = $request->get('istrabajoadicional');

        if($istrabajoadicional == 0){
            //si no es de un trabajo adicional
            $item = LicitacionesItemSPOM::findOrFail($idregistroitem);
            $item->estado = 4;
            $item->numero_has = $request->get('numerohas');
            $item->update();
        }else{
            //si es de un trabajo adicional
            $item = LicitacionesItemSPOMTrabajosAdicionales::findOrFail($idregistroitem);
            $item->estado = 4;
            $item->numero_has = $request->get('numerohas');
            $item->update();
        }

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

    public function registrarsolicitudfacturarspom($idlicitacion,$idregistroitem,$istrabajoadicional)
    {
        //etapa 24
        if($istrabajoadicional == 0){
            //si no es de un trabajo adicional
            $item = LicitacionesItemSPOM::findOrFail($idregistroitem);
            $item->estado = 5;
            $item->update();
        }else{
            //si es de un trabajo adicional
            $item = LicitacionesItemSPOMTrabajosAdicionales::findOrFail($idregistroitem);
            $item->estado = 5;
            $item->update();
        }

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

    public function registrarFacturaHasSPOM(Request $request)
    {
        //etapa 24
        $idlicitacion = $request->get('idlicitacion');
        $idregistroitem = $request->get('idregistroitem');
        $istrabajoadicional = $request->get('istrabajoadicional');

        if($istrabajoadicional == 0){
            //si no es de un trabajo adicional
            $item = LicitacionesItemSPOM::findOrFail($idregistroitem);
            $item->estado = 6;
            $item->numero_factura = $request->get('numerofactura');
            $item->monto_factura = str_replace('.','',$request->get('montofactura'));

            if($request->hasFile('adjuntofacturahas')){
                $file = $request->file('adjuntofacturahas');
                $extension = $file->getClientOriginalExtension();
                $filename = $idlicitacion.'_'.$idregistroitem.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;
    
                Storage::disk('adjunto_factura_has')->put($filename, \File::get($file));
    
                $item->url_factura = '/extras/documentacion/adjuntofacturahas/'.$filename;
            }

            $item->update();
        }else{
            //si es de un trabajo adicional
            $item = LicitacionesItemSPOMTrabajosAdicionales::findOrFail($idregistroitem);
            $item->estado = 6;
            $item->numero_factura = $request->get('numerofactura');
            $item->monto_factura = str_replace('.','',$request->get('montofactura'));

            if($request->hasFile('adjuntofacturahas')){
                $file = $request->file('adjuntofacturahas');
                $extension = $file->getClientOriginalExtension();
                $filename = $idlicitacion.'_'.$idregistroitem.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;
    
                Storage::disk('adjunto_factura_has')->put($filename, \File::get($file));
    
                $item->url_factura = '/extras/documentacion/adjuntofacturahas/'.$filename;
            }

            $item->update();
        }

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

    public function registrarsolicitudcierreproyecto($idlicitacion)
    {
        //contar item SP/OM pendientes de facturar
        $countItemSPOM = LicitacionesItemSPOM::with('licitacion')->where('id_licitacion',$idlicitacion)->where('estado','<',6)->count();
        $countItemSPOMAdicionales = LicitacionesItemSPOMTrabajosAdicionales::where('id_licitacion',$idlicitacion)->where('estado','<',6)->count();
        $countItemSPOmpgp = LicitacionesCotizacionesPGP::where('id_licitacion',$idlicitacion)->where('estado','<',6)->where('estado_aprobacion',1)->count();

        if($countItemSPOM > 0 || $countItemSPOMAdicionales > 0 || $countItemSPOmpgp > 0){
            return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msjError','Ocurrio un error, debe completar los procesos de los SP/OM');
        }else{
            $licitacion = Licitaciones::findOrFail($idlicitacion);
            $licitacion->id_etapa = 25;
            $licitacion->fecha_solicitud_cierre_proyecto = date('Y-m-d');

            if($licitacion->update()){
                //registrar etapa historial
                $etapa = new RegistroEtapas();
                $etapa->id_licitacion = $idlicitacion;
                $etapa->id_etapa = 25;
                $etapa->id_usuario = Auth::user()->id;
                $etapa->fecha_registro = date('Y-m-d');
                $etapa->save();

                return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Licitación actualizada exitosamente');
            }else{
                return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msjError','Ocurrio un error al procesar la petición');
            }
        }
    }

    public function registrarcierreproyecto($idlicitacion)
    {
        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 26;
        $licitacion->fecha_cierre_proyecto = date('Y-m-d');

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 26;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/procesofinalizados')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/procesofinalizados')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function proyectoscerrados()
    {
        $licitaciones = Licitaciones::where('id_etapa',26)->get();

        return view('licitaciones.proyectoscerrados',compact('licitaciones'));
    }

    public function registraradjuntoinformekpiservicio(Request $request)
    {
        //etapa 27
        $idlicitacion = $request->get('idlicitacion');

        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 27;
        $licitacion->costo_facturado_total_proyecto = str_replace('.','',$request->get('facturado_total_proyecto'));
        $licitacion->costo_mano_obra = str_replace('.','',$request->get('costo_mano_obra'));
        $licitacion->porcentajecmo = $request->get('porcentajecmo');
        $licitacion->costo_directo_obra = str_replace('.','',$request->get('costo_directo_obra'));
        $licitacion->porcentajecostodirectoobra = $request->get('porcentajecostodirectoobra');
        $licitacion->costo_total_proyecto = str_replace('.','',$request->get('costototalproyecto'));
        $licitacion->porcentajecostototalproyecto = $request->get('porcentajecostototalproyecto');

        if($request->hasFile('adjuntoinformekpi')){
            $file = $request->file('adjuntoinformekpi');
            $extension = $file->getClientOriginalExtension();
            $filename = $idlicitacion.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

            Storage::disk('adjunto_infome_kpi_servicio')->put($filename, \File::get($file));

            $licitacion->url_informe_kpi_servicio = '/extras/documentacion/adjuntoinfomekpiservicio/'.$filename;
        }

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 27;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/proyectoscerrados')->with('msj','Licitación actualizada exitosamente');

        }else{
            return redirect('licitaciones/proyectoscerrados')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function pendientecierrecc()
    {
        $licitaciones = Licitaciones::where('id_etapa',27)->get();

        return view('licitaciones.pendientecierrecc',compact('licitaciones'));
    }

    public function registrarcierrecentrocosto($idlicitacion)
    {
        $licitacion = Licitaciones::findOrFail($idlicitacion);
        $licitacion->id_etapa = 28;
        $licitacion->f_cierre_centro_costo = date('Y-m-d');

        if($licitacion->update()){
            //registrar etapa historial
            $etapa = new RegistroEtapas();
            $etapa->id_licitacion = $idlicitacion;
            $etapa->id_etapa = 28;
            $etapa->id_usuario = Auth::user()->id;
            $etapa->fecha_registro = date('Y-m-d');
            $etapa->save();

            return redirect('licitaciones/pendientecierrecc')->with('msj','Licitación actualizada exitosamente');
        }else{
            return redirect('licitaciones/pendientecierrecc')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function cccerrados()
    {
        $licitaciones = Licitaciones::where('id_etapa',28)->get();

        return view('licitaciones.cccerrados',compact('licitaciones'));
    }

    public function destroy($id)
    {
        Licitaciones::find($id)->delete();

        return redirect('licitaciones')->with('msj','Licitación eliminada exitosamente');
    }

    protected function random_string()
    {
        $key = '';
        $keys = array_merge(range('a', 'z'), range(0, 9));

        for ($i = 0; $i < 10; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    //informes
    public function informe_estado_licitaciones()
    {
        $fechainicio = null;
        $fechatermino = null;
        $estadolicitacion = null;

        $licitaciones = Licitaciones::all();
        $tipolicitaciones = TipoLicitaciones::all();
        $listado_empresas = Empresas::all();
        $listado_etapas = Etapas::all();

        return view('licitaciones.informe_estado_licitaciones',compact('licitaciones','tipolicitaciones','listado_empresas','listado_etapas','fechainicio','fechatermino','estadolicitacion'));
    }

    public function postInforme_estado_licitaciones(Request $request)
    {
        $fechainicio = $request->get('fechainicio');
        $fechatermino = $request->get('fechatermino');
        $estadolicitacion = $request->get('estadolicitacion');

        $tipolicitaciones = TipoLicitaciones::all();
        $listado_empresas = Empresas::all();
        $listado_etapas = Etapas::all();

        $licitaciones = Licitaciones::
        when($fechainicio, function ($query, $fechainicio) {
            return $query->whereDate('fecha_creacion','>=',$fechainicio);
        })
        ->when($fechatermino, function ($query, $fechatermino) {
            return $query->whereDate('fecha_creacion','<=',$fechatermino);
        })
        
        ->when($estadolicitacion, function ($query, $estadolicitacion) {
            return $query->where('id_etapa', $estadolicitacion);
        })
        ->get();

        return view('licitaciones.informe_estado_licitaciones',compact('licitaciones','tipolicitaciones','listado_empresas','listado_etapas','fechainicio','fechatermino','estadolicitacion'));
    }

    public function getPGPEmpresa(Request $request, $id_empresa)
    {
        if ($request->ajax()) {
            $pgpempresa = EmpresasPGP::where('id_empresa', $id_empresa)->get();

            return response()->json($pgpempresa);
        }
    }

    public function getPlantasEmpresa(Request $request, $id_empresa)
    {
        if ($request->ajax()) {
            $plantasempresa = EmpresasPlantas::where('id_empresa', $id_empresa)->get();

            return response()->json($plantasempresa);
        }
    }

    public function getAreasPlanta(Request $request, $id_planta)
    {
        if ($request->ajax()) {
            $areasplanta = EmpresasPlantasAreas::where('id_planta', $id_planta)->get();

            return response()->json($areasplanta);
        }
    }

    //PGP
    public function registraradjuntoinformetecnicospomPGP(Request $request)
    {
        //etapa 24
        $idlicitacion = $request->get('idlicitacion');
        $idregistroitem = $request->get('spom_idregistrocotizPGP');

        $item = LicitacionesCotizacionesPGP::findOrFail($idregistroitem);
        $item->estado = 1;

        if($request->hasFile('adjuntoinformetecnico')){
            $file = $request->file('adjuntoinformetecnico');
            $extension = $file->getClientOriginalExtension();
            $filename = $idlicitacion.'_'.$idregistroitem.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

            Storage::disk('adjunto_informe_tecnico_spom')->put($filename, \File::get($file));

            $item->url_informe_tecnico = '/extras/documentacion/adjuntoinformetecnicospom/'.$filename;
        }

        $item->update();

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

    public function registraraprobacioninformetecnicospomPGP($idlicitacion,$idregistroitem,$resultado)
    {
        //etapa 24
        $item = LicitacionesCotizacionesPGP::findOrFail($idregistroitem);
        $item->estado = $resultado;
        $item->update();

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

    public function registrarHasSPOMPGP(Request $request)
    {
        //etapa 24
        $idlicitacion = $request->get('idlicitacion');
        $idregistroitem = $request->get('spom_idregistroitem2PGP');

        $item = LicitacionesCotizacionesPGP::findOrFail($idregistroitem);
        $item->estado = 4;
        $item->numero_has = $request->get('numerohas');
        $item->update();

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

    public function registrarsolicitudfacturarspomPGP($idlicitacion,$idregistroitem)
    {
        //etapa 24
        $item = LicitacionesCotizacionesPGP::findOrFail($idregistroitem);
        $item->estado = 5;
        $item->update();

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

    public function registrarFacturaHasSPOMPGP(Request $request)
    {
        //etapa 24
        $idlicitacion = $request->get('idlicitacion');
        $idregistroitem = $request->get('idregistroitem');

        $item = LicitacionesCotizacionesPGP::findOrFail($idregistroitem);
        $item->estado = 6;
        $item->numero_factura = $request->get('numerofactura');
        $item->monto_factura = str_replace('.','',$request->get('montofactura'));

        if($request->hasFile('adjuntofacturahas')){
            $file = $request->file('adjuntofacturahas');
            $extension = $file->getClientOriginalExtension();
            $filename = $idlicitacion.'_'.$idregistroitem.'_'.date('Y-m-d').'_'.$this->random_string().'.'.$extension;

            Storage::disk('adjunto_factura_has')->put($filename, \File::get($file));

            $item->url_factura = '/extras/documentacion/adjuntofacturahas/'.$filename;
        }

        $item->update();

        return redirect('licitaciones/continuar/'.$idlicitacion.'/procesofinalizados')->with('msj','Item SP/OM actualizado exitosamente');
    }

}
