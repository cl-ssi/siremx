<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';

    public function patients() {
        return $this->belongsTo('\App\Patient', 'patient_id', 'id');
    }
}
