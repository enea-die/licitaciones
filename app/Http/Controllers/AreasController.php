<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MAreas;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list_areas = MAreas::all();

        return view('areas.index',compact('list_areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $area = new MAreas();
        $area->nombre = $request->get('nombre');

        if($area->save()){
            return redirect()->route('areas')->with('msj','Area creada exitosamente');
        }else{
            return redirect()->route('areas')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function edit($id)
    {
        $area = MAreas::where('id',$id)->first();

        return view('areas.edit',compact('area'));
    }

    public function update(Request $request)
    {
        $idarea = $request->get('idarea');

        $area = MAreas::findOrFail($idarea);
        $area->nombre = $request->get('nombre');

        if($area->update()){
            return redirect()->route('areas')->with('msj','Area actualizada exitosamente');
        }else{
            return redirect()->route('areas')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function destroy($id)
    {
        MAreas::find($id)->delete();

        return redirect()->route('areas')->with('msj','Area eliminada exitosamente');
    }

}
