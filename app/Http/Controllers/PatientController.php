<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Exam;
use App\WebServices\Fonasa;
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
                         ->orderBy('id','DESC')
                         ->take(1200)->get();

      return $patients->toArray();
    }

    public function getListPatientsApi(Request $request)
    {
      if(!$request->ajax()) return redirect('/');
      return Fonasa::find((string)$request->run);
    }

    public function getPatientById(Request $request)
    {
      if(!$request->ajax()) return redirect('/');
    
      $idPatient  = $request->idPatient;
      $idPatient  = ($idPatient == NULL) ? ($idPatient = '') : $idPatient;

      $patients = Patient::Where('id','=',$idPatient)->get();

      return $patients;
    }

    public function setStorePatient(Request $request)
    {
      if(!$request->ajax()) return redirect('/');

      $patient = new Patient($request->All());

      $patient->save();
      
      return $patient;
    }

    public function setEditPatient(Request $request)
    {
      if(!$request->ajax()) return redirect('/');

      $idPatient      = $request->idPatient;
      $run            = $request->run;
      $dv             = $request->dv; 
      $name           = $request->name;
      $fathers_family = $request->fathers_family;
      $mothers_family = $request->mothers_family;
      $gender         = $request->gender;
      $birthday       = $request->birthday;
      $telephone      = $request->telephone;
      $address        = $request->address;
      

      $idPatient      = ($idPatient == NULL) ? ($idPatient = 0) : $idPatient;
      $run            = ($run == NULL) ? ($run = '') : $run;
      $dv             = ($dv == NULL) ? ($dv = '') : $dv;
      $name           = ($name == NULL) ? ($name = '') : $name;
      $fathers_family = ($fathers_family == NULL) ? ($fathers_family = '') : $fathers_family;
      $mothers_family = ($mothers_family == NULL) ? ($mothers_family = '') : $mothers_family;
      $gender         = ($gender == NULL) ? ($gender = '') : $gender;
      $birthday       = ($birthday == NULL) ? ($birthday = '') : $birthday;
      $telephone      = ($telephone == NULL) ? ($telephone = '') : $telephone;
      $address        = ($address == NULL) ? ($address = '') : $address;

      $patient = Patient::find($idPatient);
      $patient->run             = $run;
      $patient->dv              = $dv;
      $patient->name            = $name;
      $patient->fathers_family  = $fathers_family;
      $patient->mothers_family  = $mothers_family;
      $patient->gender          = $gender;
      $patient->birthday        = $birthday;
      $patient->telephone       = $telephone;
      $patient->address         = $address;
      $patient->updated_at      = date("Y-m-d");
      $patient->save();

      //return $user;
    }

    public function showPatient(Request $request)
    {
      if(!$request->ajax()) return redirect('/');

      $idPatient  = $request->idPatient;
      $idPatient  = ($idPatient == NULL) ? ($idPatient = '') : $idPatient;
      
      $patients = Patient::with("exams")->Where('id','=',$idPatient)->first();
      
      return $patients->toArray();
    }

    public function getPatient(Request $request)
    {
      if(!$request->ajax()) return redirect('/');
      
      $run  = $request->run;
      $dv  = $request->dv;

      $run  = ($run == NULL) ? ($run = '') : $run;
      $dv  = ($dv == NULL) ? ($dv = '') : $dv;
   

      $patients = Patient::with("exams")
                        ->Where('run','=',$run)
                        ->Where('dv','=',$dv)
                        ->first();
                          
      if($patients == null) {
         return response()->json([
            'code'     => 204
        ]);
      }
      else{
       return $patients;
      }
    }
}
