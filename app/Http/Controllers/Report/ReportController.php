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

       $dateIni  = ($dateIni == NULL) ? ($dateIni = date("Y-m-d")) : $dateIni;
       $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = '') : $dateEnd;

       $exams = Exam::with("patients")
                    ->whereBetween('date_exam', [$dateIni, $dateEnd])
                    ->get();

       return $exams->toArray();
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
           $listBirards = "AND birards_mamografia = (".$listBirards.")";
      }
      else {
          $listBirards = '';
      }

      $sql="SELECT ultimo_examen
                  ,YEAR(CURDATE())-YEAR(b.birthday) AS age
                  ,TIMESTAMPDIFF(Month,ultimo_examen, NOW()) AS years
                  ,b.name
                  ,b.fathers_family
                  ,b.mothers_family
                  ,b.gender
                  ,b.birthday
                  ,b.address
                  ,b.telephone
                  ,b.run
            FROM (
              SELECT  MAX(date_exam) as ultimo_examen, p.patient_id FROM  exams p WHERE 1=1 ".$listBirards ."  GROUP By p.patient_id
            ) a
            INNER JOIN patients b ON a.patient_id = b.id
            GROUP By a.patient_id
            HAVING years >= ".$year."";

      $patient = DB::select($sql);

       return $patient;
    }
}

