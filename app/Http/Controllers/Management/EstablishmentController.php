<?php

namespace App\Http\Controllers\Management;
use App\Establishment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
{
    public function getListEstablishments(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
    
       $idRole = $request->idRole;
       $name   = $request->name;
       $name   = ($name == NULL) ? ($name = '') : $name;
       
       $establishment = Establishment::Where('name','LIKE','%'.$name.'%')
                                     ->Where('id','LIKE','%'.$idRole.'%')
                                     ->Where('exam_emits','LIKE','Y')
                                     ->Where('exam_center','LIKE','Y')
                                     ->Wherein('commune_id',['5', '6','7', '8','9', '10', '11'])
                                     ->orderBy('new_code_deis')->get();

       return $establishment->toArray();
    }
}
