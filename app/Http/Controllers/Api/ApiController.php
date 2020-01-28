<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Exceptions\ParamsErrorException;
use Validator;

class ApiController extends Controller{
    protected function validator($params, $rules, $msg = []){
        $validator = Validator::make($params, $rules, $msg);
        if($validator->fails()){
            throw new ParamsErrorException(implode(',', $validator->errors()->all()));
        }else{
            return true;
        }
    }
}