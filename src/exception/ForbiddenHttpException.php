<?php

namespace Ohmangocat\GenBase\exception;

use Ohmangocat\GenBase\GenException;

class ForbiddenHttpException extends GenException
{
    public $statusCode = 403;
    public $errorMessage = '对不起，您没有该接口访问权限，请联系管理员';
}