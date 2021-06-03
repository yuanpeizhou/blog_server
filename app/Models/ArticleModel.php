<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleModel extends Model{

    use SoftDeletes;

    protected $table = 'article';

    public $timestamps = true;

    protected $guarded = ['id'];

    protected $dates = ['delete_at'];
    
}