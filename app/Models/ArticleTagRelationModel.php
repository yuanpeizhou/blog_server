<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTagRelationModel extends Model{

    protected $table = 'article_tag_relation';

    public $timestamps = true;

    protected $guarded = ['id'];
    
}