<?php

namespace App\Library;

use App\Repositories\AuthRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\AuthModel;

class AuthController{

    public static function verifyByRequest(){
        $token = request()->header('Authorization');
        $token = Str::replaceFirst('Bearer ', '', $token);
        $nowDateTime = Carbon::now()->toDateTimeString();
        $authInfo = AuthModel::where('token', $token)->where('token_expired_at', '>', $nowDateTime)->with('user')->first();
        if($authInfo && $authInfo->user){
            request()->offsetSet('authInfo', $authInfo);
            request()->offsetSet('authUserId', $authInfo->user->id);
            return true;
        }else{
            return false;
        }
    }

    //验证是否有使用api权限
    public static function verifyByApi($userPermissionModel,$userRoleModel){
        $user = \request()->authInfo->user;
        $apiPath = \request()->path();

        $permission = $user->conPermission->toArray();
        if(in_array($apiPath,array_column($permission,'permission_api_path'))){
            return true;
        }

        $role = $user->conRole;
        $rolePermission = [];
        foreach ($role as $key => $value) {
            if($value->conPermission){
                $rolePermission = array_merge($rolePermission,$value->conPermission->toArray());
            }
        }
        if($rolePermission && in_array($apiPath,array_column($permission,'permission_api_path'))){
            return true;
        }

        return false;
    }

    //生成token
    public static function generateToken(){
        $token = md5(time() . mt_rand(1, 10000));
        $expired_at = Carbon::now()->addSeconds(config('misc.token_duration_second'))->toDateTimeString();
        return [
            'token' => $token,
            'expired_at' => $expired_at
        ];
    }

}