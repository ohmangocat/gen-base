<?php

namespace Ohmangocat\GenBase\Exception;

use Ohmangocat\GenBase\Core\GenException;
use Ohmangocat\GenBase\Traits\JsonTrait;
use Webman\Exception\ExceptionHandler as WebmanExceptionHandler;
use Webman\Http\Request;
use Webman\Http\Response;
use Throwable;

class ExceptionHandler extends WebmanExceptionHandler
{
    use JsonTrait;

    protected $responseData = [];

    protected $statusCode = 200;

    protected $header = [];

    protected $errorCode = 400;

    public $errorMessage = 'no error';
    /**
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     */
    public function render(Request $request, Throwable $exception): Response
    {
        $this->addRequestInfoToResponse($request);
        $this->solveAllException($exception);
        $this->addDebugInfoToResponse($exception);
        return $this->buildResponse();
    }

    protected function solveAllException(Throwable $e)
    {
        if ($e instanceof GenException) {
            $this->statusCode = $e->statusCode;
            $this->header = $e->header;
            $this->errorCode = $e->errorCode;
            $this->errorMessage = $e->errorMessage;
            if (isset($e->data)) {
                $this->responseData = array_merge($this->responseData, $e->data);
            }
            return;
        }
        $this->solveExtraException($e);
    }

    /**
     * 调试模式：错误处理器会显示异常以及详细的函数调用栈和源代码行数来帮助调试，将返回详细的异常信息。
     * @param Throwable $e
     * @return void
     */
    protected function addDebugInfoToResponse(Throwable $e): void
    {
        if (config('app.debug', false)) {
            $this->responseData['error_trace'] = explode("\n", $e->getTraceAsString());
            $this->responseData['file'] = $e->getFile();
            $this->responseData['line'] = $e->getLine();
        }
    }
    public function solveExtraException(Throwable $e)
    {
        $this->errorMessage = $e->getMessage();
//        if ($e instanceof ValidateException) {
//            $this->statusCode = 400;
//        } else {
//            $this->statusCode = 500;
//        }
        $this->statusCode = 500;
    }

    /**
     * 请求的相关信息.
     *
     * @param Request $request
     * @return void
     */
    protected function addRequestInfoToResponse(Request $request): void
    {
        $this->responseData = array_merge($this->responseData, [
            'request_url' => $request->method() . ' ExceptionHandler.php' . $request->fullUrl(),
            'timestamp' => date('Y-m-d H:i:s'),
            'client_ip' => $request->getRealIp(),
            'request_param' => $request->all(),
        ]);
    }

    /**
     * 构造 Response.
     *
     * @return Response
     */
    protected function buildResponse(): Response
    {
        return $this->status($this->statusCode)->make($this->errorCode ?? 400, $this->errorMessage, $this->responseData);
    }

    /**
     * @param Throwable $exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
}