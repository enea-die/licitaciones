<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoLicitaciones;
use Illuminate\Http\Request;

class TipoLicitacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list_tipo_licitaciones = TipoLicitaciones::all();

        return view('tipolicitaciones.index',compact('list_tipo_licitaciones'));
    }

    public function create()
    {
        return view('tipolicitaciones.create');
    }

    public function store(Request $request)
    {
        $tipo = new TipoLicitaciones();
        $tipo->nombre = $request->get('nombre');
        $tipo->estado = 1;

        if($tipo->save()){
            return redirect()->route('tipolicitaciones')->with('msj','Tipo licitación creada exitosamente');
        }else{
            return redirect()->route('tipolicitaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function edit($id)
    {
        $tipo = TipoLicitaciones::where('id',$id)->first();

        return view('tipolicitaciones.edit',compact('tipo'));
    }

    public function update(Request $request)
    {
        $idtipo = $request->get('idtipo');

        $tipo = TipoLicitaciones::findOrFail($idtipo);
        $tipo->nombre = $request->get('nombre');
        $tipo->estado = $request->get('estado');

        if($tipo->update()){
            return redirect()->route('tipolicitaciones')->with('msj','Tipo licitación actualizada exitosamente');
        }else{
            return redirect()->route('tipolicitaciones')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function destroy($id)
    {
        TipoLicitaciones::find($id)->delete();

        return redirect()->route('tipolicitaciones')->with('msj','Tipo licitación eliminada exitosamente');
    }

}
