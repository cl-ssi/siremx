<?php

namespace App\Http\Controllers\Report;

use App\Exam;
use App\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{

  public function getPatientHistoryClinical(Request $request)
  {
    if(!$request->ajax()) return redirect('/');

    $run = $request->run;
    $run  = ($run == NULL) ? ($run = '') : $run;
    
    list($run,$dv) = array_pad(explode('-',str_replace(".", "", $run)),2,null);

     $sql=" SELECT 
                  T1.run,
                  T1.dv,
                  T1.name,
                  T1.fathers_family,
                  T1.mothers_family,
                  T1.gender,
                  T1.telephone,
                  DATE_FORMAT(T1.birthday, '%d/%m/%Y') AS birthday,
                  YEAR(CURDATE())-YEAR(T1.birthday) AS age,
                  T1.address,
                  DATE_FORMAT(T0.date_exam_order, '%d/%m/%Y') AS date_exam_order,
                  DATE_FORMAT(T0.date_exam, '%d/%m/%Y') AS date_exam,
                  DATE_FORMAT(T0.date_exam_reception, '%d/%m/%Y') AS date_exam_reception,
                  T0.birards_mamografia,
                  T0.birards_ecografia,
                  T0.birards_proyeccion,
                  T0.diagnostico,
                  ES2.alias AS establecimiento_realiza_examen,
                  T0.profesional_solicita,
                  T0.medico,
                  T0.servicio_salud,
                  T0.path,
                  CO.name AS comuna_name,
                  ES.alias AS cesfam_name
             FROM exams T0
             LEFT JOIN patients T1 ON T0.patient_id = T1.id
             LEFT JOIN communes CO  ON T0.comuna = CO.code_deis
             LEFT JOIN establishments ES  ON T0.cesfam = ES.new_code_deis
             LEFT JOIN establishments ES2  ON T0.establecimiento_realiza_examen = ES2.new_code_deis
             WHERE T1.run = '".$run."' 
             ORDER BY T0.id DESC ";

     $patient = DB::select($sql,array(1));

     return $patient;
  }
    
  public function getPatientHistory(Request $request)
  {
    if(!$request->ajax()) return redirect('/');

    $run = $request->run;
    $code_deis          = $request->codeDeis;
    $code_deis_request  = $request->codeDeisRequest;
    $commune            = $request->commune;

    $run  = ($run == NULL) ? ($run = '') : $run;
    $code_deis  = ($code_deis == NULL) ? ($code_deis = '') : "AND T0.establecimiento_realiza_examen = ".$code_deis;
    if($code_deis_request == NULL) {
        if(Auth::user()->establishment_id){
          $code_deis_request = "AND T0.cesfam = ".Auth::user()->establishment_id;
        }
        else {
          $code_deis_request = '';
        }
    }
    else {
        $code_deis_request = "AND T0.cesfam = ".$code_deis_request;
    }

    if($commune == NULL) {
        if(Auth::user()->commune_id){
          $commune = "AND T0.comuna = ".Auth::user()->commune_id;
        }
        else {
          $commune = '';
        }
      }
      else {
        $commune = "AND T0.comuna = ".$commune;
      }

    list($run,$dv) = array_pad(explode('-',str_replace(".", "", $run)),2,null);

    $sql=" SELECT 
                T1.run,
                T1.dv,
                T1.name,
                T1.fathers_family,
                T1.mothers_family,
                T1.gender,
                T1.telephone,
                DATE_FORMAT(T1.birthday, '%d/%m/%Y') AS birthday,
                YEAR(CURDATE())-YEAR(T1.birthday) AS age,
                T1.address,
                DATE_FORMAT(T0.date_exam_order, '%d/%m/%Y') AS date_exam_order,
                DATE_FORMAT(T0.date_exam, '%d/%m/%Y') AS date_exam,
                DATE_FORMAT(T0.date_exam_reception, '%d/%m/%Y') AS date_exam_reception,
                T0.birards_mamografia,
                T0.birards_ecografia,
                T0.birards_proyeccion,
                T0.diagnostico,
                ES2.alias AS establecimiento_realiza_examen,
                T0.profesional_solicita,
                T0.medico,
                T0.servicio_salud,
                CO.name AS comuna_name,
                ES.alias AS cesfam_name
            FROM exams T0
            LEFT JOIN patients T1 ON T0.patient_id = T1.id
            LEFT JOIN communes CO  ON T0.comuna = CO.code_deis
            LEFT JOIN establishments ES  ON T0.cesfam = ES.new_code_deis
            LEFT JOIN establishments ES2  ON T0.establecimiento_realiza_examen = ES2.new_code_deis
            WHERE T1.run = '".$run."'
                  ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune." 
            ORDER BY T0.id DESC";

      $patient = DB::select($sql,array(1));

      return $patient;
  }
    

  public function getMX(Request $request)
  {
      if(!$request->ajax()) return redirect('/');

      $dateIni            = $request->dateIni;
      $dateEnd            = $request->dateEnd;
      $code_deis          = $request->codeDeis;
      $code_deis_request  = $request->codeDeisRequest;
      $commune            = $request->commune;

      $dateIni  = ($dateIni == NULL) ? ($dateIni = date("Y-m-d")) : $dateIni;
      $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = '') : $dateEnd;
      $code_deis  = ($code_deis == NULL) ? ($code_deis = '') : "AND T0.establecimiento_realiza_examen = ".$code_deis;
      
      if($code_deis_request == NULL) {
        if(Auth::user()->establishment_id){
          $code_deis_request = "AND T0.cesfam = ".Auth::user()->establishment_id;
        }
        else {
          $code_deis_request = '';
        }
      }
      else {
        if(!$code_deis_request == NULL) {
          $code_deis_request = "AND T0.cesfam IN (".implode(', ', $code_deis_request).")";
        }
        else {
            $code_deis_request = '';
        }
      }

      if($commune == NULL) {
          if(Auth::user()->commune_id){
            $commune = "AND T0.comuna = ".Auth::user()->commune_id;
          }
          else {
            $commune = '';
          }
      }
      else {
        $commune = "AND T0.comuna = ".$commune;
      }

    
      $sql=" SELECT T1.run,
                  T1.dv,
                  T1.name,
                  T1.fathers_family,
                  T1.mothers_family,
                  T1.gender,
                  T1.telephone,
                  DATE_FORMAT(T1.birthday, '%d/%m/%Y') AS birthday,
                  YEAR(CURDATE())-YEAR(T1.birthday) AS age,
                  T1.address,
                  DATE_FORMAT(T0.date_exam_order, '%d/%m/%Y') AS date_exam_order,
                  DATE_FORMAT(T0.date_exam, '%d/%m/%Y') AS date_exam,
                  DATE_FORMAT(T0.date_exam_reception, '%d/%m/%Y') AS date_exam_reception,
                  T0.birards_mamografia,
                  T0.birards_ecografia,
                  T0.birards_proyeccion,
                  T0.diagnostico,
                  ES2.alias AS establecimiento_realiza_examen,
                  T0.profesional_solicita,
                  T0.medico,
                  T0.servicio_salud,
                  CO.name AS comuna_name,
                  ES.alias AS cesfam_name
              FROM exams T0
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
              LEFT JOIN communes CO  ON T0.comuna = CO.code_deis
              LEFT JOIN establishments ES  ON T0.cesfam = ES.new_code_deis
              LEFT JOIN establishments ES2  ON T0.establecimiento_realiza_examen = ES2.new_code_deis
            WHERE T0.date_exam >= '".$dateIni ."' AND T0.date_exam <= '".$dateEnd ."'
                  ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune." ";

      $patient = DB::select($sql);

      return $patient;
  }

  public function getMXBirards(Request $request)
  {
      if(!$request->ajax()) return redirect('/');

      $dateIni            = $request->dateIni;
      $dateEnd            = $request->dateEnd;
      $code_deis          = $request->codeDeis;
      $code_deis_request  = $request->codeDeisRequest;
      $commune            = $request->commune;
      $listBirards        = $request->listBirards;
      //dd($listBirards);

      $dateIni  = ($dateIni == NULL) ? ($dateIni = date("Y-m-d")) : $dateIni;
      $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = '') : $dateEnd;
      $code_deis  = ($code_deis == NULL) ? ($code_deis = '') : "AND T0.establecimiento_realiza_examen = ".$code_deis;
      if($code_deis_request == NULL) {
        if(Auth::user()->establishment_id){
          $code_deis_request = "AND T0.cesfam = ".Auth::user()->establishment_id;
        }
        else {
          $code_deis_request = '';
        }
      }
      else {
        $code_deis_request = "AND T0.cesfam = ".$code_deis_request;
      }

    if($commune == NULL) {
          if(Auth::user()->commune_id){
            $commune = "AND T0.comuna = ".Auth::user()->commune_id;
          }
          else {
            $commune = '';
          }
    }
    else {
        $commune = "AND T0.comuna = ".$commune;
    }

    if(!$listBirards == NULL) {
          $listBirards = "AND T0.birards_mamografia IN (".implode(', ', $listBirards).")";
    }
    else {
        $listBirards = '';
    }

      /*$exams = Exam::with("patients")
                  ->whereBetween('date_exam', [$dateIni, $dateEnd])
                  ->whereIn('birards_mamografia', $listBirards)
                  ->get();*/

      $sql=" SELECT T1.run,
                  T1.dv,
                  T1.name,
                  T1.fathers_family,
                  T1.mothers_family,
                  T1.gender,
                  T1.telephone,
                  DATE_FORMAT(T1.birthday, '%d/%m/%Y') AS birthday,
                  YEAR(CURDATE())-YEAR(T1.birthday) AS age,
                  T1.address,
                  DATE_FORMAT(T0.date_exam_order, '%d/%m/%Y') AS date_exam_order,
                  DATE_FORMAT(T0.date_exam, '%d/%m/%Y') AS date_exam,
                  DATE_FORMAT(T0.date_exam_reception, '%d/%m/%Y') AS date_exam_reception,
                  T0.birards_mamografia,
                  T0.birards_ecografia,
                  T0.birards_proyeccion,
                  T0.diagnostico,
                  ES2.alias AS establecimiento_realiza_examen,
                  T0.profesional_solicita,
                  T0.medico,
                  T0.servicio_salud,
                  CO.name AS comuna_name,
                  ES.alias AS cesfam_name
              FROM exams T0
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
              LEFT JOIN communes CO  ON T0.comuna = CO.code_deis
              LEFT JOIN establishments ES  ON T0.cesfam = ES.new_code_deis
              LEFT JOIN establishments ES2  ON T0.establecimiento_realiza_examen = ES2.new_code_deis
            WHERE T0.date_exam >= '".$dateIni ."' AND T0.date_exam <= '".$dateEnd ."'
                  ".$listBirards ."
                  ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune." ";
    
                  //dd($sql);

    $patient = DB::select($sql);

      return $patient;
  }

  // OBTENER LOS BIRARDS POR RANGO DE EDAD
  // FILTROS DE RANGO DE FECHA
  public function getBirardsAgeMX(Request $request)
  {
      if(!$request->ajax()) return redirect('/');

      $dateIni            = $request->dateIni;
      $dateEnd            = $request->dateEnd;
      $code_deis          = $request->codeDeis;
      $code_deis_request  = $request->codeDeisRequest;
      $commune            = $request->commune;
      $year_start         = date("Y-01-01");
      $date_now           = date("Y-m-d");
    
      $dateIni  = ($dateIni == NULL) ? ($dateIni = $year_start) : $dateIni;
      $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = $date_now) : $dateEnd;

      $code_deis  = ($code_deis == NULL) ? ($code_deis = '') : "AND T0.establecimiento_realiza_examen = ".$code_deis;
      //$code_deis_request  = ($code_deis_request == NULL) ? ($code_deis_request = '') : "AND T0.cesfam = ".$code_deis_request;
      //$commune  = ($commune == NULL) ? ($commune = '') : "AND T0.comuna = ".$commune;
    if($code_deis_request == NULL) {
        if(Auth::user()->establishment_id){
          $code_deis_request = "AND T0.cesfam = ".Auth::user()->establishment_id;
        }
        else {
          $code_deis_request = '';
        }
    }
    else {
        $code_deis_request = "AND T0.cesfam = ".$code_deis_request;
    }

    if($commune == NULL) {
        if(Auth::user()->commune_id){
          $commune = "AND T0.comuna = ".Auth::user()->commune_id;
        }
        else {
          $commune = '';
        }
      }
      else {
        $commune = "AND T0.comuna = ".$commune;
      }
      

      $sql="  SELECT T0.birards_mamografia AS birards,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) < 35 then 1 else 0 end) as range1,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) >= 35 and YEAR(CURDATE())-YEAR(T1.birthday) <= 49 then 1 else 0 end) as range2,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 49 and YEAR(CURDATE())-YEAR(T1.birthday) <= 54 then 1 else 0 end) as range3,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 54 and YEAR(CURDATE())-YEAR(T1.birthday) <= 59 then 1 else 0 end) as range4,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 59 and YEAR(CURDATE())-YEAR(T1.birthday) <= 64 then 1 else 0 end) as range5,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 64 and YEAR(CURDATE())-YEAR(T1.birthday) <= 69 then 1 else 0 end) as range6,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 69 and YEAR(CURDATE())-YEAR(T1.birthday) <= 74 then 1 else 0 end) as range7,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 74 and YEAR(CURDATE())-YEAR(T1.birthday) <= 79 then 1 else 0 end) as range8,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 79  then 1 else 0 end) as range9,
                      COUNT(YEAR(CURDATE())-YEAR(T1.birthday)) as total
                  FROM exams T0
                  LEFT JOIN patients T1 ON T0.patient_id = T1.id
                  WHERE T0.date_exam >= '".$dateIni ."' AND T0.date_exam <= '".$dateEnd ."'
                    AND T0.birards_mamografia <> ''
                    ".$code_deis_request ."
                    ".$code_deis ."
                    ".$commune ."
                  GROUP BY T0.birards_mamografia";

      $birardsAge = DB::select($sql,array(1));

      return $birardsAge;
  }

  public function getBirardsEcoAgeMX(Request $request)
  {
      if(!$request->ajax()) return redirect('/');

      $dateIni            = $request->dateIni;
      $dateEnd            = $request->dateEnd;
      $code_deis          = $request->codeDeis;
      $code_deis_request  = $request->codeDeisRequest;
      $commune            = $request->commune;
      $year_start         = date("Y-01-01");
      $date_now           = date("Y-m-d");
    

      $dateIni  = ($dateIni == NULL) ? ($dateIni = $year_start) : $dateIni;
      $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = $date_now) : $dateEnd;

      $code_deis  = ($code_deis == NULL) ? ($code_deis = '') : "AND T0.establecimiento_realiza_examen = ".$code_deis;

    if($code_deis_request == NULL) {
        if(Auth::user()->establishment_id){
          $code_deis_request = "AND T0.cesfam = ".Auth::user()->establishment_id;
        }
        else {
          $code_deis_request = '';
        }
    }
    else {
        $code_deis_request = "AND T0.cesfam = ".$code_deis_request;
    }

    if($commune == NULL) {
        if(Auth::user()->commune_id){
          $commune = "AND T0.comuna = ".Auth::user()->commune_id;
        }
        else {
          $commune = '';
        }
    }
    else {
        $commune = "AND T0.comuna = ".$commune;
    }

      $sql="  SELECT T0.birards_ecografia AS birards,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) < 35 then 1 else 0 end) as range1,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) >= 35 and YEAR(CURDATE())-YEAR(T1.birthday) <= 49 then 1 else 0 end) as range2,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 49 and YEAR(CURDATE())-YEAR(T1.birthday) <= 54 then 1 else 0 end) as range3,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 54 and YEAR(CURDATE())-YEAR(T1.birthday) <= 59 then 1 else 0 end) as range4,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 59 and YEAR(CURDATE())-YEAR(T1.birthday) <= 64 then 1 else 0 end) as range5,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 64 and YEAR(CURDATE())-YEAR(T1.birthday) <= 69 then 1 else 0 end) as range6,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 69 and YEAR(CURDATE())-YEAR(T1.birthday) <= 74 then 1 else 0 end) as range7,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 74 and YEAR(CURDATE())-YEAR(T1.birthday) <= 79 then 1 else 0 end) as range8,
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 79  then 1 else 0 end) as range9,
                      COUNT(YEAR(CURDATE())-YEAR(T1.birthday)) as total
                  FROM exams T0
                  LEFT JOIN patients T1 ON T0.patient_id = T1.id
                  WHERE T0.date_exam >= '".$dateIni ."' AND T0.date_exam <= '".$dateEnd ."'
                    AND T0.birards_ecografia <> ''
                    ".$code_deis_request ."
                    ".$code_deis ."
                    ".$commune ."
                  GROUP BY T0.birards_ecografia";

      $birardsAge = DB::select($sql,array(1));

      return $birardsAge;
  }

  public function export() 
  {
      return Excel::download(new UsersExport, 'Reporte.xlsx');
  }

  public function getMXBiradYears(Request $request)
  {
      if(!$request->ajax()) return redirect('/');


      $year               = $request->year;
      $dateIni            = $request->dateIni;
      $dateEnd            = $request->dateEnd;
      $code_deis          = $request->codeDeis;
      $code_deis_request  = $request->codeDeisRequest;
      $commune            = $request->commune;
      $listBirards        = $request->listBirards;
      $listExamType       = $request->listExamType;
      // return $listExamType;

      $dateIni  = ($dateIni == NULL) ? ($dateIni = date("Y-m-d")) : $dateIni;
      $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = '') : $dateEnd;
      $code_deis  = ($code_deis == NULL) ? ($code_deis = '') : "AND T0.establecimiento_realiza_examen = ".$code_deis;
      if($code_deis_request == NULL) {
        if(Auth::user()->establishment_id){
          $code_deis_request = "AND T0.cesfam = ".Auth::user()->establishment_id;
        }
        else {
          $code_deis_request = '';
        }
      }
      else {
        $code_deis_request = "AND T0.cesfam = ".$code_deis_request;
      }

    if($commune == NULL) {
          if(Auth::user()->commune_id){
            $commune = "AND T0.comuna = ".Auth::user()->commune_id;
          }
          else {
            $commune = '';
          }
    }
    else {
        $commune = "AND T0.comuna = ".$commune;
    }

    if(!$listBirards == NULL) {

          $listBirards = "AND ( birards_mamografia = ".$listBirards." OR birards_ecografia = ".$listBirards." OR birards_proyeccion = ".$listBirards." )";
    }
    else {
        $listBirards = '';
    }

    if(!$listExamType == NULL) {
          $list = implode("','", $listExamType);
          $listExamType = "AND exam_type IN ('".$list."')";
    }
    else {
        $listExamType = '';
    }


    $sql="SELECT ultimo_examen
                ,a.birards_mamografia
                ,a.birards_ecografia
                ,a.birards_proyeccion
                ,YEAR(CURDATE())-YEAR(b.birthday) AS age
                ,TIMESTAMPDIFF(Month,a.ultimo_examen, NOW()) AS years
                ,b.name
                ,b.fathers_family
                ,b.mothers_family
                ,b.gender
                ,b.birthday
                ,b.address
                ,b.telephone
                ,b.run
                ,b.dv
          FROM (
            SELECT  MAX(date_exam) as ultimo_examen, p.patient_id, p.birards_mamografia, p.birards_ecografia, p.birards_proyeccion FROM  exams p WHERE 1=1 ".$listBirards ." ". $listExamType."  GROUP By p.patient_id, p.birards_mamografia, p.birards_ecografia, p.birards_proyeccion
          ) a
          INNER JOIN patients b ON a.patient_id = b.id
          WHERE TIMESTAMPDIFF(Month,a.ultimo_examen, NOW()) >= ".$year."";

          $patient = DB::select($sql);
          
    return $patient;
  }

  public function getMXCoverage(Request $request)
  {

    if(!$request->ajax()) return redirect('/');
      $dateIni            = $request->dateIni;
      $dateEnd            = $request->dateEnd;
      $code_deis          = $request->codeDeis;
      $code_deis_request  = $request->codeDeisRequest;
      $commune            = $request->commune;

      $dateIni  = ($dateIni == NULL) ? ($dateIni = date("Y-m-d")) : $dateIni;
      $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = '') : $dateEnd;
      $code_deis  = ($code_deis == NULL) ? ($code_deis = '') : "AND T0.establecimiento_realiza_examen = ".$code_deis;
      
      if($code_deis_request == NULL) {
        if(Auth::user()->establishment_id){
          $code_deis_request = "AND T0.cesfam = ".Auth::user()->establishment_id;
        }
        else {
          $code_deis_request = '';
        }
      }
      else {
        if(!$code_deis_request == NULL) {
          $code_deis_request = "AND T0.cesfam IN (".implode(', ', $code_deis_request).")";
        }
        else {
            $code_deis_request = '';
        }
      }

      if($commune == NULL) {
          if(Auth::user()->commune_id){
            $commune = "AND T0.comuna = ".Auth::user()->commune_id;
          }
          else {
            $commune = '';
          }
      }
      else {
        $commune = "AND T0.comuna = ".$commune;
      }

      $sql = "

            SELECT '0 > 15' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) < 15
            GROUP BY '0 > 15'

            UNION ALL

            SELECT '15 - 19' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 15 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 19 
            GROUP BY '15 - 19'

            UNION ALL

            SELECT '20 - 24' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 20 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 24 
            GROUP BY '20 - 24'

            UNION ALL

            SELECT '25 - 29' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 25 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 29 
            GROUP BY '25 - 29'

            UNION ALL

            SELECT '30 - 34' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 30 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 34 
            GROUP BY '30 - 34'

            UNION ALL

            SELECT '35 - 39' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 35 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 39 
            GROUP BY '35 - 39'

            UNION ALL

            SELECT '40 - 44' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 40 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 44 
            GROUP BY '40 - 44'

            UNION ALL

            SELECT '45 - 49' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 45 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 49 
            GROUP BY '45 - 49'

            UNION ALL

            SELECT '50 - 54' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 50 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 54 
            GROUP BY '50 - 54'

            UNION ALL

            SELECT '55 - 59' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 55 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 59 
            GROUP BY '55 - 59'

            UNION ALL

            SELECT '60 - 64' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 60 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 64 
            GROUP BY '60 - 64'

            UNION ALL

            SELECT '65 - 69' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 65 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 69 
            GROUP BY '65 - 69'

            UNION ALL

            SELECT '70 - 74' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 70 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 74 
            GROUP BY '70 - 74'

            UNION ALL

            SELECT '75 - 79' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 75 AND YEAR(CURDATE())-YEAR(T1.birthday) <= 79 
            GROUP BY '75 - 79'

            UNION ALL

            SELECT '80 - Más' AS age
                ,SUM(case when T0.birards_mamografia > 0  then 1 else 0 end)  AS mam
                ,SUM(case when T0.birards_ecografia  > 0  then 1 else 0 end)  AS eco
                ,SUM(case when T0.birards_proyeccion > 0  then 1 else 0 end)  AS pro
              FROM exams T0 
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
            WHERE T0.date_exam >= '".$dateIni."' AND T0.date_exam <= '".$dateEnd."'
             ".$code_deis_request ."
                  ".$code_deis ."
                  ".$commune."
              AND YEAR(CURDATE())-YEAR(T1.birthday) >= 80 
            GROUP BY '80 - Más'

      ";


      $result = DB::select($sql,array(1));

      return $result;
  }

  public function getMXSigte(Request $request)
  {
    if(!$request->ajax()) return redirect('/');

    $dateIni            = $request->dateIni;
    $dateEnd            = $request->dateEnd;
    $type               = $request->type;
    $commune            = $request->commune;

    $dateIni  = ($dateIni == NULL) ? ($dateIni = date("Y-m-d")) : $dateIni;
    $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = '') : $dateEnd;
    $type     = ($type == 'output') ? 
                    "DATE_FORMAT(T0.date_exam, '%d/%m/%Y') AS F_SALIDA, '16' AS C_SALIDA, T0.establecimiento_realiza_examen AS E_OTOR_AT, '04-01-010' AS PRESTA_MIN_SALIDA," 
                    : " ' ' AS F_SALIDA, ' ' AS C_SALIDA, ' ' AS E_OTOR_AT, ' ' AS PRESTA_MIN_SALIDA,";

    if($commune == NULL) {
          if(Auth::user()->commune_id){
            $commune = "AND T0.comuna = ".Auth::user()->commune_id;
          }
          else {
            $commune = '';
          }
    }
    else {
        $commune = "AND T0.comuna = ".$commune;
    }

    $sql=" SELECT 
                  '02' AS SERV_SALUD,
                  T1.run AS RUN,
                  UPPER(T1.dv) AS DV,
                  REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( UPPER(T1.name),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') AS NOMBRES,
                  REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( UPPER(T1.fathers_family),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') AS PRIMER_APELLIDO,
                  REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( UPPER(T1.mothers_family),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') AS SEGUNDO_APELLIDO,
                  DATE_FORMAT(T1.birthday, '%d/%m/%Y') AS FECHA_NAC,
                  CASE
                    WHEN T1.gender = 'male' THEN 1
                    WHEN T1.gender = 'female' THEN 2
                    WHEN T1.gender = 'other' THEN 3
                    WHEN T1.gender = 'unknown' THEN 9
                  END AS SEXO,
                  '1' AS PREVISION,
                  '3' AS TIPO_PREST,
                  '04-01-010' AS PRESTA_MIN,
                  ' ' AS PLANO,
                  ' ' AS EXTREMIDAD,
                  'MAMOGRAFIA BILATERAL (4 EXP.)' AS PRESTA_EST,
                  DATE_FORMAT(T0.date_exam_order, '%d/%m/%Y') AS F_ENTRADA, 
                  T0.cesfam as ESTAB_ORIG,
                  T0.establecimiento_realiza_examen as ESTAB_DEST, ".$type."
                  '2' AS PRAIS,
                  '1' AS REGION,
                  T0.comuna AS COMUNA,
                  'PROGRAMA IMAGENES DIAGNOSTICAS' AS SOSPECHA_DIAG,
                  ' ' AS CONFIR_DIAG,
                  ' ' AS CIUDAD,
                  ' ' AS COND_RURALIDAD,
                  ' ' AS VIA_DIRECCION,
                  -- REPLACE( REPLACE( REPLACE( REPLACE( REPLACE( UPPER(T1.address),'Á','A'),'É','E'),'Í','I'),'Ó','O'),'Ú','U') AS NOM_CALLE, 
                  ' ' AS NOM_CALLE,
                  ' ' AS NUM_DIRECCION,
                  ' ' AS RESTO_DIRECCION,
                  ' ' AS FONO_FIJO,
                  -- T1.telephone AS FONO_MOVIL, 
                  ' ' AS FONO_MOVIL,
                  ' ' AS EMAIL,
                  ' ' AS F_CITACION,
                  ' ' AS RUN_PROF_SOL,
                  ' ' AS DV_PROF_SOL,
                  ' ' AS RUN_PROF_RESOL,
                  ' ' AS DV_PROF_RESOL,
                  T0.id AS ID_LOCAL,
                  ' ' AS RESULTADO
                  ".($request->type == 'output' ? ', T0.sigte_id AS SIGTE_ID' : '')."
              FROM exams T0
              LEFT JOIN patients T1 ON T0.patient_id = T1.id
  
            WHERE T0.exam_type = 'mam' AND T0.date_exam_order >= '".$dateIni ."' AND T0.date_exam_order <= '".$dateEnd ."' ".$commune;
    
    $result = DB::select($sql);

    return $result;
  }
}

