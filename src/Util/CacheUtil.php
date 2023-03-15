<?php

namespace Ohmangocat\GenBase\Util;

use \Symfony\Component\Cache\Psr16Cache;
use support\Cache;

class CacheUtil extends Cache
{

    private static $prefix = 'gen_base_cache_';

    /**
     * @return Psr16Cache
     */
    public static function instance(): Psr16Cache
    {
        return parent::instance();
    }

    public static function __callStatic($name, $arguments)
    {
        if (isset($arguments[0]) && !is_array($arguments[0])) {
            // key,n
            $arguments[0] = self::$prefix . $arguments[0];
        }
        return static::instance()->{$name}(... $arguments);
    }
}