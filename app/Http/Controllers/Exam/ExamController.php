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
            //dd($dv);
            $patient_id = Patient::Where('run','LIKE','%'.$run.'%')->first('id');
            //dd($patient_id);
            
            
            if($patient_id == null)
            {

                /* separar el nombre completo en espacios */
                $tokens = explode(' ', trim($exam['NOMBRE']));
                /* arreglo donde se guardan las "palabras" del nombre */
                $names = array();
                /* palabras de apellidos (y nombres) compuetos */
                $special_tokens = array('da', 'de', 'del', 'la', 'las', 'los', 'mac', 'mc', 'van', 'von', 'y', 'i', 'san', 'santa');
                
                $prev = "";
                foreach($tokens as $token) {
                    $_token = strtolower($token);
                    if(in_array($_token, $special_tokens)) {
                        $prev .= "$token ";
                    } else {
                        $names[] = $prev. $token;
                        $prev = "";
                    }
                }
                
                $num_nombres = count($names);
                $nombres = $apellidos = "";
                switch ($num_nombres) {
                    case 0:
                        $nombres = '';
                        break;
                    case 1: 
                        $nombres = $names[0];
                        break;
                    case 2:
                        $nombres    = $names[0];
                        $apellidos  = $names[1];
                        break;
                    case 3:
                        $apellidos = $names[0] . ' ' . $names[1];
                        $nombres   = $names[2];
                    default:
                        $apellidos = $names[0] . ' '. $names[1];
                        unset($names[0]);
                        unset($names[1]);
                        
                        $nombres = implode(' ', $names);
                        break;
                }
                
                $nombres    = mb_convert_case($nombres, MB_CASE_TITLE, 'UTF-8');
                $apellidos  = mb_convert_case($apellidos, MB_CASE_TITLE, 'UTF-8');

                $apellidos  = ($apellidos == NULL) ? ($apellidos = '') : $apellidos;

                list($run,$dv) = explode('-',str_replace(".", "", trim($exam['RUN'])));

                
                $date_birthday = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA NAC'])));
                $date_birthday = ($date_birthday == NULL) ? ($date_birthday = '') : $date_birthday;
               
                
                $newPatient = new Patient();
                $newPatient->run = $run;
                $newPatient->dv = $dv;
                $newPatient->name = $nombres;
                $newPatient->fathers_family = $apellidos;
                $newPatient->mothers_family = '';
                $newPatient->birthday = $date_birthday;
                $newPatient->address = $exam['DIRECCION'];
                $newPatient->telephone = $exam['FONO'];
                $newPatient->save();

                $idInsertPatient = $newPatient->id;
             
                
            }
            else {
                $idInsertPatient = $patient_id->id;
            }
            

            $date_exam_order = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA SOLICITUD'])));
            $date_exam_order  = ($exam['FECHA SOLICITUD'] == NULL) ? ($date_exam_order = NULL) : $date_exam_order;

            $date_exam = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA TOMA'])));
            $date_exam  = ($exam['FECHA TOMA'] == NULL) ? ($date_exam = NULL) : $date_exam;

            $date_exam_reception = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA RECEPCION'])));
            $date_exam_reception  = ($exam['FECHA RECEPCION'] == NULL) ? ($date_exam_reception = NULL) : $date_exam_reception;

            $birardsMam = $exam['BIRADS MAM'];
            $birardsMam  = ($birardsMam == NULL) ? ($birardsMam = '') : $birardsMam;
            $birardsEco = $exam['BIRADS ECO'];
            $birardsEco  = ($birardsEco == NULL) ? ($birardsEco = '') : $birardsEco;

            $examDet = new Exam();
            $examDet->servicio_salud   = $exam['SERVICIO SALUD'];
            $examDet->profesional_solicita   = $exam['PROFESIONAL'];
            $examDet->establecimiento_realiza_examen   = $exam['ESTABLECIMIENTO EXAMEN'];
            $examDet->cesfam   = $exam['CESFAM'];
            $examDet->medico   = $exam['MEDICO'];
            $examDet->fonasa   = $exam['FONASA'];

            $examDet->date_exam_order      = $date_exam_order;
            $examDet->date_exam            = $date_exam;
            $examDet->date_exam_reception  = $date_exam_reception;
            $examDet->birards_mamografia   = $birardsMam;
            $examDet->birards_ecografia    = $birardsEco;
            $examDet->gender              = 'FEMENINO';
            $examDet->user_id              = 1;
            $examDet->patient_id           = $idInsertPatient;
            $examDet->save();

        }
        
        
        return $exams;
    }
}
