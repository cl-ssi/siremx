<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'id', 'path', 'filename', 'created_by', 'updated_by'
    ];
}
