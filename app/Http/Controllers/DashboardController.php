<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


clASs DAShboardController extends Controller
{
    public function getExamYear(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $sql=" SELECT  MONTH(T0.date_exam) AS month
                    ,MONTHNAME(T0.date_exam) AS month_name
                    ,count(*) AS exam_quantity
            FROM exams T0
            WHERE T0.date_exam >= DATE_FORMAT(NOW() ,'%Y-01-01') AND T0.date_exam <= NOW()
            GROUP BY 
                    MONTH(T0.date_exam)
                    ,MONTHNAME(T0.date_exam)";

        $patient = DB::select($sql,array(1));

        return $patient;
    }

    public function getHistYear(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $sql="SELECT  CO.name AS name_label
                        ,count(*) AS exam_quantity
                FROM exams T0
                LEFT JOIN patients T1 ON T0.patient_id = T1.id
                LEFT JOIN communes CO  ON T0.comuna = CO.code_deis
                WHERE T0.date_exam >= DATE_FORMAT(NOW() ,'%Y-01-01') AND T0.date_exam <= NOW()
                GROUP BY 
                        CO.name";

        $patient = DB::select($sql,array(1));

        return $patient;
    }

    public function getIndicators(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $sql="SELECT 'total_exam',
                        COUNT(*) AS quantity
                FROM exams T0
                WHERE T0.date_exam >= DATE_FORMAT(NOW() ,'%Y-01-01') AND T0.date_exam <= NOW()
                UNION
                SELECT 'total_mam',
                        COUNT(T0.birards_mamografia) AS quantity
                FROM exams T0
                WHERE T0.birards_mamografia IS NOT NULL
                    AND T0.birards_mamografia <> ''
                    AND T0.date_exam >= DATE_FORMAT(NOW() ,'%Y-01-01') AND T0.date_exam <= NOW()
                UNION  
                SELECT 'total_eco',
                        COUNT(T0.birards_ecografia) AS quantity
                FROM exams T0
                WHERE T0.birards_ecografia IS NOT NULL
                    AND T0.birards_ecografia <> ''
                    AND T0.date_exam >= DATE_FORMAT(NOW() ,'%Y-01-01') AND T0.date_exam <= NOW()
                UNION
                SELECT 'total_pro',
                        COUNT(T0.birards_proyeccion) AS quantity
                FROM exams T0
                WHERE T0.birards_proyeccion IS NOT NULL
                    AND T0.birards_proyeccion <> ''
                    AND T0.date_exam >= DATE_FORMAT(NOW() ,'%Y-01-01') AND T0.date_exam <= NOW()
                ";

        $patient = DB::select($sql,array(1));

        return $patient;
    }
}
