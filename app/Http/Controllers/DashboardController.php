<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exam;

class DashboardController extends Controller
{
    public function getExamYear(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $year = $request->year;
        $year  = ($year == NULL) ? ($year = date("Y")) : $year;

        $sql=" SELECT  MONTH(T0.date_exam) AS month
                    ,MONTHNAME(T0.date_exam) AS month_name
                    ,count(*) AS exam_quantity
            FROM exams T0
            WHERE YEAR(T0.date_exam) = ".$year."
               
            GROUP BY 
                    MONTH(T0.date_exam)
                    ,MONTHNAME(T0.date_exam)";

        $patient = DB::select($sql,array(1));

        return $patient;
    }

    public function getHistYear(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $year = $request->year;
        $year  = ($year == NULL) ? ($year = date("Y")) : $year;

        $sql="SELECT  CO.name AS name_label
                        ,count(*) AS exam_quantity
                FROM exams T0
                LEFT JOIN patients T1 ON T0.patient_id = T1.id
                LEFT JOIN communes CO  ON T0.comuna = CO.code_deis
                WHERE YEAR(T0.date_exam) = ".$year."
                GROUP BY 
                        CO.name";

        $patient = DB::select($sql,array(1));

        return $patient;
    }

    public function getHistEstablishmentYear(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $year = $request->year;
        $year  = ($year == NULL) ? ($year = date("Y")) : $year;

        $sql="SELECT  REPLACE(CO.name, 'Centro de Salud Familiar', '') AS name_label
                      ,count(*) AS exam_quantity
                FROM exams T0
                LEFT JOIN patients T1 ON T0.patient_id = T1.id
                LEFT JOIN establishments CO  ON T0.cesfam = CO.new_code_deis
                WHERE YEAR(T0.date_exam) = ".$year."
                  AND CO.name IS NOT NULL
                GROUP BY 
                        CO.name
                ORDER BY exam_quantity DESC";

        $resp = DB::select($sql,array(1));

        return $resp;
    }

    public function getIndicatorBirads(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $year = $request->year;
        $year  = ($year == NULL) ? ($year = date("Y")) : $year;

        $sql="SELECT 
                        T.birads AS birads
                       ,SUM(T.exam_quantity) AS exam_quantity
                
                FROM (
                
                SELECT  T0.birards_mamografia AS birads
                                    ,count(*) AS exam_quantity
                            FROM exams T0
                            WHERE YEAR(T0.date_exam) = ".$year."
                            AND birards_mamografia IS NOT NULL
                            AND birards_mamografia NOT LIKE ''
                            GROUP BY 
                                    T0.birards_mamografia
                UNION ALL
                
                SELECT  T0.birards_ecografia AS birads
                                    ,count(*) AS exam_quantity
                            FROM exams T0
                            WHERE YEAR(T0.date_exam) = ".$year."
                            AND birards_ecografia IS NOT NULL
                            AND birards_ecografia NOT LIKE ''
                            GROUP BY 
                                    T0.birards_ecografia
                UNION ALL
                
                SELECT  T0.birards_proyeccion AS birads
                                    ,count(*) AS exam_quantity
                            FROM exams T0
                            WHERE YEAR(T0.date_exam) = ".$year."
                            AND birards_proyeccion IS NOT NULL
                            AND birards_proyeccion NOT LIKE ''
                            GROUP BY 
                                    T0.birards_proyeccion ) AS T
                GROUP BY T.birads";

        $resp = DB::select($sql,array(1));

        return $resp;
    }

    public function getIndicators(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $year = $request->year;
        $year  = ($year == NULL) ? ($year = date("Y")) : $year;

        $sql="SELECT 'total_exam',
                        COUNT(*) AS quantity
                FROM exams T0
                WHERE YEAR(T0.date_exam) = ".$year."
                UNION
                SELECT 'total_mam',
                        COUNT(T0.birards_mamografia) AS quantity
                FROM exams T0
                WHERE T0.birards_mamografia IS NOT NULL
                    AND T0.birards_mamografia <> ''
                    AND YEAR(T0.date_exam) = ".$year."
                UNION  
                SELECT 'total_eco',
                        COUNT(T0.birards_ecografia) AS quantity
                FROM exams T0
                WHERE T0.birards_ecografia IS NOT NULL
                    AND T0.birards_ecografia <> ''
                    AND YEAR(T0.date_exam) = ".$year."
                UNION
                SELECT 'total_pro',
                        COUNT(T0.birards_proyeccion) AS quantity
                FROM exams T0
                WHERE T0.birards_proyeccion IS NOT NULL
                    AND T0.birards_proyeccion <> ''
                    AND YEAR(T0.date_exam) = ".$year."
                ";

        $patient = DB::select($sql,array(1));

        return $patient;
    }

