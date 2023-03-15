<?php

namespace Ohmangocat\GenBase\Traits;

use support\Response;

trait JsonTrait
{
    private $status = 200;

    public function status(int $status): self
    {
        $this->status = $status;
        return $this;
    }
    public function success($msg = 'Success', ?array $data = null): Response
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg = 'Success';
        }
        return $this->make(0, $msg, $data);
    }

    public function fail($msg = 'Fail', ?array $data = null): Response
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg = 'Fail';
        }
        return $this->make(400, $msg, $data);
    }

    public function make(int $error_code, string $error_message, ?array $data = null): Response
    {
        $res = compact('error_code', 'error_message');
        if (!is_null($data)) {
            $res['data'] = $data;
        }
        return \response(json_encode($res), $this->status, ['Content-Type' => 'application/json']);
    }
}