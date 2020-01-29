<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermissionModel extends Model{

    protected $table = 'user_permission';

    public $timestamps = true;

    protected $guarded = ['id'];

    public function conPermission(){
        return $this->hasOne(PermissionModel::class,'permission_id');
    }

}