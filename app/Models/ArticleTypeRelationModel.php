<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTypeRelationModel extends Model{

    protected $table = 'article_type_relation';

    public $timestamps = true;

    protected $guarded = ['id'];
    
}
