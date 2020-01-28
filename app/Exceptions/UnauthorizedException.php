<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException{
    public function __construct($message = '', $code = 401, Exception $previous = null){
        parent::__construct(401, $message ?: '未授权', $previous, [], $code);
    }
}