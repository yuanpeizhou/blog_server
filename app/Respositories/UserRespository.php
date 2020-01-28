<?php
namespace App\Respositories;
use App\Models\UserModel;
use App\Exceptions\ParamsErrorException;
use App\Exceptions\InvalidRequestException;

class UserRepository{

    public function __construct(){
        $this->model = New UserModel();
    }

    public function userList($request){
        $pageSize = $request->pageSize ? $request->pageSize : 10;
        $result = $this->model
        ->select('id','username')
        ->with('conRole','conPermission')
        ->orderBy('created_at','desc')->paginate($pageSize)->toArray();
        return ['code' => 200,'message' => 'ok','data' => $result];
    }

    public function userInfo($request){
        $user = $this->model->with('conRole','conPermission')->find($request->userId);
        if(!$user){
            throw  New ParamsErrorException('参数错误');
        }
        $user->save();
        return ['code' => 200,'message' => 'ok','data' => $user->toArray()];
    }

    public function userInsert($request){
        DB::beginTransaction();
        try{  
            $this->model->user_name = $request->userName ? $request->userName : '';
            $this->model->password = $request->password ? md5($request->password) : '';
            $this->model->email = $request->email ? $request->email : '';
            $res = $this->model->save();
            if($request->roleIds && is_array($request->roleIds)){
                $roleData = [];
                $userRoleModel = $this->getUserRoleModel();
                foreach ($roleIds as $key => $value) {
                    $temp = [];
                    $temp['user_id'] = $this->model->id;
                    $temp['role_id'] = $value;
                    $temp['created_at'] = date("Y-m-d",time());
                    $temp['updated_at'] = date("Y-m-d",time());
                    $roleData[] = $temp;
                }
                $roleData && $userRoleModel->insert($roleData);
            }
            if($request->permissionIds && is_array($request->permissionIds)){
                $permissionData = [];
                $userPermissionModel = $this->getUserPermissionModel();
                foreach ($request->permissionIds as $key => $value) {
                    $temp = [];
                    $temp['user_id'] = $this->model->id;
                    $temp['permission_id'] = $value;
                    $temp['created_at'] = date("Y-m-d",time());
                    $temp['updated_at'] = date("Y-m-d",time());
                    $permissionData[] = $temp;
                }
                $permissionData && $userPermissionModel->insert($permissionData);
            }
            DB::commit();
            return ['code' => 200,'message' => 'ok','data' => []];
        }catch(\Exception $e){
            DB::rollBack();
            throw New InvalidRequestException('新增人员失败');
        }
    }

    public function userUpdate($request){
        $user = $this->model->find($request->userId);
        if(!$user){
            throw  New ParamsErrorException('参数错误');
        }
        DB::beginTransaction();
        try{  
            $user->user_name = $request->user_name ? $request->user_name : '';
            $user->save();
            $userRoleModel = $this->getUserRoleModel();
            $userPermissionModel = $this->getUserPermissionModel();
            $userRoleModel->where('user_id',$request->userId)->delete();
            $userPermissionModel->where('user_id',$request->userId)->delete();

            if($request->roleIds && is_array($request->roleIds)){
                $roleData = [];
                foreach ($roleIds as $key => $value) {
                    $temp = [];
                    $temp['user_id'] = $this->model->id;
                    $temp['role_id'] = $value;
                    $temp['created_at'] = date("Y-m-d",time());
                    $temp['updated_at'] = date("Y-m-d",time());
                    $roleData[] = $temp;
                }
                $roleData && $userRoleModel->insert($roleData);
            }
            if($request->permissionIds && is_array($request->permissionIds)){
                $permissionData = [];
                foreach ($request->permissionIds as $key => $value) {
                    $temp = [];
                    $temp['user_id'] = $this->model->id;
                    $temp['permission_id'] = $value;
                    $temp['created_at'] = date("Y-m-d",time());
                    $temp['updated_at'] = date("Y-m-d",time());
                    $permissionData[] = $temp;
                }
                $permissionData && $userPermissionModel->insert($permissionData);
            }
            DB::commit();
            return ['code' => 200,'message' => 'ok','data' => []];
        }catch(\Exception $e){
            DB::rollBack();
            throw New InvalidRequestException('编辑人员失败');
        }
        
        
    }

    public function userDelete($request){
        $user = $this->model->find($request->userId);
        if(!$user){
            throw  New ParamsErrorException('参数错误');
        }
        $res = $user->delete();
        if(!$res){
            throw New InvalidRequestException('删除人员失败');
        }
        return ['code' => 200,'message' => 'ok','data' => []];
    }

    /*获取人员角色中间表模型*/
    protected function getUserRoleModel(){
        return New \App\Models\UserRoleModel();
    }
    /*获取人员权限中间表模型*/
    protected function getUserPermissionModel(){
        return New \App\Models\UserPermissionModel();
    }
}