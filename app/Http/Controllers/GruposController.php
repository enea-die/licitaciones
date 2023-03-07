<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Grupos;
use App\Models\GruposHistorial;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class GruposController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list_grupos = Grupos::all();

        return view('grupos.index',compact('list_grupos'));
    }

    public function create()
    {
        $list_usuarios = User::with('roles')->get();

        return view('grupos.create',compact('list_usuarios'));
    }

    public function store(Request $request)
    {
        $grupo = new Grupos();
        $grupo->nombre_grupo = $request->get('nombre');
        $grupo->id_jefe_operaciones = $request->get('id_jefe_operaciones');
        $grupo->id_responsable = $request->get('id_responsable');
        $grupo->id_planificacion = $request->get('id_planificacion');
        $grupo->id_contabilidad = $request->get('id_contabilidad');

        if($grupo->save()){
            $grupohistorial = new GruposHistorial();
            $grupohistorial->id_grupo = $grupo->id;
            $grupohistorial->id_usuario = Auth::user()->id;
            $grupohistorial->nombre_grupo = $request->get('nombre');
            $grupohistorial->id_jefe_operaciones = $request->get('id_jefe_operaciones');
            $grupohistorial->id_responsable = $request->get('id_responsable');
            $grupohistorial->id_planificacion = $request->get('id_planificacion');
            $grupohistorial->id_contabilidad = $request->get('id_contabilidad');
            $grupohistorial->save();

            return redirect()->route('grupos')->with('msj','Grupo creado exitosamente');
        }else{
            return redirect()->route('grupos')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function edit($id)
    {
        $grupo = Grupos::where('id',$id)->first();
        $list_usuarios = User::with('roles')->get();

        return view('grupos.edit',compact('grupo','list_usuarios'));
    }

    public function update(Request $request)
    {
        $idgrupo = $request->get('idgrupo');

        $grupo = Grupos::findOrFail($idgrupo);
        $grupo->nombre_grupo = $request->get('nombre');
        $grupo->id_jefe_operaciones = $request->get('id_jefe_operaciones');
        $grupo->id_responsable = $request->get('id_responsable');
        $grupo->id_planificacion = $request->get('id_planificacion');
        $grupo->id_contabilidad = $request->get('id_contabilidad');

        if($grupo->update()){
            $grupohistorial = new GruposHistorial();
            $grupohistorial->id_grupo = $idgrupo;
            $grupohistorial->id_usuario = Auth::user()->id;
            $grupohistorial->nombre_grupo = $request->get('nombre');
            $grupohistorial->id_jefe_operaciones = $request->get('id_jefe_operaciones');
            $grupohistorial->id_responsable = $request->get('id_responsable');
            $grupohistorial->id_planificacion = $request->get('id_planificacion');
            $grupohistorial->id_contabilidad = $request->get('id_contabilidad');
            $grupohistorial->save();

            return redirect()->route('grupos')->with('msj','Grupo actualizado exitosamente');
        }else{
            return redirect()->route('grupos')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function destroy($id)
    {
        Grupos::find($id)->delete();

        return redirect()->route('grupos')->with('msj','Grupo eliminado exitosamente');
    }

}
