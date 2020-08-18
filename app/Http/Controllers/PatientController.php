<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Exam;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function getListarPatients(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
    
       $cName           = $request->cName;
       $cFathers_family = $request->cFathers_family;
       $nRun            = $request->nRun;


       $cName  = ($cName == NULL) ? ($cName = '') : $cName;
       $cFathers_family = ($cFathers_family == NULL) ? ($cFathers_family = '') : $cFathers_family;
       $nRun  = ($nRun == NULL) ? ($nRun = '') : $nRun;
       
 
       $patients = Patient::Where('run','LIKE','%'.$nRun.'%')
                          ->Where('name','LIKE','%'.$cName.'%')
                          ->Where('fathers_family','LIKE','%'.$cFathers_family.'%')
                          ->get();


       return $patients->toArray();
    }

    public function setStorePatient(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        
       /*$cNombre      = $request->cNombre;
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
       $oFototgrafia   = ($oFototgrafia == NULL) ? ($oFototgrafia = '') : $oFototgrafia;*/

       $patient = new Patient($request->All());

       $patient->save();

       /*$rpta     = DB::select('call sp_Usuario_setRegistrarUsuario (?,?,?,?,?,?,?)',
       [
           $cNombre,
           $cSegundoNombre,
           $cApellido,
           $cUsuario,
           $cCorreo,
           $cContrasena,
           $oFototgrafia
       ]);*/

       return $patient;
    }

    public function showPatient(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
       //dd($request);
       $idPatient  = $request->idPatient;
       $idPatient  = ($idPatient == NULL) ? ($idPatient = '') : $idPatient;
       
      
 
       $patients = Patient::with("exams")->Where('id','=',$idPatient)->first();
        

       return $patients->toArray();
    }

    public function getPatient(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
       //dd($request);
       $idPatient  = $request->idPatient;
       $idPatient  = ($idPatient == NULL) ? ($idPatient = '') : $idPatient;
       
      
 
       $patients = Patient::with("exams")->Where('run','=',$idPatient)->first();
        

       return $patients->toArray();
    }
}
