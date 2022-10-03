<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    protected $fillable = [
        'path'
    ];

    public function patients() {
        return $this->belongsTo('\App\Patient', 'patient_id', 'id');
    }
}
