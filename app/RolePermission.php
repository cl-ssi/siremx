<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'roles_permissions';

    protected $fillable = [
        'role_id','permission_id'
    ];

    public $timestamps = false;

    public function permissions() {
        return $this->hasMany('\App\Permission');
    }
    public function roles() {
        return $this->hasMany('\App\Role');
    }  
}
