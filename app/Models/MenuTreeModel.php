<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuTreeModel extends Model{

    protected $table = 'menu_tree';

    public $timestamps = true;

    protected $guarded = ['id'];
}