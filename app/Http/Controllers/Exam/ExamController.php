<?php

namespace App\Http\Controllers\Exam;

use App\Exam;
use App\Patient;
use App\Load;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class ExamController extends Controller
{
    // Devuelve el examen por id
    public function getExamById(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
    
       $idExam  = $request->idExam;
       $idExam  = ($idExam == NULL) ? ($idExam = '') : $idExam;
       
       $exam = Exam::Where('id','=',$idExam)->get();

       return $exam;
    }

    // Función para editar examen 
    public function setEditExam(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $idExam                = $request->idExam;
        $servicioSalud         = $request->servicioSalud;
        $commune               = $request->commune; 
        $establishmentRequest  = $request->establishmentRequest;
        $date_exam_order       = $request->date_exam_order;
        $establishmentExam     = $request->establishmentExam;
        $doctor                = $request->doctor;
        $date_exam             = $request->date_exam;
        $establishmentExamDerivation = $request->establishmentExamDerivation;
        $derivation            = $request->derivation;
        $examType              = $request->examType;
        $birards               = $request->birards;
        $professional          = $request->professional;
        $listBIRADSEcoMam      = $request->listBIRADSEcoMam;
        $date_exam_reception   = $request->date_exam_reception;
        $diagnostic            = $request->diagnostic;

        // Dependiendo del tipo de examen
        // actualiza el resultado birads en
        // la columna correspondiente de la bd mam, eco, pro
        if($examType == 'mam'){
            $birards_mam = $birards;
        }
        else {
            $birards_mam = NULL;
        }
        if($examType == 'eco'){
            $birards_eco = $birards;
        } 
        else {
            $birards_eco = NULL;
        } 
        if($examType == 'pro'){
            $birards_pro = $birards;
        }
        else {
            $birards_pro = NULL;
        }

        $idExam               = ($idExam == NULL) ? ($idExam = 0) : $idExam;
        $servicioSalud        = ($servicioSalud == NULL) ? ($servicioSalud = '') : $servicioSalud;
        $commune              = ($commune == NULL) ? ($commune = '') : $commune;
        $establishmentRequest = ($establishmentRequest == NULL) ? ($establishmentRequest = '') : $establishmentRequest;
        $date_exam_order      = ($date_exam_order == NULL) ? ($date_exam_order = NULL) : $date_exam_order;
        $establishmentExam    = ($establishmentExam == NULL) ? ($establishmentExam = '') : $establishmentExam;
        $doctor               = ($doctor == NULL) ? ($doctor = '') : $doctor;
        $date_exam            = ($date_exam == NULL) ? ($date_exam = NULL) : $date_exam;
        $establishmentExamDerivation = ($establishmentExamDerivation == NULL) ? ($establishmentExamDerivation = NULL) : $establishmentExamDerivation;
        $derivation           = ($derivation == NULL) ? ($derivation = '') : $derivation;
        $date_exam_reception  = ($date_exam_reception ==  NULL) ? ($date_exam_reception = NULL) : $date_exam_reception;
        $diagnostic           = ($diagnostic == NULL) ? ($diagnostic = '') : $diagnostic;
        $professional         = ($professional == NULL) ? ($professional = '') : $professional;

        $exam = Exam::find($idExam);
        $exam->servicio_salud                   = $servicioSalud;
        $exam->comuna                           = $commune;
        $exam->cesfam                           = $establishmentRequest;
        $exam->date_exam_order                  = $date_exam_order;
        $exam->establecimiento_realiza_examen   = $establishmentExam;
        $exam->profesional_solicita             = $professional;
        $exam->medico                           = $doctor;
        $exam->date_exam                        = $date_exam;
        $exam->establecimiento_deriva_examen    = $establishmentExamDerivation;
        $exam->derivation_reason                = $derivation;
        $exam->birards_mamografia               = $birards_mam;
        $exam->birards_ecografia                = $birards_eco;
        $exam->birards_proyeccion               = $birards_pro;
        $exam->date_exam_reception              = $date_exam_reception;
        $exam->diagnostico                      = $diagnostic;

        // Si se adjunta informe de resultado de examen
        // se elimina el adjunto anterior y se vuelve
        // a asignar a la columna de bd path y filename
        if($request->hasFile('file')){
            $file                  = $request->file;
            $flag                  = $idExam;
            $filename              = $file->getClientOriginalName();
            $fileserver            = $flag.'_'.$filename;
            Storage::disk('gcs')->delete('siremx/reports/'.$fileserver);
            $exam->path                 = 'siremx/reports/'.$fileserver;
            $exam->filename             = $filename;
            Storage::disk('gcs')->putFileAs('siremx/reports',$file, $fileserver);
        }
        else {
            $exam->path                 = $exam->path;
            $exam->filename             = $exam->filename;
        }

        $exam->save();

        return $exam;
    }

    // Función para obtener listado de exámenes
    public function getListExams(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
    
        $cName              = $request->cName;
        $cFathers_family    = $request->cFathers_family;
        $nRun               = $request->nRun;
        $code_deis_request  = $request->codeDeisRequest;


        $cName           = ($cName == NULL) ? ($cName = '') : $cName;
        $cFathers_family = ($cFathers_family == NULL) ? ($cFathers_family = '') : $cFathers_family;
        $nRun            = ($nRun == NULL) ? ($nRun = '') : $nRun;

        if($code_deis_request == NULL) {
            if(Auth::user()->establishment_id){
              $code_deis_request = Auth::user()->establishment_id;//"AND T0.cesfam = ".Auth::user()->establishment_id;
            }
            else {
              $code_deis_request = '';
            }
        }
       
        if($cName || $cFathers_family || $nRun ){

            $patients_list = Patient::Where('run','LIKE','%'.$nRun.'%')
                                    ->Where('name','LIKE','%'.$cName.'%')
                                    ->Where('fathers_family','LIKE','%'.$cFathers_family.'%')
                                    ->get('id');
            

            $exams = Exam::select(
                                  'exams.id'
                                 ,'exams.date_exam'
                                 ,'exams.date_exam'
                                 ,'exams.date_exam_reception'
                                 ,'exams.exam_type'
                                 ,'exams.birards_mamografia'
                                 ,'exams.birards_ecografia'
                                 ,'exams.birards_proyeccion'
                                 ,'exams.user_id'
                                 ,'exams.path'
                                 ,'T1.run'
                                 ,'T1.dv'
                                 ,'T1.run'
                                 ,'T1.name'
                                 ,'T1.fathers_family'
                                 ,'T1.mothers_family'
                                 ,'T1.birthday'
                                 ,'T2.alias AS establishment_origin'
                                 ,'T3.name AS commune'
                                 ,'T4.firstname'
                                 ,'T4.secondname'
                                 ,'T4.lastname')
                    ->leftjoin('patients AS T1', 'exams.patient_id', '=', 'T1.id')
                    ->leftjoin('establishments AS T2', 'exams.cesfam', '=', 'T2.new_code_deis')
                    ->leftjoin('communes AS T3', 'exams.comuna', '=', 'T3.code_deis')
                    ->leftjoin('users AS T4', 'exams.user_id', '=', 'T4.id')
                    ->whereIn('patient_id',$patients_list)
                    ->get();
        }
        else {
            $exams = Exam::select(
                                 'exams.id'
                                ,'exams.date_exam'
                                ,'exams.date_exam'
                                ,'exams.date_exam_reception'
                                ,'exams.exam_type'
                                ,'exams.user_id'
                                ,'T1.run'
                                ,'T1.dv'
                                ,'T1.run'
                                ,'T1.name'
                                ,'T1.fathers_family'
                                ,'T1.mothers_family'
                                ,'T1.birthday'
                                ,'T2.alias AS establishment_origin'
                                ,'T3.name AS commune'
                                ,'T4.firstname'
                                ,'T4.secondname'
                                ,'T4.lastname')
                    ->leftjoin('patients AS T1', 'exams.patient_id', '=', 'T1.id')
                    ->leftjoin('establishments AS T2', 'exams.cesfam', '=', 'T2.new_code_deis')
                    ->leftjoin('communes AS T3', 'exams.comuna', '=', 'T3.code_deis')
                    ->leftjoin('users AS T4', 'exams.user_id', '=', 'T4.id')
                    ->whereNull('date_exam_reception')
                    ->Where('load_source','app')
                    ->Where('cesfam','LIKE','%'.$code_deis_request.'%')
                    ->orderBy('id','DESC')
                    ->take(1200)->get();
        }
     
       return $exams;
    }

    // Función para cargar examen creado desde
    // la plataforma siremx "Hito 1"
    public function setStoreExam(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $idPatient             = $request->idPatient;
        $run                   = $request->run;
        $name                  = $request->name;
        $fathers_family        = $request->fathers_family;
        $mothers_family        = $request->mothers_family;
        $gender                = $request->gender;
        $birthday              = $request->birthday;
        $telephone             = $request->telephone;
        $servicioSalud         = $request->servicioSalud;
        $commune               = $request->commune;
        $establishmentRequest  = $request->establishmentRequest;
        $professional          = $request->professional;
        $date_exam_order       = $request->date_exam_order;
        $establishmentExam     = $request->establishmentExam;
        $establishmentExamDerivation = $request->establishmentExamDerivation;
        $doctor                = $request->doctor;
        $date_exam             = $request->date_exam;
        $derivation            = $request->derivation;
        $examType              = $request->examType;
        
        $exams = new Exam();
        $exams->servicio_salud                 = $servicioSalud;
        $exams->profesional_solicita           = $professional;
        $exams->comuna                         = $commune;
        $exams->establecimiento_realiza_examen = $establishmentExam;
        $exams->cesfam                         = $establishmentRequest;
        $exams->medico                         = $doctor;
        $exams->date_exam_order                = $date_exam_order;
        $exams->date_exam                      = $date_exam;
        $exams->establecimiento_deriva_examen  = $establishmentExamDerivation;
        $exams->derivation_reason              = $derivation;
        $exams->exam_type                      = $examType;
        $exams->load_source                    = 'app';
        $exams->load_id                        = 0;
        $exams->user_id                        = Auth::id();
        $exams->patient_id                     = $idPatient;
        $exams->save();

       return $exams->toArray();
    }

    // Función para cargar examen masivamente
    // desde un archivo excel, opción "Carga Masiva"
    public function setLoadExams(Request $request)
    {

        if(!$request->ajax()) return redirect('/');

        $title        = $request->title;
        $description  = $request->description;
        $exams        = json_decode($request->getContent(), true);

        $fields = array('SERVICIO SALUD', 'FECHA TOMA', 'FECHA SOLICITUD', 'FECHA RECEPCION', 'NOMBRES', 'APELLIDO PATERNO', 'APELLIDO MATERNO', 'RUN',
                        'FECHA NAC', 'DIRECCION', 'FONO', 'GENERO', 'PROFESIONAL', 'DIAGNOSTICO', 'ESTABLECIMIENTO EXAMEN', 'ESTABLECIMIENTO SOLICITA',
                        'CESFAM', 'MEDICO', 'FONASA', 'MDERIVACION', 'BIRADS MAM', 'BIRADS ECO', 'BIRADS PRO', 'COMUNA');

        foreach($fields as $field){
            if(!isset($exams['exams'][0][$field]))
                return response()->json([
                    'error' => 'No se encontró campo '. $field . ' en el proceso de carga del archivo xlsx'], 400);
        }

        $load = new Load();
        $load->title       = $title;
        $load->description = $description;
        $load->save();
        
        // Se recorre cada una de las filas del archivo cargado
        foreach($exams['exams'] as $exam) {

            // Se separa el rut parte numérica y digito verificador
            list($run,$dv) = array_pad(explode('-',str_replace(".", "",$exam['RUN'])),2,null);
            // Se busca por cada registro si el paciente existe en la bd
            $patient_id = Patient::Where('run','LIKE','%'.$run.'%')->first('id');
            
            // Si el paciente no existe se inserta nuevo registro
            // y se obtiene id para asignarlo al registro de examen
            if($patient_id == null)
            {
                // // Separar el nombre completo en espacios
                // $tokens = explode(' ', trim($exam['NOMBRE']));
                // // Arreglo donde se guardan las "palabras" del nombre
                // $names = array();
                // // Palabras de apellidos (y nombres) compuetos
                // $special_tokens = array('da', 'de', 'del', 'la', 'las', 'los', 'mac', 'mc', 'van', 'von', 'y', 'i', 'san', 'santa');
                
                // $prev = "";
                // foreach($tokens as $token) {
                //     $_token = strtolower($token);
                //     if(in_array($_token, $special_tokens)) {
                //         $prev .= "$token ";
                //     } else {
                //         $names[] = $prev. $token;
                //         $prev = "";
                //     }
                // }
                
                // $num_nombres = count($names);
                // $nombres = $apellidos = "";
                // switch ($num_nombres) {
                //     case 0:
                //         $nombres = '';
                //         break;
                //     case 1: 
                //         $nombres = $names[0];
                //         break;
                //     case 2:
                //         $nombres    = $names[0];
                //         $apellidos  = $names[1];
                //         break;
                //     case 3:
                //         $apellidos = $names[1] . ' ' . $names[2];
                //         $nombres   = $names[0];
                //     default:
                //         $apellidos = $names[1] . ' '. $names[2];
                //         $nombres   = $names[0];
                //         break;
                // }
                
                // $nombres    = mb_convert_case($nombres, MB_CASE_TITLE, 'UTF-8');
                // $apellidos  = mb_convert_case($apellidos, MB_CASE_TITLE, 'UTF-8');
                // $apellidos  = ($apellidos == NULL) ? ($apellidos = '') : $apellidos;

                $nombres          = strtolower(trim($exam['NOMBRES']));
                $nombres          = mb_convert_case($nombres, MB_CASE_TITLE, 'UTF-8');
                $nombres          = ($nombres == NULL) ? ($nombres = '') : $nombres;
                $apellido_paterno = strtolower(trim($exam['APELLIDO PATERNO']));
                $apellido_paterno = mb_convert_case($apellido_paterno, MB_CASE_TITLE, 'UTF-8');
                $apellido_paterno = ($apellido_paterno == NULL) ? ($apellido_paterno = '') : $apellido_paterno;
                $apellido_materno = strtolower(trim($exam['APELLIDO MATERNO']));
                $apellido_materno = mb_convert_case($apellido_materno, MB_CASE_TITLE, 'UTF-8');
                $apellido_materno = ($apellido_materno == NULL) ? ($apellido_materno = '') : $apellido_materno;

                list($run,$dv) = array_pad(explode('-',str_replace(".", "",$exam['RUN'])),2,null);
     
                $date_birthday = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA NAC'])));
                $date_birthday = ($date_birthday == NULL) ? ($date_birthday = '') : $date_birthday;

                $gender = $exam['GENERO'];

                if($gender == 'F'){
                    $gender = 'female';
                }
                else if($gender == 'M'){
                    $gender = 'male';
                }
                else{
                    $gender = 'unknown';
                }
               
                
                $newPatient = new Patient();
                $newPatient->run            = $run;
                $newPatient->dv             = $dv;
                $newPatient->name           = $nombres;
                $newPatient->fathers_family = $apellido_paterno;
                $newPatient->mothers_family = $apellido_materno;
                $newPatient->birthday       = $date_birthday;
                $newPatient->address        = $exam['DIRECCION'];
                $newPatient->telephone      = $exam['FONO'];
                $newPatient->gender         = $gender;
                $newPatient->save();

                $idInsertPatient = $newPatient->id;
             
            }
            else {
                $idInsertPatient = $patient_id->id;
            }
            

            $date_exam_order = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA SOLICITUD'])));
            $date_exam_order = ($exam['FECHA SOLICITUD'] == NULL) ? ($date_exam_order = NULL) : $date_exam_order;

            $date_exam = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA TOMA'])));
            $date_exam = ($exam['FECHA TOMA'] == NULL) ? ($date_exam = NULL) : $date_exam;

            $date_exam_reception = date('Y-m-d',strtotime(str_replace('/', '-',$exam['FECHA RECEPCION'])));
            $date_exam_reception = ($exam['FECHA RECEPCION'] == NULL) ? ($date_exam_reception = NULL) : $date_exam_reception;

            $commune = $exam['COMUNA'];
            $commune = ($commune == NULL) ? ($commune = NULL) : $commune;

            $birardsMam = $exam['BIRADS MAM'] ?? NULL;
            $birardsEco = $exam['BIRADS ECO'] ?? NULL;
            $birardsPro = $exam['BIRADS PRO'] ?? NULL;

            if($birardsMam != NULL)
            {
                $examType = 'mam';
            }
            elseif($birardsEco != NULL)
            {
                $examType = 'eco';
            }
            elseif($birardsPro != NULL)
            {
                $examType = 'pro';
            }
            else
            {
                $examType = NULL;
            }

            $mDerivation = $exam['MDERIVACION'];
            $mDerivation  = ($mDerivation == NULL) ? ($mDerivation = '') : $mDerivation;

            $diagnostic = $exam['DIAGNOSTICO'];
            $diagnostic  = ($diagnostic == NULL) ? ($diagnostic = '') : $diagnostic;
            
            

            $examDet = new Exam();
            $examDet->servicio_salud   = $exam['SERVICIO SALUD'];
            $examDet->comuna   = $commune;
            $examDet->profesional_solicita   = $exam['PROFESIONAL'];
            $examDet->establecimiento_realiza_examen   = $exam['ESTABLECIMIENTO EXAMEN'];
            $examDet->establecimiento_deriva_examen   = $exam['ESTABLECIMIENTO SOLICITA'];
            $examDet->cesfam   = $exam['CESFAM'];
            $examDet->medico   = $exam['MEDICO'];
            $examDet->fonasa   = $exam['FONASA'];

            $examDet->date_exam_order      = $date_exam_order;
            $examDet->date_exam            = $date_exam;
            $examDet->diagnostico          = $diagnostic;
            $examDet->date_exam_reception  = $date_exam_reception;
            $examDet->exam_type            = $examType;
            $examDet->birards_mamografia   = $birardsMam;
            $examDet->birards_ecografia    = $birardsEco;
            $examDet->birards_proyeccion   = $birardsPro;
            $examDet->derivation_reason    = $mDerivation;
            $examDet->load_source          = 'excel';
            $examDet->load_id              = $load->id;
            $examDet->user_id              = Auth::id();
            $examDet->patient_id           = $idInsertPatient;
            $examDet->save();

        }
         
        return $exams;
    }

    // Función para cargar examen masivamente
    // desde un archivo excel, opción "Carga parametro SIGTE_ID en los examenes"
    public function setLoadSigteID(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $exams = json_decode($request->getContent(), true);

        if(!isset($exams['exams'][0]['SIGTE_ID']))
            return response()->json([
                'error' => 'No se encontró campo SIGTE_ID en el proceso de carga del archivo xlsx'], 400);

        // Se recorre cada una de las filas del archivo cargado
        foreach($exams['exams'] as $exam) {
            $id_local = $exam['ID_LOCAL'];
            $sigte_id = $exam['SIGTE_ID'];
            if($id_local && $sigte_id){
                $result = Exam::find($id_local);
                if($result){
                    $result->sigte_id = $sigte_id;
                    $result->save();
                }
            }
        }

        return $exams;
    }

    public function setDeleteExam(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $idExam = $request->idExam;
        $idExam = ($idExam == NULL) ? ($idExam = 0) : $idExam;

        $exam = Exam::find($idExam);
        $exam ->delete(); 

        return $exam;
    }

    public function downloadExamById(Exam $exam)
    {
        return Storage::disk('gcs')->response($exam->path, mb_convert_encoding($exam->filename,'ASCII'));
    }
}
