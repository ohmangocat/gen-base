<?php

namespace Ohmangocat\GenBase\Gii;

use Ohmangocat\GenBase\Gii\template\BaseProcessor;

class GiiFactory
{

    /**
     * @param $type
     * @return BaseProcessor
     */
    public static function create($type): BaseProcessor
    {
        $class = __NAMESPACE__ . "\\template\\${type}\\" . ucfirst($type) . "Processor";
        if (class_exists($class)) {
            return new $class();
        }
        throw new \InvalidArgumentException($type . ' biz模板不存在');
    }
}