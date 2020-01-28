<?php
namespace App\Respositories;
use Illuminate\Support\Facades\DB;

class MenuRespository{

    protected $model;

    public function __construct(){
        $this->model = New \App\Models\MenuModel();
        $this->menuTreeModel = New \App\Models\MenuTreeModel();
    }

    public function menuListForAdmin($request){

    }

    public function menuListForUser($request){
        
    }

    public function menuInfo($request){
        $menuId = $request->menuId;
        return  $this->model->find($menuId)->toArray();
    }

    public function menuInsert($request){
        $node =$this->getNode($request->parentId);
        if(!$node){

        }
        DB::beginTransaction();
        try{
            DB::table('menu')->where('menu_left','>',$node['left'] - 1)->update(['menu_left' => DB::raw('menu_left + 2')]);
            if($node['depth'] != 1){
                DB::table('menu')->where('menu_right','>',$node['left'] - 1)->update(['menu_right' => DB::raw('menu_right + 2')]);
            }
            $this->model->menu_name = $request->menuName ? $request->menuName : null;
            $this->model->menu_icon = $request->menuIcon ? $request->menuIcon : null;
            $this->model->permission_id = $request->permissionId ? $request->permissionId : null;
            $this->model->menu_left = $node['left'];
            $this->model->menu_right = $node['right'];
            $this->model->menu_depth = $node['depth'];
            $this->model->save();
            DB::commit();
            \response('ok');
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function menuUpdate($request){
        // $parentId = $request->parentId ? $request->paerntId : 0;
        $menuId = $request->menuId;
        DB::beginTransaction();
        try{
            $menu = $this->model->find($menuId);
            $menu->menu_name = $request->menuName ? $request->menuName : null;
            $menu->menu_icon = $request->menuIcon ? $request->menuIcon : null;
            $menu->permission_id = $request->permissionId ? $request->permissionId : null;
            $menu->save();
            DB::commit();
            return ['ok'];
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function menuDelete($request){
        $menu = $this->model->find($request->menuId);
        if(!$menu){

        }
        DB::beginTransaction();
        try{
            $reduceNum = $menu->menu_right - $menu->menu_left + 1;
            // dd($reduceNum);
            $this->model->where('menu_left','>=',$menu->menu_left)->where('menu_right','<=',$menu->menu_right)->delete();
            DB::table('menu')->where('menu_right','>',$menu->menu_right)->update(['menu_right' => DB::raw("menu_right - $reduceNum")]);
            DB::table('menu')->where('menu_left','>',$menu->menu_left)->update(['menu_left' => DB::raw("menu_left - $reduceNum")]);
            DB::commit();
            return ['ok'];
        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    /*获取节点信息 插入时使用*/
    public function getNode($parentId = false){
        /*子节点*/
        if($parentId){
            $node = $this->model->find($parentId);
            if(!$node){
                return false;
            }else{
                return  ['left' => $node->menu_right,'right' => $node->menu_right + 1,'depth' => $node->menu_depth + 1];
            }
        }
        /*一级节点*/
        else{
            $right = $this->model->max('menu_right');
            if($right){
                return ['left' => $right + 1,'right' => $right + 2,'depth' => 1];
            }else{
                return ['left' => 1,'right' => 2,'depth' => 1];
            }
        }
    }
}