<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Respositories\MenuRespository;

class MenuController extends ApiController{

    protected $menuRespository;

    public function __construct(){
        $this->menuRespository = New MenuRespository();
    }

    public function menuList(){
        $this->menuRespository->menuList(request());
    }

    public function menuInfo(){
        $this->menuRespository->menuInfo(request());
    }

    public function menuInsert(){
        $this->menuRespository->menuInsert(request());
    }

    public function menuUpdate(){
        $this->menuRespository->menuUpdate(request());
    }

    public function menuDelete(){
        $this->menuRespository->menuDelete(request());
    }
}