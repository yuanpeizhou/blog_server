<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model{

    use SoftDeletes;

    protected $table = 'user';

    public $timestamps = true;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    /*联查人员角色*/
    public function conRole(){
        return $this->belongsToMany(RoleModel::class, 'user_role', 'user_id', 'role_id');
    }

    /*联查人员权限*/
    public function conPermission(){
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id');
    }
    /*给与人员权限*/
    public function AssignPermission(){

    }

    /*给与人员角色*/
    public function AssignRole(){

    }

}