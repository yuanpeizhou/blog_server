<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoleModel extends Model{

    protected $table = 'user_role';

    public $timestamps = true;

    protected $guarded = ['id'];
   
}