    public function getIndicator5069(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $year = $request->year;
        $year  = ($year == NULL) ? ($year = date("Y")) : $year;

        $sql="SELECT 
                      SUM(case when YEAR(CURDATE())-YEAR(T1.birthday) > 49 and YEAR(CURDATE())-YEAR(T1.birthday) <= 69 then 1 else 0 end) as age5069
                     ,COUNT(YEAR(CURDATE())-YEAR(T1.birthday)) as total_mam
                FROM exams T0
                LEFT JOIN patients T1 ON T0.patient_id = T1.id
                WHERE YEAR(T0.date_exam) = ".$year."
                  AND T0.birards_mamografia IS NOT NULL
                  AND T0.birards_mamografia <> ''
                ";

        $patient = DB::select($sql,array(1));

        return $patient;
    }

    public function getExamBiradsYear(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $sql="SELECT  t.month
                     ,t.month_name
                     ,t.birards
                     ,t.exam_quantity
                     ,@running_total:= IF(@previous=t.birards,@running_total,0) + t.exam_quantity   AS exam_quantity_acum
                     ,@previous:=t.birards AS birards_previous
                FROM
                    ( SELECT    MONTH(T0.date_exam) AS month
                                        ,MONTHNAME(T0.date_exam) AS month_name
                                ,birards_mamografia AS birards
                                        ,count(*) AS exam_quantity
                                FROM exams T0
                                WHERE T0.date_exam >= DATE_FORMAT(NOW() ,'%Y-01-01') AND T0.date_exam <= NOW()
                                AND birards_mamografia IS NOT NULL
                                AND birards_mamografia NOT LIKE ''
                                GROUP BY 
                                    MONTH(T0.date_exam)
                                        ,MONTHNAME(T0.date_exam)
                                        ,birards_mamografia
                    ) t
                JOIN (SELECT @running_total:=0) r
                ORDER BY birards
                        ,t.month
                    
            ";

        $patient = DB::select($sql,array(1));

        return $patient;
    }

    public function getHistEstablishmentYearProfessional(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $year = $request->year;
        $year  = ($year == NULL) ? ($year = date("Y")) : $year;

        $exams = Exam::select(
                                  'T2.new_code_deis'
                                 ,'T2.name'
                                 , DB::raw('REPLACE(T2.name, "Centro de Salud Familiar", "") AS name_label')
                                 , DB::raw('count(exams.id) AS exam_quantity'))
                    ->leftjoin('patients AS T1', 'exams.patient_id', '=', 'T1.id')
                    ->leftjoin('establishments AS T2', 'exams.cesfam', '=', 'T2.new_code_deis')
                    ->whereNotNull('T2.name')
                    ->whereYear('exams.date_exam', $year)
                    ->groupBy('T2.new_code_deis','T2.name')
                    ->orderBy('exam_quantity','Desc')
                    ->get();

        $exams_medico = Exam::select(
                                  'T2.new_code_deis'
                                 ,'T2.name'
                                 , DB::raw('REPLACE(T2.name, "Centro de Salud Familiar", "") AS name_label')
                                 , DB::raw('count(exams.id) AS exam_quantity'))
                    ->leftjoin('patients AS T1', 'exams.patient_id', '=', 'T1.id')
                    ->leftjoin('establishments AS T2', 'exams.cesfam', '=', 'T2.new_code_deis')
                    ->where('exams.profesional_solicita','Medico')
                    ->whereYear('exams.date_exam', $year)
                    ->groupBy('T2.new_code_deis','T2.name')
                    ->orderBy('exam_quantity','Desc')
                    ->get();

        $exams_matrona = Exam::select(
                                  'T2.new_code_deis'
                                 ,'T2.name'
                                 , DB::raw('REPLACE(T2.name, "Centro de Salud Familiar", "") AS name_label')
                                 , DB::raw('count(exams.id) AS exam_quantity'))
                    ->leftjoin('patients AS T1', 'exams.patient_id', '=', 'T1.id')
                    ->leftjoin('establishments AS T2', 'exams.cesfam', '=', 'T2.new_code_deis')
                    ->where('exams.profesional_solicita','Matrona')
                    ->whereYear('exams.date_exam', $year)
                    ->groupBy('T2.new_code_deis','T2.name')
                    ->orderBy('exam_quantity','Desc')
                    ->get();
        
        $exams_other = Exam::select(
                                  'T2.new_code_deis'
                                 ,'T2.name'
                                 , DB::raw('REPLACE(T2.name, "Centro de Salud Familiar", "") AS name_label')
                                 , DB::raw('count(exams.id) AS exam_quantity'))
                    ->leftjoin('patients AS T1', 'exams.patient_id', '=', 'T1.id')
                    ->leftjoin('establishments AS T2', 'exams.cesfam', '=', 'T2.new_code_deis')
                    ->where('exams.profesional_solicita','!=','Medico')
                    ->where('exams.profesional_solicita','!=','Matrona')
                    ->whereYear('exams.date_exam', $year)
                    ->groupBy('T2.new_code_deis','T2.name')
                    ->orderBy('exam_quantity','Desc')
                    ->get();


        foreach ($exams as $exam) {
            foreach ($exams_medico as $exam_medico) {

                if($exam->new_code_deis == $exam_medico->new_code_deis) {
                    $exam['exam_quantity_med'] = $exam_medico->exam_quantity;
                }

            }
        }

        foreach ($exams as $exam) {
            foreach ($exams_matrona as $exam_matrona) {

                if($exam->new_code_deis == $exam_matrona->new_code_deis) {
                    $exam['exam_quantity_mat'] = $exam_matrona->exam_quantity;
                }

            }
        }

        foreach ($exams as $exam) {
            foreach ($exams_other as $exam_other) {

                if($exam->new_code_deis == $exam_other->new_code_deis) {
                    $exam['exam_quantity_other'] = $exam_other->exam_quantity;
                }

            }
        }

        return $exams;
    }

