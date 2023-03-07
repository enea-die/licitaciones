<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MGiros;
use Illuminate\Http\Request;

class GirosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list_giros = MGiros::all();

        return view('giros.index',compact('list_giros'));
    }

    public function create()
    {
        return view('giros.create');
    }

    public function store(Request $request)
    {
        $giro = new MGiros();
        $giro->nombre = $request->get('nombre');

        if($giro->save()){
            return redirect()->route('giros')->with('msj','Giro creado exitosamente');
        }else{
            return redirect()->route('giros')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function edit($id)
    {
        $giro = MGiros::where('id',$id)->first();

        return view('giros.edit',compact('giro'));
    }

    public function update(Request $request)
    {
        $idgiro = $request->get('idgiro');

        $giro = MGiros::findOrFail($idgiro);
        $giro->nombre = $request->get('nombre');

        if($giro->update()){
            return redirect()->route('giros')->with('msj','Giro actualizada exitosamente');
        }else{
            return redirect()->route('giros')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function destroy($id)
    {
        MGiros::find($id)->delete();

        return redirect()->route('giros')->with('msj','Giro eliminada exitosamente');
    }

}
