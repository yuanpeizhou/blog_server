<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model{

    protected $table = 'permission';

    public $timestamps = true;

    protected $guarded = ['id'];

}