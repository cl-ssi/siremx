<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'id','name','code_deis','region_id'
    ];

    public function region() {
        return $this->belongsTo('\App\Region');
    }

    public function establishments() {
        return $this->hasMany('\App\Establishment');
    }

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
