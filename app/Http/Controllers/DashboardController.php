<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empresas;
use App\Models\EmpresasPlantas;
use App\Models\Licitaciones;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function miperfil()
    {
        return view('auth.miperfil');
    }

    public function updateDatosPerfil(Request $request)
    {
        $request->validate([
            'rut'      => ['required'],
            'name'      => ['required'],
            'ap_paterno' => ['required'],
            'ap_materno' => ['required'],
        ],[
            'rut.required' => 'El campo rut es obligatorio',
            'name.required' => 'El campo nombre es obligatorio',
            'ap_paterno.required' => 'El campo apellido paterno es obligatorio',
            'ap_materno.required' => 'El campo apellido materno es obligatorio',
        ]);

        $id_user = Auth::user()->id;
        $random = Str::random(10);

        $user = User::findOrFail($id_user);
        $user->rut = $request->get('rut');
        $user->name = $request->get('name');
        $user->ap_paterno = $request->get('ap_paterno');
        $user->ap_materno = $request->get('ap_materno');
        $user->phone = $request->get('phone');
        $user->cargo = $request->get('cargo');

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $nombrearchivoavatar = $id_user.'_'.$random.'.'.$extension;

            $path = $request->file('avatar')->storeAs(
                'avatarusers', $nombrearchivoavatar
            );

            $user->avatar = $path;
        }

        if($user->save()){
            return redirect()->route('miperfil')->with('msj','Usuario actualizado exitosamente');
        }else{
            return redirect()->route('miperfil')->with('msjError','Ocurrio un error al actualizar los datos');
        }
    }

    public function updatePasswordPerfil(Request $request)
    {
        $request->validate([
            'newpassword' => ['required','min:8','confirmed'],
        ],[
            'newpassword.required' => 'El campo contraseña es obligatorio',
            'newpassword.min' => 'El campo contraseña debe tener un minimo de 8 caracteres',
            'newpassword.confirmed' => 'Ambos campos de contraseñas deben coincidir'
        ]);

        $id_user = Auth::user()->id;

        $user = User::findOrFail($id_user);
        $user->password = bcrypt($request->get('newpassword'));

        if($user->save()){
            return redirect()->route('miperfil')->with('msj','Contraseña usuario actualizado exitosamente');
        }else{
            return redirect()->route('miperfil')->with('msjError','Ocurrio un error al actualizar la contraseña');
        }
    }

    //informes dashboard
    public function informesdashboard()
    {
        $clientes = Empresas::all();
        $plantas = EmpresasPlantas::all();

        return view('dashboard',compact('clientes','plantas'));
    }

    public function dashboardDatosAnio($year)
    {
        $totallicitacionesadjudicadas = 0;
        $totallicitacionesadjudicadasyejecutadas = 0;
        $totallicitacionesadjudicadasnoejecutadas = 0;
        $totallicitacionesejecutados = 0;
        $totallicitacionesejecutadosyfacturadas = 0;
        $totallicitacionesejecutadosnofacturadas = 0;

        $total_licitaciones_adjudicadas = Licitaciones::where('id_etapa','>',19)->where('anio_creacion',$year)->get();
        if($total_licitaciones_adjudicadas){
            foreach ($total_licitaciones_adjudicadas as $lic) {
                $totallicitacionesadjudicadas++;
                if($lic->id_etapa >= 23){
                    $totallicitacionesadjudicadasyejecutadas++;
                }else{
                    $totallicitacionesadjudicadasnoejecutadas++;
                }
            }
        }

        $total_licitaciones_ejecutadas = Licitaciones::where('id_etapa','>',22)->where('anio_creacion',$year)->get();
        if($total_licitaciones_ejecutadas){
            foreach ($total_licitaciones_ejecutadas as $lic) {
                $totallicitacionesejecutados++;
                if($lic->id_etapa >= 25){
                    $totallicitacionesejecutadosyfacturadas++;
                }else{
                    $totallicitacionesejecutadosnofacturadas++;
                }
            }
        }

        return response()->json([
            "estado"   => "success",
            "totallicitacionesadjudicadas" => $totallicitacionesadjudicadas,
            "totallicitacionesadjudicadasyejecutadas" => $totallicitacionesadjudicadasyejecutadas,
            "totallicitacionesadjudicadasnoejecutadas" => $totallicitacionesadjudicadasnoejecutadas,
            "totallicitacionesejecutados" => $totallicitacionesejecutados,
            "totallicitacionesejecutadosyfacturadas" => $totallicitacionesejecutadosyfacturadas,
            "totallicitacionesejecutadosnofacturadas" => $totallicitacionesejecutadosnofacturadas
        ]);
    }

    public function dashboardDatosMes($mes)
    {
        $totallicitacionesadjudicadas = 0;
        $totallicitacionesadjudicadasyejecutadas = 0;
        $totallicitacionesadjudicadasnoejecutadas = 0;
        $totallicitacionesejecutados = 0;
        $totallicitacionesejecutadosyfacturadas = 0;
        $totallicitacionesejecutadosnofacturadas = 0;

        $fecha_inicio = $mes.'-01';
        $fecha_fin = $mes.'-31';

        $total_licitaciones_adjudicadas = Licitaciones::where('id_etapa','>',19)->whereBetween('fecha_creacion',[$fecha_inicio, $fecha_fin])->get();
        if($total_licitaciones_adjudicadas){
            foreach ($total_licitaciones_adjudicadas as $lic) {
                $totallicitacionesadjudicadas++;
                if($lic->id_etapa >= 23){
                    $totallicitacionesadjudicadasyejecutadas++;
                }else{
                    $totallicitacionesadjudicadasnoejecutadas++;
                }
            }
        }

        $total_licitaciones_ejecutadas = Licitaciones::where('id_etapa','>',22)->whereBetween('fecha_creacion',[$fecha_inicio, $fecha_fin])->get();
        if($total_licitaciones_ejecutadas){
            foreach ($total_licitaciones_ejecutadas as $lic) {
                $totallicitacionesejecutados++;
                if($lic->id_etapa >= 25){
                    $totallicitacionesejecutadosyfacturadas++;
                }else{
                    $totallicitacionesejecutadosnofacturadas++;
                }
            }
        }

        return response()->json([
            "estado"   => "success",
            "totallicitacionesadjudicadas" => $totallicitacionesadjudicadas,
            "totallicitacionesadjudicadasyejecutadas" => $totallicitacionesadjudicadasyejecutadas,
            "totallicitacionesadjudicadasnoejecutadas" => $totallicitacionesadjudicadasnoejecutadas,
            "totallicitacionesejecutados" => $totallicitacionesejecutados,
            "totallicitacionesejecutadosyfacturadas" => $totallicitacionesejecutadosyfacturadas,
            "totallicitacionesejecutadosnofacturadas" => $totallicitacionesejecutadosnofacturadas
        ]);
    }

    public function dashboardDatosCliente($cliente)
    {
        $totallicitacionesadjudicadas = 0;
        $totallicitacionesadjudicadasyejecutadas = 0;
        $totallicitacionesadjudicadasnoejecutadas = 0;
        $totallicitacionesejecutados = 0;
        $totallicitacionesejecutadosyfacturadas = 0;
        $totallicitacionesejecutadosnofacturadas = 0;

        $total_licitaciones_adjudicadas = Licitaciones::where('id_etapa','>',19)->where('id_empresa',$cliente)->get();
        if($total_licitaciones_adjudicadas){
            foreach ($total_licitaciones_adjudicadas as $lic) {
                $totallicitacionesadjudicadas++;
                if($lic->id_etapa >= 23){
                    $totallicitacionesadjudicadasyejecutadas++;
                }else{
                    $totallicitacionesadjudicadasnoejecutadas++;
                }
            }
        }

        $total_licitaciones_ejecutadas = Licitaciones::where('id_etapa','>',22)->where('id_empresa',$cliente)->get();
        if($total_licitaciones_ejecutadas){
            foreach ($total_licitaciones_ejecutadas as $lic) {
                $totallicitacionesejecutados++;
                if($lic->id_etapa >= 25){
                    $totallicitacionesejecutadosyfacturadas++;
                }else{
                    $totallicitacionesejecutadosnofacturadas++;
                }
            }
        }

        return response()->json([
            "estado"   => "success",
            "totallicitacionesadjudicadas" => $totallicitacionesadjudicadas,
            "totallicitacionesadjudicadasyejecutadas" => $totallicitacionesadjudicadasyejecutadas,
            "totallicitacionesadjudicadasnoejecutadas" => $totallicitacionesadjudicadasnoejecutadas,
            "totallicitacionesejecutados" => $totallicitacionesejecutados,
            "totallicitacionesejecutadosyfacturadas" => $totallicitacionesejecutadosyfacturadas,
            "totallicitacionesejecutadosnofacturadas" => $totallicitacionesejecutadosnofacturadas
        ]);
    }

    public function dashboardDatosPlanta($planta)
    {
        $totallicitacionesadjudicadas = 0;
        $totallicitacionesadjudicadasyejecutadas = 0;
        $totallicitacionesadjudicadasnoejecutadas = 0;
        $totallicitacionesejecutados = 0;
        $totallicitacionesejecutadosyfacturadas = 0;
        $totallicitacionesejecutadosnofacturadas = 0;

        $total_licitaciones_adjudicadas = Licitaciones::where('id_etapa','>',19)->where('id_planta',$planta)->get();
        if($total_licitaciones_adjudicadas){
            foreach ($total_licitaciones_adjudicadas as $lic) {
                $totallicitacionesadjudicadas++;
                if($lic->id_etapa >= 23){
                    $totallicitacionesadjudicadasyejecutadas++;
                }else{
                    $totallicitacionesadjudicadasnoejecutadas++;
                }
            }
        }

        $total_licitaciones_ejecutadas = Licitaciones::where('id_etapa','>',22)->where('id_planta',$planta)->get();
        if($total_licitaciones_ejecutadas){
            foreach ($total_licitaciones_ejecutadas as $lic) {
                $totallicitacionesejecutados++;
                if($lic->id_etapa >= 25){
                    $totallicitacionesejecutadosyfacturadas++;
                }else{
                    $totallicitacionesejecutadosnofacturadas++;
                }
            }
        }

        return response()->json([
            "estado"   => "success",
            "totallicitacionesadjudicadas" => $totallicitacionesadjudicadas,
            "totallicitacionesadjudicadasyejecutadas" => $totallicitacionesadjudicadasyejecutadas,
            "totallicitacionesadjudicadasnoejecutadas" => $totallicitacionesadjudicadasnoejecutadas,
            "totallicitacionesejecutados" => $totallicitacionesejecutados,
            "totallicitacionesejecutadosyfacturadas" => $totallicitacionesejecutadosyfacturadas,
            "totallicitacionesejecutadosnofacturadas" => $totallicitacionesejecutadosnofacturadas
        ]);
    }

}
