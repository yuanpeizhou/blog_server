<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Respositories\RoleRespository;

class roleController extends ApiController{

	function __construct()
	{
	//    $this->user = New \App\User();
    //    $this->role = New Role();
    //    $this->role = New role();
        $this->roleRespository = New RoleRespository();
    }

    public function roleList(){
        return $this->roleRespository->roleList(\request());
    }

    public function roleInfo(){
        return $this->roleRespository->roleInfo(\request());
    }

    public function roleInsert(){
        return $this->roleRespository->roleInsert(\request());
    }

    public function roleUpdate(){
        return $this->roleRespository->roleUpdate(\request());
    }

    public function roleDelete(){
        return $this->roleRespository->roleDelete(\request());
    }

    // public function assignrole(){

    // }

    // public function revokerole(){

    // }


}