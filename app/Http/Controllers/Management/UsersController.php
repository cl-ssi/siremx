<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Hash;


class UsersController extends Controller
{
    public function getListarUsuarios(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
       $cNombre  = $request->cNombre;
       $cUsuario = $request->cUsuario;
       $cCorreo  = $request->cCorreo;
       $cEstado  = $request->cEstado;

       $cNombre  = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
       $cUsuario = ($cUsuario == NULL) ? ($cUsuario = '') : $cUsuario;
       $cCorreo  = ($cCorreo == NULL) ? ($cCorreo = '') : $cCorreo;
       $cEstado  = ($cEstado == NULL) ? ($cEstado = '') : $cEstado;

       $rpta     = DB::select('call sp_Usuario_getListarUsuarios (?,?,?,?)',
       [
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

       return $rpta;
    }
}
