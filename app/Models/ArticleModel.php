<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model{

    protected $table = 'article';

    public $timestamps = true;

    protected $guarded = ['id'];
    
}