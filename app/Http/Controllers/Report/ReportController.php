<?php

namespace App\Http\Controllers\Report;

use App\Exam;
use App\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    public function getPatientHistory(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

       $run = $request->run;

       $run  = ($run == NULL) ? ($run = '') : $run;

       list($run,$dv) = array_pad(explode('-',str_replace(".", "", $run)),2,null);

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
                     T0.establecimiento_realiza_examen,
                     T0.cesfam,
                     T0.profesional_solicita,
                     T0.medico,
                     T0.servicio_salud
                FROM exams T0
                LEFT JOIN patients T1 ON T0.patient_id = T1.id
                WHERE T1.run = '".$run."'";
    

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
       $listBirards            = $request->listBirards;
       //dd($listBirards);

       $dateIni  = ($dateIni == NULL) ? ($dateIni = date("Y-m-d")) : $dateIni;
       $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = '') : $dateEnd;

       $exams = Exam::with("patients")
                    ->whereBetween('date_exam', [$dateIni, $dateEnd])
                    ->whereIn('birards_mamografia', $listBirards)
                    ->get();

       return $exams->toArray();
    }

    // OBTENER LOS BIRARDS POR RANGO DE EDAD
    // FILTROS DE RANGO DE FECHA
    public function getBirardsAgeMX(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

       $dateIni            = $request->dateIni;
       $dateEnd            = $request->dateEnd;
       $year_start         = date("Y-01-01");
       $date_now           = date("Y-m-d");

       $dateIni  = ($dateIni == NULL) ? ($dateIni = $year_start) : $dateIni;
       $dateEnd  = ($dateEnd == NULL) ? ($dateEnd = $date_now) : $dateEnd;

       $sql="  SELECT T0.birards_mamografia AS birards,
                        SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) < 35 then 1 else 0 end) as range1,
                        SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) >= 35 and YEAR(CURDATE())-YEAR(T1.birthday) <= 49 then 1 else 0 end) as range2,
                        SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 49 and YEAR(CURDATE())-YEAR(T1.birthday) <= 54 then 1 else 0 end) as range3,
                        SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 54 and YEAR(CURDATE())-YEAR(T1.birthday) <= 59 then 1 else 0 end) as range4,
                        SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 59 and YEAR(CURDATE())-YEAR(T1.birthday) <= 64 then 1 else 0 end) as range5,
                        SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 64 and YEAR(CURDATE())-YEAR(T1.birthday) <= 69 then 1 else 0 end) as range6,
                        SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 69 and YEAR(CURDATE())-YEAR(T1.birthday) <= 74 then 1 else 0 end) as range7,
                        SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 74 and YEAR(CURDATE())-YEAR(T1.birthday) <= 79 then 1 else 0 end) as range8,
                        COUNT(YEAR(CURDATE())-YEAR(T1.birthday)) as total
                    FROM exams T0
                    LEFT JOIN patients T1 ON T0.patient_id = T1.id
                   WHERE T0.date_exam >= '".$dateIni ."' AND T0.date_exam <= '".$dateEnd ."'
                    GROUP BY T0.birards_mamografia";

        $birardsAge = DB::select($sql,array(1));

        return $birardsAge;
    }


    public function export() 
    {
        return Excel::download(new UsersExport, 'Reporte.xlsx');
    }
}
