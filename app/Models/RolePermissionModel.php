<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermissionModel extends Model{

    protected $table = 'role_permission';

    public $timestamps = true;

    protected $guarded = ['id'];

}