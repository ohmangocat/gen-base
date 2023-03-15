<?php

namespace Ohmangocat\GenBase\Util;

use Illuminate\Redis\RedisManager;
use support\Redis;

class RedisUtil extends Redis
{
    /**
     * @return RedisManager
     */
    public static function instance(): ?RedisManager
    {
        if (!static::$instance) {
            $config = config('plugin.ohmangocat.gen-base.redis');
            $client = $config['client'] ?? self::PHPREDIS_CLIENT;

            if (!in_array($client, static::$allowClient)) {
                $client = self::PHPREDIS_CLIENT;
            }

            static::$instance = new RedisManager('', $client, $config);
        }
        return static::$instance;
    }
}