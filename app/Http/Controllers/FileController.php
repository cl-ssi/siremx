<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\File;

use Illuminate\Support\Str;

class FileController extends Controller
{
    public function setRegistrarArchivo(Request $request) 
    {
        if(!$request->ajax()) return redirect('/');

        $file = $request->file;
        $flag = Str::random(10);
        $filename = $file->getClientOriginalName();
        $fileserver = $flag.'_'.$filename;
        $idUser = Auth::id();

        Storage::putFileAs('public/users',$file, $fileserver);

        $file = new File;
        $file->path = asset('storage/users/'.$fileserver);
        $file->filename = $filename;
        $file->created_by = $idUser;
        $file->updated_by = $idUser;

        $file->save();

       return $file->id;
    }
}
