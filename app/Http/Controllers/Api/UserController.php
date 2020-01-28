<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Respositories\UserRespository;

class UserController extends ApiController{

    protected $userRespository;

    public function __construct(){
        $this->userRespository = New UserRespository();
    }

    public function userList(){
        return $this->userRespository->userList(\request());
    }

    public function userInfo(){
        return $this->userRespository->userInfo(\request());
    }

    public function userInsert(){
        return $this->userRespository->userInsert(\request());
    }

    public function userUpdate(){
        return $this->userRespository->userUpdate(\request());
    }

    public function userDelete(){
        return $this->userRespository->userDelete(\request());
    }
}