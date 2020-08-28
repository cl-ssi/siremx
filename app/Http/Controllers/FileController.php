<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class FileController extends Controller
{
    public function setRegistrarArchivo(Request $request) 
    {
        //dd($request);
        $file = $request->file;
        $flag = Str::random(10);
        $filename = $file->getClientOriginalName();
        $fileserver = $flag.'_'.$filename;
        $idUser = Auth::id();

        //dd($fileserver);
        Storage::putFileAs('public/users',$file, $fileserver);

        $rpta     = DB::select('call sp_Archivo_setRegistrarArchivo (?,?,?)',
        [
            asset('storage/users/'.$fileserver),
            $filename,
            $idUser
        ]);

       return $rpta;
    }
}
