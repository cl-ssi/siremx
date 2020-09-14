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

    public function getListDerivationsSelect(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
    
       $establishment_code_deis           = $request->establishment_code_deis;
       $establishment_code_deis  = ($establishment_code_deis == NULL) ? ($establishment_code_deis = '') : $establishment_code_deis;
       
       $derivationDefault   = Derivation::whereNull('establishment_code_deis')->get();
       $derivationDependent = Derivation::Where('establishment_code_deis','LIKE',$establishment_code_deis)->get();

       $derivation = $derivationDefault->merge($derivationDependent);

       return $derivation;
    }
}
