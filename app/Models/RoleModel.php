<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model{

    protected $table = 'role';

    public $timestamps = true;

    protected $guarded = ['id'];

    /*角色下的权限*/
    public function conPermission(){
        return $this->belongsToMany(PermissionModel::class, 'role_permission', 'role_id', 'permission_id');
    }
    
}