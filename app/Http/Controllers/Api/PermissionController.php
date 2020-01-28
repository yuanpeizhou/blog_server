<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Respositories\PermissionRespository;

class PermissionController extends ApiController{

	function __construct()
	{
	//    $this->user = New \App\User();
    //    $this->role = New Role();
    //    $this->permission = New Permission();
        $this->permissionRespository = New PermissionRespository();
    }

    public function permissionList(){
        return $this->permissionRespository->permissionList(\request());
    }

    public function permissionInfo(){
        return $this->permissionRespository->permissionInfo(\request());
    }

    public function permissionInsert(){
        return $this->permissionRespository->permissionInsert(\request());
    }

    public function permissionUpdate(){
        return $this->permissionRespository->permissionUpdate(\request());
    }

    public function permissionDelete(){
        return $this->permissionRespository->permissionDelete(\request());
    }

    // public function assignPermission(){

    // }

    // public function revokePermission(){

    // }


}