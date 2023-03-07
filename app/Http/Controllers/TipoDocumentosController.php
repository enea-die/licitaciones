<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoDocumentos;
use Illuminate\Http\Request;

class TipoDocumentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list_tipo_documentos = TipoDocumentos::all();

        return view('tipodocumentos.index',compact('list_tipo_documentos'));
    }

    public function create()
    {
        return view('tipodocumentos.create');
    }

    public function store(Request $request)
    {
        $tipo = new TipoDocumentos();
        $tipo->nombre = $request->get('nombre');

        if($tipo->save()){
            return redirect()->route('tipodocumentos')->with('msj','Tipo documento de pago creado exitosamente');
        }else{
            return redirect()->route('tipodocumentos')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function edit($id)
    {
        $tipo = TipoDocumentos::where('id',$id)->first();

        return view('tipodocumentos.edit',compact('tipo'));
    }

    public function update(Request $request)
    {
        $idtipo = $request->get('idtipo');

        $tipo = TipoDocumentos::findOrFail($idtipo);
        $tipo->nombre = $request->get('nombre');

        if($tipo->update()){
            return redirect()->route('tipodocumentos')->with('msj','Tipo documento de pago actualizado exitosamente');
        }else{
            return redirect()->route('tipodocumentos')->with('msjError','Ocurrio un error al procesar la petición');
        }
    }

    public function destroy($id)
    {
        TipoDocumentos::find($id)->delete();

        return redirect()->route('tipodocumentos')->with('msj','Tipo documento de pago eliminado exitosamente');
    }

}
