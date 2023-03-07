<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresas;
use App\Models\EmpresasHistorial;
use App\Models\EmpresasPGP;
use App\Models\EmpresasPlantas;
use App\Models\EmpresasPlantasAreas;
use App\Models\MGiros;
use Illuminate\Http\Request;
use Auth;

class EmpresasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list_empresas = Empresas::all();

        return view('empresas.index',compact('list_empresas'));
    }

    public function create()
    {
        $listado_giros = MGiros::all();

        return view('empresas.create',compact('listado_giros'));
    }

    public function store(Request $request)
    {
        $empresa = new Empresas();
        $empresa->rut = $request->get('rut');
        $empresa->nombre = $request->get('nombre');
        $empresa->id_giro = $request->get('giro');
        $empresa->contacto = $request->get('contacto');
        $empresa->telefono = $request->get('telefono');

        if($empresa->save()){
            $empresahistorial = new EmpresasHistorial();
            $empresahistorial->id_empresa = $empresa->id;
            $empresahistorial->id_usuario = Auth::user()->id;
            $empresahistorial->rut = $request->get('rut');
            $empresahistorial->nombre = $request->get('nombre');
            $empresahistorial->id_giro = $request->get('giro');
            $empresahistorial->contacto = $request->get('contacto');
            $empresahistorial->telefono = $request->get('telefono');
            $empresahistorial->save();

            return redirect()->route('empresas')->with('msj','Empresa creada exitosamente');
        }else{
            return redirect()->route('empresas')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function edit($id)
    {
        $empresa = Empresas::where('id',$id)->first();
        $listado_giros = MGiros::all();

        return view('empresas.edit',compact('empresa','listado_giros'));
    }

    public function pgp($id)
    {
        $empresa = Empresas::where('id',$id)->first();
        $listado_pgp = EmpresasPGP::where('id_empresa',$id)->orderBy('id','desc')->get();

        return view('empresas.listado_pgp',compact('empresa','listado_pgp'));
    }

    public function crearPgpEmpresa(Request $request)
    {
        $request->validate([
            'nombre'      => ['required'],
        ],[
            'nombre.required' => 'El campo nombre es obligatorio',
        ]);

        $idempresa = $request->get('idempresa');

        $pgp = new EmpresasPGP();
        $pgp->id_empresa = $idempresa;
        $pgp->nombre = $request->get('nombre');

        if($pgp->save()){
            return redirect('empresas/pgp/'.$idempresa)->with('msj','PGP Empresa creada exitosamente');
        }else{
            return redirect('empresas/pgp/'.$idempresa)->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function eliminarPGPEmpresa($idempresa, $idpgp)
    {
        EmpresasPGP::find($idpgp)->delete();

        return redirect('empresas/pgp/'.$idempresa)->with('msj','PGP Empresa eliminada exitosamente');
    }

    public function plantas($id)
    {
        $empresa = Empresas::where('id',$id)->first();
        $listado_plantas = EmpresasPlantas::with('areas')->where('id_empresa',$id)->orderBy('id','desc')->get();

        return view('empresas.listado_plantas',compact('empresa','listado_plantas'));
    }

    public function crearPlantaEmpresa(Request $request)
    {
        $request->validate([
            'nombre'      => ['required'],
        ],[
            'nombre.required' => 'El campo nombre es obligatorio',
        ]);

        $idempresa = $request->get('idempresa');

        $planta = new EmpresasPlantas();
        $planta->id_empresa = $idempresa;
        $planta->nombre = $request->get('nombre');

        if($planta->save()){
            return redirect('empresas/plantas/'.$idempresa)->with('msj','Planta Empresa creada exitosamente');
        }else{
            return redirect('empresas/plantas/'.$idempresa)->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function eliminarPlantaEmpresa($idempresa, $idpgp)
    {
        EmpresasPlantas::find($idpgp)->delete();

        return redirect('empresas/plantas/'.$idempresa)->with('msj','Planta Empresa eliminada exitosamente');
    }

    public function crearAreaPlanta(Request $request)
    {
        $request->validate([
            'areaplanta'      => ['required'],
        ],[
            'areaplanta.required' => 'El campo nombre es obligatorio',
        ]);

        $idempresa = $request->get('idempresa');
        $idplanta = $request->get('idplanta');

        $area = new EmpresasPlantasAreas();
        $area->id_planta = $idplanta;
        $area->nombre = $request->get('areaplanta');
        $area->contacto = $request->get('areacontacto');
        $area->telefono = $request->get('areatelefono');

        if($area->save()){
            return redirect('empresas/plantas/'.$idempresa)->with('msj','Area Planta creada exitosamente');
        }else{
            return redirect('empresas/plantas/'.$idempresa)->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function getAreaPlanta($idarea)
    {
        $data = [
            'area' => EmpresasPlantasAreas::where('id',$idarea)->first(),
            'status' => 'success'
        ];

        return response()->json($data);
    }

    public function editarAreaPlanta(Request $request)
    {
        $request->validate([
            'areaplanta'      => ['required'],
        ],[
            'areaplanta.required' => 'El campo nombre es obligatorio',
        ]);

        $idempresa = $request->get('idempresa');
        $idplanta = $request->get('idplanta');
        $idarea = $request->get('idarea');

        $area = EmpresasPlantasAreas::findOrFail($idarea);
        $area->id_planta = $idplanta;
        $area->nombre = $request->get('areaplanta');
        $area->contacto = $request->get('areacontacto');
        $area->telefono = $request->get('areatelefono');

        if($area->save()){
            return redirect('empresas/plantas/'.$idempresa)->with('msj','Area Planta actualizada exitosamente');
        }else{
            return redirect('empresas/plantas/'.$idempresa)->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function eliminarAreaPlantaEmpresa($idempresa, $idarea)
    {
        EmpresasPlantasAreas::find($idarea)->delete();

        return redirect('empresas/plantas/'.$idempresa)->with('msj','Area Planta eliminada exitosamente');
    }

    public function update(Request $request)
    {
        $idempresa = $request->get('idempresa');

        $empresa = Empresas::findOrFail($idempresa);
        $empresa->rut = $request->get('rut');
        $empresa->nombre = $request->get('nombre');
        $empresa->id_giro = $request->get('giro');
        $empresa->contacto = $request->get('contacto');
        $empresa->telefono = $request->get('telefono');

        if($empresa->update()){
            $empresahistorial = new EmpresasHistorial();
            $empresahistorial->id_empresa = $empresa->id;
            $empresahistorial->id_usuario = Auth::user()->id;
            $empresahistorial->rut = $request->get('rut');
            $empresahistorial->nombre = $request->get('nombre');
            $empresahistorial->id_giro = $request->get('giro');
            $empresahistorial->contacto = $request->get('contacto');
            $empresahistorial->telefono = $request->get('telefono');
            $empresahistorial->save();

            return redirect()->route('empresas')->with('msj','Empresa actualizada exitosamente');
        }else{
            return redirect()->route('empresas')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function destroy($id)
    {
        Empresas::find($id)->delete();

        return redirect()->route('empresas')->with('msj','Empresa eliminada exitosamente');
    }

}
