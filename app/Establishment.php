<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    protected $fillable = [
        // 'id','name','type','deis','commune_id'
        'id','name','alias','type','old_code_deis','new_code_deis','service','dependency',//'comuna','commune_code_deis',
        'commune_id'
    ];
  
    public function commune() {
        return $this->belongsTo('\App\Commune');
    }
  
    /*public function suspectCases() {
        return $this->hasMany('App\SuspectCase');
    }*/
  
    /**
    * The user that belong to the establishment.
    */
    public function users() {
        return $this->belongsToMany('App\User');
    }
  
    //use SoftDeletes;
  
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'establishments';
}
