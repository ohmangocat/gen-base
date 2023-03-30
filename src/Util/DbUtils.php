<?php

namespace Ohmangocat\GenBase\Util;



use support\Db;

class DbUtils extends Db
{
    protected static $db = null;

    public static function instance(): ?\Illuminate\Database\Connection
    {
        if (!static::$db) {
            static::$db = Db::connection("plugin.ohmangocat.gen-base.mysql");
        }
        return self::$db;
    }

    public static function __callStatic($name, $parameters)
    {
        return static::instance()->{$name}(...$parameters);
    }
}