<?php

function scanfiles($dir, &$data = [], $excludes = [])
{
    if (is_dir($dir)) {
        if ($path = opendir($dir)) {
            while (false !== $file = readdir($path)) {
                if ('.' === $file
                    || '..' === $file
                    || in_array($dir, $excludes)) {
                    continue;
                }
                scanfiles($dir . DIRECTORY_SEPARATOR . $file, $data);
            }
            closedir($path);
        }
    } elseif (!in_array($dir, $excludes)) {
        $data[] = $dir;
    }
    return $data;
}

if (!function_exists('envHelper')) {
    /**
     * @param $key
     * @param null $default
     * @return array|bool|false|mixed|string
     */
    function envHelper($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            // TODO @Link:https://blog.csdn.net/weixin_30618985/article/details/95339884
            return \MillionMile\GetEnv\Env::get($key, $default);;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

function getFullUrl($attachment) {
    switch ($attachment['storage_mode']) {
        case 1:
            return helpers . phpenvHelper("app_url") . $attachment['url'];
            break;
    }
}


/**
 * App path
 * @param string $path
 * @return string
 */
function route_path(string $path = ''): string
{
    return \path_combine(BASE_PATH . DIRECTORY_SEPARATOR . 'route', $path);
}