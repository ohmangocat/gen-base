<?php


namespace Ohmangocat\GenBase\gii;


use Ohmangocat\Gen_base\gen\gii\template\BaseProcessor;

class GiiFactory
{
    /**
     * @param $type
     * @param $biz
     * @return BaseProcessor
     */
    public static function create($type)
    {
        $class = __NAMESPACE__ . "\\template\\${type}\\" . ucfirst($type) . "Processor";
        if (class_exists($class)) {
            return new $class();
        }
        throw new \InvalidArgumentException($type . ' biz模板不存在');
    }
}