<?php

namespace App\Http\Controllers\Management;

use App\Load;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoadController extends Controller
{
    public function getListLoads(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
    
        $idLoad         = $request->idLoad;
        $title         = $request->title;
 
        $idLoad = ($idLoad == NULL) ? ($idLoad = '') : $idLoad;
 
        if(!$idLoad)
        {
          $load = Load::Where('title','LIKE','%'.$title.'%')->orderBy('id', 'desc')->take(400)->get();
        }
        else{
          $load = Load::Where('id','=',$idLoad)->orderBy('id', 'desc')->get();
        }
 
        return $load->toArray();
    }
}
