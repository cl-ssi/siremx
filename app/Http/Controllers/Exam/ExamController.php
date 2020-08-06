<?php

namespace App\Http\Controllers\Exam;

use App\Exam;
use App\Patient;

use Carbon\Carbon;

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

    public function setLoadExams(Request $request)
    {
        //dd($request['exams']);
        //dd(json_decode($request->getContent(), true));
        //DB::statement('DELETE FROM cambio_turnos');

        $exams = json_decode($request->getContent(), true);
        //dd($turnos['operadores']);

        foreach($exams['exams'] as $exam) {
           
            list($run,$dv) = explode('-',str_replace(".", "", $exam['RUN']));
            //dd($run);
            $patient_id = Patient::Where('run','LIKE','%'.$run.'%')->first('id');
            //dd($patient_id->id);

            $date_exam_order = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA SOLICITUD'])));
            $date_exam_order = ($date_exam_order == NULL) ? ($date_exam_order = '') : $date_exam_order;

            $date_exam = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA TOMA'])));
            $date_exam = ($date_exam == NULL) ? ($date_exam = '') : $date_exam;

            $date_exam_reception = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA RECEPCION'])));
            $date_exam_reception = ($date_exam_reception == NULL) ? ($date_exam_reception = '') : $date_exam_reception;

            $examDet = new Exam();
            $examDet->date_exam_order      = $date_exam_order;
            $examDet->date_exam            = $date_exam;
            $examDet->date_exam_reception  = $date_exam_reception;
            $examDet->user_id              = 1;
            $examDet->patient_id           = $patient_id->id;
            $examDet->save();

        }
        
        
        return $exams;
    }
}
