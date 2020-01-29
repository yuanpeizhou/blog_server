<?php
namespace App\Respositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RoleModel;
use App\Exceptions\ParamsErrorException;
use App\Exceptions\InvalidRequestException;

class RoleRespository{

    public function __construct(){
        $this->model = New RoleModel();
    }

    public function roleList($request){
        $pageSize = $request->pageSize ? $request->pageSize : 10;
        $result = $this->model
        ->with('conPermission')
        ->orderBy('created_at','desc')
        ->paginate($pageSize)
        ->toArray();
        return ['code' => 200,'message' => 'ok','data' => $result];
    }

    public function roleInfo($request){
        $role = $this->model
        ->with('conPermission')
        ->find($request->roleId);
        if(!$role){
            throw  New ParamsErrorException('参数错误');
        }
        return ['code' => 200,'message' => 'ok','data' => $role->toArray()];
    }

    public function roleInsert($request){
        DB::beginTransaction();
        try{    
            $this->model->role_name_cn = $request->roleNameCn ? $request->roleNameCn : null;
            $this->model->role_name_en = $request->roleNameEn ? $request->roleNameEn : null;
            $res = $this->model->save();
            if($request->permissionIds && is_array($request->permissionIds)){
                $permissionData = [];
                foreach ($request->permissionIds as $key => $value) {
                    $temp = [];
                    $temp['role_id'] = $this->model->id;
                    $temp['permission_id'] = $value;
                    $temp['created_at'] = date("Y-m-d",time());
                    $temp['updated_at'] = date("Y-m-d",time());
                    $permissionData[] = $temp;
                }
                $rolePermissionModel = $this->getMiddleModel();
                $permissionData && $rolePermissionModel->insert($permissionData);
            }
            DB::commit();
            return ['code' => 200,'message' => 'ok','data' => []]; 
        }catch(\Exception $e){
            DB::rollBack();
            throw New InvalidRequestException('新增权限失败');
        }
    }

    public function roleUpdate($request){
        $role = $this->model->find($request->roleId);
        if(!$role){
            throw  New ParamsErrorException('参数错误');
        }
        DB::beginTransaction();
        try{
            $role->role_name_cn = $request->roleNameCn ? $request->roleNameCn : null;
            $role->role_name_en = $request->roleNameEn ? $request->roleNameEn : null;
            $res = $role->save();
            $rolePermissionModel = $this->getMiddleModel();
            $rolePermissionModel->where('role_id',$request->roleId)->delete();
            if($request->permissionIds && is_array($request->permissionIds)){
                $permissionData = [];
                foreach ($request->permissionIds as $key => $value) {
                    $temp = [];
                    $temp['role_id'] = $request->roleId;
                    $temp['permission_id'] = $value;
                    $temp['created_at'] = date("Y-m-d",time());
                    $temp['updated_at'] = date("Y-m-d",time());
                    $permissionData[] = $temp;
                }
                $permissionData && $rolePermissionModel->insert($permissionData);
            }
            DB::commit();
            return ['code' => 200,'message' => 'ok','data' => []];
        }catch(\Exception $e){
            dd($e->getMessage());
            throw New InvalidRequestException('编辑权限失败');
        }
    }

    public function roleDelete($request){
        $role = $this->model->find($request->roleId);
        if(!$role){
            throw  New ParamsErrorException('参数错误');
        }
        $userRoleModel = $this->getUserRoleModel();

        // $roleByUser = $userRoleModel->where('role_id',$request->roleId)->find();
        // if($roleByUser){
        //     throw New InvalidRequestException('该角色正在被用户使用，请先确保该角色无用户使用再删除');
        // }

        DB::beginTransaction();
        try{
            $res = $role->delete();
            $rolePermissionModel = $this->getMiddleModel();

            $rolePermissionModel->where('role_id',$request->roleId)->delete();
            $userRoleModel->where('role_id',$request->roleId)->delete();
            DB::commit();
            return ['code' => 200,'message' => 'ok','data' => []];
        }catch(\Exception $e){
            DB::rollBack();
            throw New InvalidRequestException('删除权限失败');
        }
    }

    protected function getMiddleModel(){
        return New \App\Models\RolePermissionModel();
    }

    protected function getUserRoleModel(){
        return New \App\Models\UserRoleModel();
    }
}