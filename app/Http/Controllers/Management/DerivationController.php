<?php

namespace App\Http\Controllers\Management;
use App\Derivation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DerivationController extends Controller
{
    public function getListDerivations(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
    
       $title           = $request->title;
       $title  = ($title == NULL) ? ($title = '') : $title;
       
       $derivation = Derivation::Where('title','LIKE','%'.$title.'%')->get();

       return $derivation->toArray();
    }
}
