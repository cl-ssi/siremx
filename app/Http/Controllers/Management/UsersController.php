<?php

namespace App\Http\Controllers\Management;

use App\User;
use App\UserRole;
use App\UserPermission;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

       $sql="
            SELECT usuario.id,
            CONCAT(usuario.firstname,' ',usuario.secondname,' ',usuario.lastname) AS fullname,
            usuario.firstname,
            usuario.secondname,
            usuario.lastname,
            usuario.username,
            usuario.run,
            usuario.dv,
            usuario.commune_id,
            usuario.establishment_id,
            CO.name AS commune,
            ES.alias AS establishment,
            IFNULL(usuario.email,'') AS email,
            CASE IFNULL(usuario.state,'') WHEN 'A' THEN 'ACTIVO'
                                                   ELSE 'INACTIVO'
                                                   END AS state_alias,
            IFNULL(usuario.state,'') AS state,
            IFNULL(image.path,'')    AS profile_image
         FROM users usuario
         LEFT OUTER JOIN files image ON usuario.file_id = image.id
         LEFT JOIN communes CO  ON usuario.commune_id = CO.id
         LEFT JOIN establishments ES  ON usuario.establishment_id = ES.id
         WHERE 1=1
            AND CONCAT(usuario.firstname,' ',usuario.secondname,' ',usuario.lastname) LIKE ('%".$cNombre."%')
            AND (usuario.username) LIKE ('%".$cUsuario."%')
            AND (usuario.email) LIKE ('%".$cCorreo."%')
            AND (usuario.state = '".$cEstado."' OR '".$cEstado."' = '')
            AND (usuario.id = '".$idUser."' OR '".$idUser."' = 0)
         ORDER BY usuario.id DESC";
      
       $rpta = DB::select($sql);

      return $rpta;
    }

    public function setRegistrarUsuario(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
       $run            = $request->run;
       $dv             = $request->dv;
       $cNombre        = $request->cNombre;
       $cSegundoNombre = $request->cSegundoNombre;
       $cApellido      = $request->cApellido;
       $cUsuario       = $request->cUsuario;
       $cCorreo        = $request->cCorreo;
       $cContrasena    = Hash::make($request->cContrasena);
       $oFototgrafia   = $request->oFotografia;

       $run            = ($run == NULL) ? ($run = '') : $run;
       $dv             = ($dv == NULL) ? ($dv = '') : $dv;
       $cNombre        = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
       $cSegundoNombre = ($cSegundoNombre == NULL) ? ($cSegundoNombre = '') : $cSegundoNombre;
       $cApellido      = ($cApellido == NULL) ? ($cApellido = '') : $cApellido;
       $cUsuario       = ($cUsuario == NULL) ? ($cUsuario = '') : $cUsuario;
       $cCorreo        = ($cCorreo == NULL) ? ($cCorreo = '') : $cCorreo;
       $cContrasena    = ($cContrasena == NULL) ? ($cContrasena = '') : $cContrasena;
       $oFototgrafia   = ($oFototgrafia == NULL) ? ($oFototgrafia = NULL) : $oFototgrafia;

       $user = new User;
       $user->run = $run;
       $user->dv = $dv;
       $user->firstname = $cNombre;
       $user->secondname = $cSegundoNombre;
       $user->lastname = $cApellido;
       $user->username = $cUsuario;
       $user->email = $cCorreo;
       $user->password = $cContrasena;
       $user->file_id = $oFototgrafia;
       $user->state = 'A';
       $user->created_by = 1;
       $user->updated_by = 1;

       $user->save();

       return $user->id;
    }

    public function setEditUser(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

       $idUser         = $request->idUser;
       $run            = $request->run;
       $dv             = $request->dv;
       $cNombre        = $request->cNombre;
       $cSegundoNombre = $request->cSegundoNombre;
       $cApellido      = $request->cApellido;
       $cUsuario       = $request->cUsuario;
       $commune        = $request->commune;
       $establishment  = $request->establishment;
       $cCorreo        = $request->cCorreo;
       $cContrasena    = $request->cContrasena;
       if($cContrasena != NULL){
        $cContrasena    = Hash::make($request->cContrasena);
       }
       $oFototgrafia   = $request->oFotografia;
       $user = User::find($idUser);

       $cNombre        = ($cNombre == NULL) ? ($cNombre = '') : $cNombre;
       $run            = ($run == NULL) ? ($run = '') : $run;
       $dv             = ($dv == NULL) ? ($dv = '') : $dv;
       $cSegundoNombre = ($cSegundoNombre == NULL) ? ($cSegundoNombre = '') : $cSegundoNombre;
       $cApellido      = ($cApellido == NULL) ? ($cApellido = '') : $cApellido;
       $cUsuario       = ($cUsuario == NULL) ? ($cUsuario = '') : $cUsuario;
       $commune        = ($commune == NULL) ? ($commune = NULL) : $commune;
       $establishment  = ($establishment == NULL) ? ($establishment = NULL) : $establishment;
       $cCorreo        = ($cCorreo == NULL) ? ($cCorreo = '') : $cCorreo;
       $cContrasena    = ($cContrasena == NULL) ? ($cContrasena = $user->password) : $cContrasena;
       $oFototgrafia   = ($oFototgrafia == NULL) ? ($oFototgrafia = $user->file_id ) : $oFototgrafia;

  
       $user->firstname         = $cNombre;
       $user->run               = $run;
       $user->dv                = $dv;
       $user->secondname        = $cSegundoNombre;
       $user->lastname          = $cApellido;
       $user->username          = $cUsuario;
       $user->commune_id        = $commune;
       $user->establishment_id  = $establishment;
       $user->email             = $cCorreo;
       $user->password          = $cContrasena;
       $user->file_id           = $oFototgrafia;
       $user->updated_by        = 1;
       $user->updated_at        = date("Y-m-d");
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

       $countUserRole = UserRole::Where('user_id','=',$idUser)->count();

       if($countUserRole > 0) {
          $userRole = UserRole::Where('user_id','=',$idUser)->first();
          $userRole->role_id = $idRole;
          $userRole->save();
       }
       else {
          $userRole = new UserRole();
          $userRole->user_id = $idUser;
          $userRole->role_id = $idRole;
          $userRole->save();
       }
      return $userRole;
    }

    public function getRolByUser(Request $request)
    {
      if(!$request->ajax()) return redirect('/');

      $idUser   = $request->idUser; 

      $idUser  = ($idUser == NULL) ? ($idUser = 0) : $idUser;

      $sql="SELECT UR.role_id,
                   RO.name
            FROM users_roles UR
            INNER JOIN roles RO ON UR.role_id = RO.id
            WHERE UR.user_id = ".$idUser;

      $roleId = DB::select($sql);

      return $roleId;
    }

    public function getListPermissionByRoleAssigned(Request $request)
    {
      if(!$request->ajax()) return redirect('/');

       $idUser   = $request->idUser; 

       $idUser  = ($idUser == NULL) ? ($idUser = 0) : $idUser;

       $sql="SELECT P.id,
                    P.name,
                    P.slug
            FROM users_roles UR
            INNER JOIN roles_permissions RP ON UR.role_id = RP.role_id
            INNER JOIN permissions P ON RP.permission_id = P.id
            WHERE UR.user_id = ".$idUser;

      $rpta = DB::select($sql);

      return $rpta;
    }

    public function getListPermissionsByUser(Request $request)
    {
      if(!$request->ajax()) return redirect('/');

       $idUser   = $request->idUser; 

       $idUser  = ($idUser == NULL) ? ($idUser = 0) : $idUser;

       $sql="SELECT 
                  P.id
                 ,P.slug
                 ,P.name
                 ,CASE IFNULL(UP.user_id,'') WHEN '' THEN 0 ELSE 1 END checked
            FROM permissions P
            LEFT OUTER JOIN users_permissions UP ON P.id = UP.permission_id
                                                AND UP.user_id = ".$idUser;

      $rpta = DB::select($sql);

      return $rpta;
    }

    public function setStoreRolePermissionsByUser(Request $request)
    {
      if(!$request->ajax()) return redirect('/');

       $idUser   = $request->idUser; 

       $idUser  = ($idUser == NULL) ? ($idUser = 0) : $idUser;

         $PermissionsListOld = UserPermission::where('user_id', $request->input('idUser'));

         $PermissionsListOld->delete();

         $idUser = $request->input('idUser');

         $listPermissions     = $request->listPermissionsFilter;
         $listPermissionsSize = sizeof($listPermissions);
         if($listPermissionsSize > 0) {
            foreach($listPermissions as $key => $value){
               if($value['checked'] == true) {

                  $permissionsRole = new UserPermission;
                  $permissionsRole->user_id = $idUser;
                  $permissionsRole->permission_id = $value['id'];
                  $permissionsRole->save();

               }
            }
         }
       
       return $permissionsRole;
    }

    public function getListRolePermissionsByUser(Request $request)
    {
      if(!$request->ajax()) return redirect('/');

       $idUser   = $request->idUser; 

       $idUser  = ($idUser == NULL) ? ($idUser = 0) : $idUser;

       if(!$idUser) {
          $idUser = Auth::id();
       }

       $sql="SELECT 
                      P.id
                     ,P.slug
                     ,P.name
               FROM permissions P
              INNER JOIN users_permissions UP ON P.id = UP.permission_id
                                                   AND UP.user_id = ".$idUser."
            UNION
            SELECT  P.id
                   ,P.slug
                   ,P.name
             FROM users_roles UR
            INNER JOIN roles_permissions RP ON UR.role_id = RP.role_id
            INNER JOIN permissions P ON RP.permission_id = P.id
            WHERE UR.user_id = ".$idUser;

      $rpta = DB::select($sql);

      return $rpta;
    }
}
