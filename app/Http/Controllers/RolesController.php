<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use DB;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roles = Role::where('id','!=',1)->get();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::get()->pluck('name', 'name');

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $role = new Role;
            $role->name = $request->get('nombre');
            $role->save();

            $permissions = $request->input('permission') ? $request->input('permission') : [];
            $role->givePermissionTo($permissions);

            DB::commit();
            return redirect()->route('roles')->with('msj','Rol registrado exitosamente');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('roles')->with('msjError','Ocurrio un error al procesar el registro');
        }
    }

    public function edit($id)
    {
        $permissions = Permission::get()->pluck('name', 'name');
        $role = Role::findOrFail($id);

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $id = $request->get('idrol');

            $role = Role::findOrFail($id);
            $role->update($request->except('permission'));
            $permissions = $request->input('permission') ? $request->input('permission') : [];
            $role->syncPermissions($permissions);

            DB::commit();
            return redirect()->route('roles')->with('msj','Rol actualizado exitosamente');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('roles')->with('msjError','Ocurrio un error al procesar el registro');
        }
    }

    public function destroy($id)
    {
        $existeusuarioconesterol = 0;
        $role = Role::findOrFail($id);
        $nombre_rol = $role->name;

        $listadousers = User::all();
        if($listadousers){
            foreach ($listadousers as $user) {
                if($user->hasRole($nombre_rol)){
                    $existeusuarioconesterol++;
                }
            }
        }

        if($existeusuarioconesterol > 0){
            return redirect()->route('roles')->with('msjError','Ocurrio un error al procesar la solicitud, existen usuarios relacionados a este rol');
        }else{
            if($role->delete()){
                return redirect()->route('roles')->with('msj','Rol eliminado exitosamente');
            }else{
                return redirect()->route('roles')->with('msjError','Ocurrio un error al eliminar el rol');
            }
        }
    }

}
