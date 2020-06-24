<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTagModel extends Model{

    protected $table = 'article_tag';

    public $timestamps = true;

    protected $guarded = ['id'];
    
}