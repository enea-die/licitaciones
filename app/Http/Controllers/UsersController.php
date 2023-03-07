<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list_usuarios = User::all();

        return view('usuarios.index',compact('list_usuarios'));
    }

    public function create()
    {
        $list_roles = Role::all();

        return view('usuarios.create',compact('list_roles'));
    }

    public function store(Request $request)
    {
        $random = Str::random(10);

        $user = new User();
        $user->rut = $request->get('rut');
        $user->name = $request->get('name');
        $user->ap_paterno = $request->get('ap_paterno');
        $user->ap_materno = $request->get('ap_materno');
        $user->password = bcrypt('12345678');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->cargo = $request->get('cargo');

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $nombrearchivoavatar = $random.'.'.$extension;

            $path = $request->file('avatar')->storeAs(
                'avatarusers', $nombrearchivoavatar
            );

            $user->avatar = $path;
        }

        $user->save();

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);

        try {
            //envie de email de restaurar clave
            Password::sendResetLink(
                $request->only('email')
            );

            return redirect()->route('users')->with('msj','Usuario creado exitosamente');

        } catch (\Throwable $th) {
            return redirect()->route('users')->with('msjError','El usuario fue creado exitosamente, pero ocurrio un error al envie el link de password');
        }
    }

    public function edit($id)
    {
        $user = User::where('id',$id)->first();
        $list_roles = Role::all();

        return view('usuarios.edit',compact('user','list_roles'));
    }

    public function update(Request $request)
    {
        $random = Str::random(10);
        $iduser = $request->get('iduser');

        $user = User::findOrFail($iduser);
        $user->rut = $request->get('rut');
        $user->name = $request->get('name');
        $user->ap_paterno = $request->get('ap_paterno');
        $user->ap_materno = $request->get('ap_materno');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->cargo = $request->get('cargo');

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $nombrearchivoavatar = $iduser.'_'.$random.'.'.$extension;

            $path = $request->file('avatar')->storeAs(
                'avatarusers', $nombrearchivoavatar
            );

            $user->avatar = $path;
        }

        $user->update();

        //eliminar roles antiguo
        $list_roles = Role::all();
        if($list_roles){
            foreach ($list_roles as $rol) {
                $user->removeRole($rol->name);
            }
        }

        if($request->roles){
            //asignar nuevos roles
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->assignRole($roles);
        }

        return redirect()->route('users')->with('msj','Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('users')->with('msj','Usuario eliminado exitosamente');
    }

}
