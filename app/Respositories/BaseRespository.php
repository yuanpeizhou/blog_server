<?php

namespace App\Respositories;

class BaseRespository
{
    public function apiReturn($code = 200, $msg = 'ok' , $data = null){
        return ['code' => $code , 'msg' => $msg ,'data' => $data];
    }
}