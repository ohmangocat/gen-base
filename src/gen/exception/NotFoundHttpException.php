<?php

namespace Ohmangocat\Gen_base\gen\exception;

use Ohmangocat\Gen_base\gen\GenException;

class NotFoundHttpException extends GenException
{

    public $errorCode = 404;

    public $errorMessage = "未找到请求的资源";

}