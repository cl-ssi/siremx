<?php

namespace App\Http\Controllers\Exam;

use App\Exam;
use App\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function getListExams(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
    
       $cName           = $request->cName;
       $cFathers_family = $request->cFathers_family;
       $nRun            = $request->nRun;


       $cName  = ($cName == NULL) ? ($cName = '') : $cName;
       $cFathers_family = ($cFathers_family == NULL) ? ($cFathers_family = '') : $cFathers_family;
       $nRun  = ($nRun == NULL) ? ($nRun = '') : $nRun;
       

       // Se obtiene el listado de Id de pacientes conforme el request.
       $patients_list = Patient::Where('run','LIKE','%'.$nRun.'%')
                               ->Where('name','LIKE','%'.$cName.'%')
                               ->Where('fathers_family','LIKE','%'.$cFathers_family.'%')
                               ->get('id');

        
       $exams = Exam::with("patients")
                    ->whereIn('patient_id',$patients_list)
                    ->get();

       return $exams->toArray();
    }
}