    // DASHBOARD AUDITORIA

    public function getExamYearEstablishment(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $sql="SELECT  
                        T0.cesfam AS establishment
                ,MONTH(T0.date_exam) AS month
                ,MONTHNAME(T0.date_exam) AS month_name
                ,count(*) AS exam_quantity
                FROM exams T0
                WHERE T0.date_exam >= DATE_FORMAT(NOW() ,'%Y-01-01') AND T0.date_exam <= NOW()
                 AND T0.cesfam = '102301'
                GROUP BY 
                T0.cesfam 
                ,MONTH(T0.date_exam)
                ,MONTHNAME(T0.date_exam)
                ORDER BY T0.cesfam ";

        $patient = DB::select($sql,array(1));

        return $patient;
    }

    public function getLastExamEstablishment(Request $request)
    {
        if(!$request->ajax()) return redirect('/');


        $date = date("Y-01-01");


        $lastExamsEstablishmentRequests = Exam::select(
                                        'e.alias as establishment'
                                        ,'e.new_code_deis'
                                        ,DB::raw('MAX(exams.date_exam) as last_exam'))
                                ->leftjoin('establishments as e', 'e.new_code_deis', '=', 'exams.cesfam')
                                ->whereNotNull('e.alias')
                                ->Where('exams.date_exam','>=',$date)
                                ->groupBy('e.alias','e.new_code_deis')
                                ->orderBy('last_exam','ASC')
                                ->get();
        
        $lastExamsEstablishmentExams = Exam::select(
                                        'e.alias as establishment'
                                        ,'e.new_code_deis'
                                        ,DB::raw('MAX(exams.date_exam) as last_establishment_exam'))
                                ->leftjoin('establishments as e', 'e.new_code_deis', '=', 'exams.establecimiento_realiza_examen')
                                ->whereNotNull('e.alias')
                                ->Where('exams.date_exam','>=',$date)
                                ->groupBy('e.alias','e.new_code_deis')
                                ->orderBy('last_establishment_exam','ASC')
                                ->get();

        foreach ($lastExamsEstablishmentRequests as $lastExamsEstablishmentRequest) {
            foreach ($lastExamsEstablishmentExams as $lastExamsEstablishmentExam) {
                
                if($lastExamsEstablishmentRequest->new_code_deis == $lastExamsEstablishmentExam->new_code_deis) {
                    $lastExamsEstablishmentRequest['last_establishment_exam'] = $lastExamsEstablishmentExam->last_establishment_exam;
                }

            }
        }

        $resp = $lastExamsEstablishmentRequests;


        return $resp;
    }
    
}
