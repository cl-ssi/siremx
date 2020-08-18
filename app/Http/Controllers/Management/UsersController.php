<?php

namespace App\Http\Controllers\Management;

use App\User;
use App\UserRole;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Hash;



class UsersController extends Controller
{
    public function getListarUsuarios(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
       $idUser  = $request->idUser;
       $cNombre  = $request->cNombre;
       $cUsuario = $request->cUsuario;
       $cCorreo  = $request->cCorreo;
       $cEstado  = $request->cEstado;

       $idUser   = ($idUser == NULL) ? ($idUser = 0) : $idUser;
       $cNombre  = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
       $cUsuario = ($cUsuario == NULL) ? ($cUsuario = '') : $cUsuario;
       $cCorreo  = ($cCorreo == NULL) ? ($cCorreo = '') : $cCorreo;
       $cEstado  = ($cEstado == NULL) ? ($cEstado = '') : $cEstado;

       $rpta     = DB::select('call sp_Usuario_getListarUsuarios (?,?,?,?,?)',
       [
           $idUser,
           $cNombre,
           $cUsuario,
           $cCorreo,
           $cEstado
       ]);

       return $rpta;
    }

    public function setRegistrarUsuario(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
       $cNombre        = $request->cNombre;
       $cSegundoNombre = $request->cSegundoNombre;
       $cApellido      = $request->cApellido;
       $cUsuario       = $request->cUsuario;
       $cCorreo        = $request->cCorreo;
       $cContrasena    = Hash::make($request->cContrasena);
       $oFototgrafia   = $request->oFotografia;

       $cNombre        = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
       $cSegundoNombre = ($cSegundoNombre == NULL) ? ($cSegundoNombre = '') : $cSegundoNombre;
       $cApellido      = ($cApellido == NULL) ? ($cApellido = '') : $cApellido;
       $cUsuario       = ($cUsuario == NULL) ? ($cUsuario = '') : $cUsuario;
       $cCorreo        = ($cCorreo == NULL) ? ($cCorreo = '') : $cCorreo;
       $cContrasena    = ($cContrasena == NULL) ? ($cContrasena = '') : $cContrasena;
       $oFototgrafia   = ($oFototgrafia == NULL) ? ($oFototgrafia = '') : $oFototgrafia;

       $rpta     = DB::select('call sp_Usuario_setRegistrarUsuario (?,?,?,?,?,?,?)',
       [
           $cNombre,
           $cSegundoNombre,
           $cApellido,
           $cUsuario,
           $cCorreo,
           $cContrasena,
           $oFototgrafia
       ]);

       /*$user = new User($request->All());
       $user->save();*/
 
       return $rpta;
    }

    public function setEditUser(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

       $idUser         = $request->idUser; 
       $cNombre        = $request->cNombre;
       $cSegundoNombre = $request->cSegundoNombre;
       $cApellido      = $request->cApellido;
       $cUsuario       = $request->cUsuario;
       $cCorreo        = $request->cCorreo;
       $cContrasena    = $request->cContrasena;
       if($cContrasena != NULL){
        $cContrasena    = Hash::make($request->cContrasena);
       }
       $oFototgrafia   = $request->oFotografia;

       $cNombre        = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
       $cSegundoNombre = ($cSegundoNombre == NULL) ? ($cSegundoNombre = '') : $cSegundoNombre;
       $cApellido      = ($cApellido == NULL) ? ($cApellido = '') : $cApellido;
       $cUsuario       = ($cUsuario == NULL) ? ($cUsuario = '') : $cUsuario;
       $cCorreo        = ($cCorreo == NULL) ? ($cCorreo = '') : $cCorreo;
       $cContrasena    = ($cContrasena == NULL) ? ($cContrasena = '') : $cContrasena;
       $oFototgrafia   = ($oFototgrafia == NULL) ? ($oFototgrafia = '') : $oFototgrafia;

       $user = User::find($idUser);
       $user->firstname  = $cNombre;
       $user->secondname = $cSegundoNombre;
       $user->lastname   = $cApellido;
       $user->username   = $cUsuario;
       $user->email      = $cCorreo;
       $user->password   = $cContrasena;
       $user->file_id   = $oFototgrafia;
       $user->updated_by  = 1;
       $user->updated_at  = date("Y-m-d");
       $user->save();
 
       return $user;
    }

    public function setChangeUserState(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

       $idUser   = $request->idUser; 
       $state    = $request->state;

       $idUser = ($idUser == NULL) ? ($idUser = 0) : $idUser;
       $state  = ($state == NULL) ? ($state = 0) : $state;

       $user = User::find($idUser);
       $user->state   = $state;
       $user->updated_by  = 1;
       $user->updated_at  = date("Y-m-d");
       $user->save();

       //return $user;
    }

    public function setEditRoleByUser(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

       $idUser   = $request->idUser; 
       $idRole   = $request->idRole;

       $idUser  = ($idUser == NULL) ? ($idUser = '') : $idUser;
       $idRole  = ($idRole == NULL) ? ($idRole = '') : $idRole;

       $countUserRole = UserRole::Where('user_id','=','%'.$idUser.'%')->count();

       if($countUserRole > 0) {
          $userRole = UserRole::Where('user_id','=','%'.$idUser.'%');
          $userRole->role_id = $idRole;
          $userRole->updated_at  = date("Y-m-d");
          $userRole->save();
       }
       else {
          $userRole = new UserRole();
          $userRole->user_id = $idUser;
          $userRole->role_id = $idRole;
          $userRole->save();
       }
       //dd($userRole);

      return $userRole;
    }
}
