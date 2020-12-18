<?php

namespace App\Http\Controllers\Management;
use App\Commune;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    public function getListCommunes(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

       $name  = $request->name;
       $name  = ($name == NULL) ? ($name = '') : $name;
       
       $commune = Commune::Where('name','LIKE','%'.$name.'%')->Wherein('region_id',['1'])->get();

       return $commune->toArray();
    }
}
