<?php

namespace App\Http\Controllers\Management;

use App\Role;
use App\Permission;
use App\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RoleController extends Controller
{
   // Obtener listado de Roles
    public function getListRoles(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
    
       $idRole         = $request->idRole;
       //dd($idRole);
       $name           = $request->name;
       $name  = ($name == NULL) ? ($name = '') : $name;
       
       $roles = Role::Where('name','LIKE','%'.$name.'%')
                    ->Where('id','LIKE','%'.$idRole.'%')->get();

       return $roles->toArray();
    }

    // Obtener Rol y sus Permisos
    public function getListPermissionsByRole(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
       
       $idRole         = $request->idRole;
       $idRole  = ($idRole == NULL) ? ($idRole = 0) : $idRole;

       $permission =  Permission::with(["RolePermission" => function($q){
         $q->where('role_id', '=', 11);
            }])->get();

         $sql="SELECT 
                  permiso.id
                 ,permiso.slug
                 ,permiso.name
                 ,CASE IFNULL(rol_permiso.role_id,'') WHEN '' THEN 0 ELSE 1 END checked
            FROM permissions permiso
            LEFT OUTER JOIN roles_permissions rol_permiso ON permiso.id = rol_permiso.permission_id
                                                AND rol_permiso.role_id = ".$idRole;

         $permission = DB::select($sql,array(1));

       return $permission;
    }

    // Guardar Roles y Permisos
    public function setStoreRolePermissions(Request $request)
    {
       
       if(!$request->ajax()) return redirect('/');

       $role = new Role($request->All());

         $role->save();

         $idRole = $role->id;

         $listPermissions     = $request->listPermissionsFilter;
         $listPermissionsSize = sizeof($listPermissions);
         if($listPermissionsSize > 0) {
            foreach($listPermissions as $key => $value){
               if($value['checked'] == true) {

                  $permissionsRole = new RolePermission;
                  $permissionsRole->role_id = $idRole;
                  $permissionsRole->permission_id = $value['id'];
                  $permissionsRole->save();

               }
            }
         }
       
       return $role;
    }


    // Editar Roles y Permisos
    public function setEditRolePermissions(Request $request)
    {
      //dd($request);
       
       if(!$request->ajax()) return redirect('/');
         //dd($request);
         $role = Role::find($request->input('idRole'));
         $role->name = $request->input('name');
         $role->slug = $request->input('slug');
         //$role->updated_at = $request->$name;
         $role->save();

         $PermissionsListOld = RolePermission::where('role_id', $request->input('idRole'));

         $PermissionsListOld->delete();

         $idRole = $request->input('idRole');

         $listPermissions     = $request->listPermissionsFilter;
         $listPermissionsSize = sizeof($listPermissions);
         if($listPermissionsSize > 0) {
            foreach($listPermissions as $key => $value){
               if($value['checked'] == true) {

                  $permissionsRole = new RolePermission;
                  $permissionsRole->role_id = $idRole;
                  $permissionsRole->permission_id = $value['id'];
                  $permissionsRole->save();

               }
            }
         }
       
       return $role;
    }
}
