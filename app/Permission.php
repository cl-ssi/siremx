<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    
    public function rolePermission() {
        return $this->belongsTo('\App\RolePermission');
    }
}
