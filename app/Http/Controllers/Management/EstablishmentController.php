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
    
       $idRole         = $request->idRole;
       //dd($idRole);
       $name           = $request->name;
       $name  = ($name == NULL) ? ($name = '') : $name;
       
       $establishment = Establishment::Where('name','LIKE','%'.$name.'%')
                    ->Where('id','LIKE','%'.$idRole.'%')->Wherein('commune_id',['5', '6','7', '8','9', '10', '11'])->get();

       return $establishment->toArray();
    }
}
