<?php
namespace App\Respositories;

use Illuminate\Support\Facades\DB;
use App\Models\ArticleModel;
use App\Exceptions\ParamsErrorException;
use App\Exceptions\InvalidRequestException;
use Exception;

class ArticleRepository{

    public function __construct(){
        $this->model = New ArticleModel();
    }

    public function articleList($request){
        $pageSize = $request->pageSize ? $request->pageSize : 10;
        $result = $this->model->orderBy('created_at','desc')->paginate($pageSize)->toArray();
        // throw New ParamsErrorException();
        return ['code' => 200,'message' => 'ok','data' => $result];
    }

    public function articleInfo($request){
        $article = $this->model->find($request->articleId);
        if(!$article){
            throw New ParamsErrorException('参数错误');
        }
        $article->read_num = $article->read_num++;
        $article->save();
        return ['code' => 200,'message' => 'ok','data' => $article->toArray()];
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


        DB::beginTransaction();
        try{

            /**保存文章数据 */
            $this->model->save();

            /**写入文章类型数据 */
            $articleTypeSqlData = [];
            if($request->articleTypes){
                $articleTypeList = json_decode($request->articleTypes);
                foreach ($articleTypeList as $key => $value) {
                    $temp = [];
                    $temp['article_id'] = $this->model->id;
                    $temp['type_id'] = $value;
                    $articleTypeSqlData[] = $temp;
                }
            }

            /**写入文章标签内容 */
            $articleTagSqlData = [];
            if($request->articleTags){
                $articleTagList = json_decode($request->articleTags);
                foreach ($articleTagList as $key => $value) {
                    $temp['article_id'] = $this->model->id;
                    $temp['tag_id'] = $value;
                    $articleTagSqlData[] = $temp;
                }
            }

            DB::commit();
            return ['code' => 200,'message' => 'ok','data' => []];

            
        }catch(Exception $e){

            DB::rollBack();

            throw New InvalidRequestException('文章新增失败');
        }    
    }

    public function articleUpdate($request){
        $article = $this->model->find($request->articleId);
        if(!$article){
            throw New ParamsErrorException('参数错误');
        }
        $article->article_title = $request->articleTitle ? $request->articleTitle : '';
        $article->article_content = $request->articlecontent ? $request->articlecontent : '';
        $article->article_cover = $request->articleCover ? $request->articleCover : '';

        $res = $article->save();

        if(!$res){
            throw New InvalidRequestException('文章编辑失败');
        }

        return ['code' => 200,'message' => 'ok','data' => []];
    }

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