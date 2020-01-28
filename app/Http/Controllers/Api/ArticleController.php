<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Respositories\ArticleRepository;

class ArticleControoler extends ApiController{

    protected $articleRepository;

    public function __construct(){
        $this->articleRepository = New ArticleRepository();
    }

    public function articleList(){
        return $this->articleRepository->articleList(\request());
    }

    public function articleInfo(){
        return $this->articleRepository->articleInfo(\request());
    }

    public function articleInsert(){
        return $this->articleRepository->articleInsert(\request());
    }

    public function articleUpdate(){
        return $this->articleRepository->articleUpdate(\request());
    }

    public function articleDelete(){
        return $this->articleRepository->articleDelete(\request());
    }

}