<?php

namespace Ohmangocat\GenBase\exception;

use Ohmangocat\GenBase\GenException;

class NotFoundHttpException extends GenException
{

    public $errorCode = 404;

    public $errorMessage = "未找到请求的资源";

}