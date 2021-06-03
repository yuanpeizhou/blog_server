<?php
namespace App\Respositories;

use Illuminate\Support\Facades\DB;
use App\Models\ArticleModel;
use App\Exceptions\ParamsErrorException;
use App\Exceptions\InvalidRequestException;
use Exception;
use App\Respositories\BaseRespository;

class ArticleRepository extends BaseRespository{

    public function __construct(){
        $this->model = New ArticleModel();
    }

    /**
     * 文章列表
     * @param page int 页码
     * @param pageSize int 分页大小
     * @param articleTitle string 搜索项(文章标题)
     */
    public function articleList($request){
        
        $pageSize = $request->pageSize ? $request->pageSize : 10;
        $articleTitle = $request->articleTitle;

        $condition[] = ['id' , '>=' , 1];

        if($articleTitle){
            $condition[] = ['article_title','like',"%$articleTitle%"];
        }

        $result = $this->model
        ->where($condition)
        ->orderBy('created_at','desc')
        ->paginate($pageSize);

        return $this->apiReturn(200,'ok',$result->toArray());
    }

    /**文章详情 */
    public function articleInfo($request){

        $article = $this->model->find($request->articleId);

        if(!$article){
            throw New ParamsErrorException('参数错误');
        }

        $article->article_browse++;
        $article->save();

        return $this->apiReturn(200,'ok',$article->toArray());
    }

    /**
     * 录入文章接口
     * @param articleTitle string 文章名称
     * @param articleContent text 文章内容
     * @param articleCover string 文章封面
     * @param articleTypes string(array json) 文章类型
     * @param articleTags string(array json) 文章标签
     */
    public function articleInsert($request){
        $this->model->article_title = $request->articleTitle ? $request->articleTitle : '';
        $this->model->article_content = $request->articleContent ? $request->articleContent : '';
        $this->model->article_cover = $request->articleCover ? $request->articleCover : '';

        $articleTypeList = [];
        $articleTypeSqlData = [];
        if($request->articleTypes){
            $articleTypeList = json_decode($request->articleTypes);

            if(!is_array($articleTypeList)){
                throw New ParamsErrorException('参数错误');
            }
        }

        $articleTagList = [];
        $articleTagSqlData = [];
        if($request->articleTags){
            $articleTagList =  json_decode($request->articleTags);
            
            if(!is_array($articleTagList)){
                throw New ParamsErrorException('参数错误');
            }
        }

        DB::beginTransaction();
        try{

            /**保存文章数据 */
            $this->model->save();

            /**写入文章类型数据 */
            foreach ($articleTypeList as $key => $value) {
                $temp = [];
                $temp['article_id'] = $this->model->id;
                $temp['type_id'] = $value;
                $temp['created_at'] = date("Y-m-d H:i:s",time());
                $articleTypeSqlData[] = $temp;
            }

            $articleTypeRelationModel = New \App\Models\ArticleTypeRelationModel();
            $articleTypeRelationModel->insert($articleTypeSqlData);


            /**写入文章标签内容 */
            foreach ($articleTagList as $key => $value) {
                $temp = [];
                $temp['article_id'] = $this->model->id;
                $temp['tag_id'] = $value;
                $temp['created_at'] = date("Y-m-d H:i:s",time());
                $articleTagSqlData[] = $temp;
            }

            $articleTagRelationModel = New \App\Models\ArticleTagRelationModel();
            $articleTagRelationModel->insert($articleTagSqlData);

            DB::commit();
            return ['code' => 200,'message' => 'ok','data' => []];

            
        }catch(Exception $e){

            DB::rollBack();
            var_dump($e->getMessage());exit;

            throw New InvalidRequestException('文章新增失败');
        }    
    }

    /**
     * 编辑文章接口
     * @param articleId int 文章id
     * @param articleTitle string 文章名称
     * @param articleContent text 文章内容
     * @param articleCover string 文章封面
     * @param articleTypes string(array json) 文章类型
     * @param articleTags string(array json) 文章标签
     */
    public function articleUpdate($request){
        if(!$request->articleId){
            throw New ParamsErrorException('参数错误');
        }

        $article = $this->model->find($request->articleId);

        if(!$article){
            throw New ParamsErrorException('参数错误');
        }

        $article->article_title = $request->articleTitle ? $request->articleTitle : '';
        $article->article_content = $request->articleContent ? $request->articleContent : '';
        $article->article_cover = $request->articleCover ? $request->articleCover : '';

        
        $articleTypeList = [];
        $articleTypeSqlData = [];
        if($request->articleTypes){
            $articleTypeList = json_decode($request->articleTypes);

            if(!is_array($articleTypeList)){
                throw New ParamsErrorException('参数错误');
            }
        }

        $articleTagList = [];
        $articleTagSqlData = [];
        if($request->articleTags){
            $articleTagList =  json_decode($request->articleTags);
            
            if(!is_array($articleTagList)){
                throw New ParamsErrorException('参数错误');
            }
        }

        DB::beginTransaction();
        try{

            /**保存文章数据 */
            $article->save();

            /**写入文章类型数据 */
            foreach ($articleTypeList as $key => $value) {
                $temp = [];
                $temp['article_id'] = $article->id;
                $temp['type_id'] = $value;
                $temp['created_at'] = date("Y-m-d H:i:s",time());
                $articleTypeSqlData[] = $temp;
            }

            $articleTypeRelationModel = New \App\Models\ArticleTypeRelationModel();
            $articleTypeRelationModel->where('article_id',$article->id)->delete();
            $articleTypeRelationModel->insert($articleTypeSqlData);


            /**写入文章标签内容 */
            foreach ($articleTagList as $key => $value) {
                $temp = [];
                $temp['article_id'] = $article->id;
                $temp['tag_id'] = $value;
                $temp['created_at'] = date("Y-m-d H:i:s",time());
                $articleTagSqlData[] = $temp;
            }

            $articleTagRelationModel = New \App\Models\ArticleTagRelationModel();
            $articleTagRelationModel->where('article_id',$article->id)->delete();
            $articleTagRelationModel->insert($articleTagSqlData);

            DB::commit();
            return ['code' => 200,'message' => 'ok','data' => []];

        }catch(Exception $e){

            DB::rollBack();
            var_dump($e->getMessage());exit;

            throw New InvalidRequestException('文章编辑失败');
        }   
    }

    /**
     * 删除文章接口
     * @param articleId int 文章id
     */
    public function articleDelete($request){
        
        $article = $this->model->find($request->articleId);

        if(!$article){
            throw New ParamsErrorException('参数错误');
        }

        $res = $article->delete();

        if(!$res){
            throw New InvalidRequestException('文章删除失败');
        }

        return ['code' => 200,'message' => 'ok','data' => []];
    }
}