<?php
namespace App\Respositories;
use App\Models\PermissionModel;
use App\Exceptions\ParamsErrorException;
use App\Exceptions\InvalidRequestException;

class permissionRespository{

    public function __construct(){
        $this->model = New PermissionModel();
    }

    public function permissionList($request){
        $pageSize = $request->pageSize ? $request->pageSize : 10;
        $result = $this->model
        ->orderBy('created_at','desc')
        ->paginate($pageSize)
        ->toArray();
        return ['code' => 200,'message' => 'ok','data' => $result];
    }

    public function permissionInfo($request){
        $permission = $this->model->find($request->permissionId);
        if(!$permission){
            throw  New ParamsErrorException('参数错误');
        }
        return ['code' => 200,'message' => 'ok','data' => $permission->toArray()];
    }

    public function permissionInsert($request){
        $this->model->permission_resource_type = $request->permissionResourceType ? $request->permissionResourceType : null;
        $this->model->permission_name_cn = $request->permissionNameCn ? $request->permissionNameCn : null;
        $this->model->permission_name_en = $request->permissionNameEn ? $request->permissionNameEn : null;
        $this->model->permission_api_path = $request->permissionApiPath ? $request->permissionApiPath : null;
        $res = $this->model->save();
        if(!$res){
            throw New InvalidRequestException('新增权限失败');
        }
        return ['code' => 200,'message' => 'ok','data' => []];
    }

    public function permissionUpdate($request){
        $permission = $this->model->find($request->permissionId);
        if(!$permission){
            throw  New ParamsErrorException('参数错误');
        }
        $permission->permission_resource_type = $request->permissionResourceType ? $request->permissionResourceType : null;
        $permission->permission_name_cn = $request->permissionNameCn ? $request->permissionNameCn : null;
        $permission->permission_name_en = $request->permissionNameEn ? $request->permissionNameEn : null;
        $permission->permission_api_path = $request->permissionApiPath ? $request->permissionApiPath : null;
        $res = $permission->save();
        if(!$res){
            throw New InvalidRequestException('编辑权限失败');
        }
        return ['code' => 200,'message' => 'ok','data' => []];
    }

    public function permissionDelete($request){
        $permission = $this->model->find($request->permissionId);
        if(!$permission){
            throw  New ParamsErrorException('参数错误');
        }
        $res = $permission->delete();
        if(!$res){
            throw New InvalidRequestException('删除权限失败');
        }
        return ['code' => 200,'message' => 'ok','data' => []];
    }
}