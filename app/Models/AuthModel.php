<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthModel extends Model{

    public $table = 'auth';

    public $timestamps = true;

    protected $guarded = ['id'];

    protected $dates = ['token_expired_at'];

    /**
     * 登录认证的用户
     */
    public function user(){
        return $this->belongsTo(UserModel::class, 'user_id','id');
    }

}