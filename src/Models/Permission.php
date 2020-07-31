<?php

namespace Abdul\RolePermission\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'action', 'module', 'section'];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
