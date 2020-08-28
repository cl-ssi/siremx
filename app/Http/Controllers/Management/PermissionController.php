<?php

namespace App\Http\Controllers\Management;

use App\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // Obtener listado de Permisos
    public function getlistPermissions(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
    
       $idPermission         = $request->idPermission;
       $name           = $request->name;

       $idPermission = ($idPermission == NULL) ? ($idPermission = '') : $idPermission;
       $name  = ($name == NULL) ? ($name = '') : $name;

       if(!$idPermission)
       {
         $permissions = Permission::Where('name','LIKE','%'.$name.'%')->orderBy('slug', 'asc')->get();
       }
       else{
         $permissions = Permission::Where('id','=',$idPermission)->orderBy('slug', 'asc')->get();
       }
       
       

       return $permissions->toArray();
    }

    public function setStorePermission(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

       $name   = $request->name; 
       $slug   = $request->slug;

       $name = ($name == NULL) ? ($name = '') : $name;
       $slug = ($slug == NULL) ? ($slug = '') : $slug;

       $permission = new Permission;
       $permission->name   = $name;
       $permission->slug   = $slug;
       $permission->save();

       //return $user;
    }

    public function setEditPermission(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

       $idPermission   = $request->idPermission;
       $name           = $request->name; 
       $slug           = $request->slug;

       $idPermission = ($idPermission == NULL) ? ($idPermission = 0) : $idPermission;
       $name         = ($name == NULL) ? ($name = '') : $name;
       $slug         = ($slug == NULL) ? ($slug = '') : $slug;

       $permission = Permission::find($idPermission);
       $permission->name   = $name;
       $permission->slug   = $slug;
       $permission->updated_at  = date("Y-m-d");
       $permission->save();

       //return $user;
    }
}
