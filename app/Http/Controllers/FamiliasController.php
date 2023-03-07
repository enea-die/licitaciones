<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MFamilias;
use Illuminate\Http\Request;

class FamiliasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list_familias = MFamilias::all();

        return view('familias.index',compact('list_familias'));
    }

    public function create()
    {
        return view('familias.create');
    }

    public function store(Request $request)
    {
        $familia = new MFamilias();
        $familia->nombre = $request->get('nombre');

        if($familia->save()){
            return redirect()->route('familias')->with('msj','Familia creada exitosamente');
        }else{
            return redirect()->route('familias')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function edit($id)
    {
        $familia = MFamilias::where('id',$id)->first();

        return view('familias.edit',compact('familia'));
    }

    public function update(Request $request)
    {
        $idfamilia = $request->get('idfamilia');

        $familia = MFamilias::findOrFail($idfamilia);
        $familia->nombre = $request->get('nombre');

        if($familia->update()){
            return redirect()->route('familias')->with('msj','Familia actualizada exitosamente');
        }else{
            return redirect()->route('familias')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function destroy($id)
    {
        MFamilias::find($id)->delete();

        return redirect()->route('familias')->with('msj','Familia eliminada exitosamente');
    }

}
