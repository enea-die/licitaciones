<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Configuraciones;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ConfiguracionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roles = Role::all();
        $config = Configuraciones::where('id',1)->first();

        return view('configuraciones.index',compact('roles','config'));
    }

    public function update(Request $request)
    {
        //variables a corregir y eliminar
        //monto_maximo_aprobacion_automatica
        //idrol_autorizacion_cotizacion_basica
        //monto_maximo_autorizacion_cotizacion_basica
        //idrol_autorizacion_cotizacion_avanzada
        //monto_maximo_autorizacion_cotizacion_avanzada

        $idconfig = 1;

        $config = Configuraciones::findOrFail($idconfig);
        $config->jefeoperacionesmenorque = str_replace('.','',$request->get('jefeoperacionesmenorque'));
        $config->subgerenteoperacionesentre_inicial = str_replace('.','',$request->get('subgerenteoperacionesentre_inicial'));
        $config->subgerenteoperacionesentre_final = str_replace('.','',$request->get('subgerenteoperacionesentre_final'));
        $config->subgerentegeneralentre_inicial = str_replace('.','',$request->get('subgerentegeneralentre_inicial'));
        $config->subgerentegeneralentre_final = str_replace('.','',$request->get('subgerentegeneralentre_final'));
        $config->gerentegeneralmayorque = str_replace('.','',$request->get('gerentegeneralmayorque'));

        if($config->update()){
            return redirect('configuraciones')->with('msj','Configuraciones actualizada exitosamente');
        }else{
            return redirect('configuraciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

}
