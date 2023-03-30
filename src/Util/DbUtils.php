<?php

namespace Ohmangocat\GenBase\Util;



use support\Db;

class DbUtils extends Db
{
    protected static $instance = null;

    public static function instance(): ?\Illuminate\Database\Connection
    {
        if (!static::$instance) {
            static::$instance = Db::connection("plugin.ohmangocat.gen-base.mysql");
        }
        return self::$instance;
    }

    public static function __callStatic($name, $parameters)
    {
        return static::instance()->{$name}(...$parameters);
    }
}