<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\UnauthorizedException;
use App\Library\AuthController;
use App\Models\UserPermissionModel;
use App\Models\UserRoleModel;
class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = AuthController::verifyByRequest();
        if(!$user){
            throw New UnauthorizedException();
        }

        $auth = AuthController::verifyByApi(New UserPermissionModel(),New UserRoleModel());
        if(!$auth){
            throw New UnauthorizedException();
        }

        return $next($request);
    }

    public function terminate($request, $response){
        if(isset($request->authInfo)){
            $offsetSecond = strtotime($request->authInfo->token_expired_at) - time();
            if($offsetSecond < config('misc.token_refresh_gap_second') && $offsetSecond > 0){
                $expire = Carbon::now()->addSeconds(config('misc.token_duration_second'))->toDateTimeString();
                $request->authInfo->token_expired_at = $expire;
                $request->authInfo->save();
            }
        }
    }
}
