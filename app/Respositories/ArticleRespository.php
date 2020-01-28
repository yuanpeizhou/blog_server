<?php
namespace App\Respositories;
use App\Models\ArticleModel;

class ArticleRepository{

    public function __construct(){
        $this->model = New ArticleModel();
    }

    public function articleList($request){
        $pageSize = $request->pageSize ? $request->pageSize : 10;
        $result = $this->model->orderBy('created_at','desc')->paginate($pageSize)->toArray();
        return ['code' => 200,'message' => 'ok','data' => $result];
    }

    public function articleInfo($request){
        $article = $this->model->find($request->articleId);
        if(!$article){

        }
        $article->read_num = $article->read_num++;
        $article->save();
        return ['code' => 200,'message' => 'ok','data' => $article->toArray()];
    }

    public function articleInsert($request){
        $this->model->article_title = $request->articleTitle ? $request->articleTitle : '';
        $this->model->article_content = $request->articlecontent ? $request->articlecontent : '';
        $this->model->article_img = $request->articleImg ? $request->articleImg : '';
        $res = $this->model->save();
        if(!$res){

        }
        return ['code' => 200,'message' => 'ok','data' => []];
    }

    public function articleUpdate($request){
        $article = $this->model->find($request->articleId);
        if(!$article){

        }
        $article->article_title = $request->articleTitle ? $request->articleTitle : '';
        $article->article_content = $request->articlecontent ? $request->articlecontent : '';
        $article->article_img = $request->articleImg ? $request->articleImg : '';
        if(!$res){

        }
        return ['code' => 200,'message' => 'ok','data' => []];
    }

    public function articleDelete($request){
        $article = $this->model->find($request->articleId);
        if(!$article){

        }
        $res = $article->delete();
        if(!$res){

        }
        return ['code' => 200,'message' => 'ok','data' => []];
    }
}