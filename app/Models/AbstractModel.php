<?php

namespace App\Models;

use LogicException;

abstract class AbstractModel
{
    private static $usedParams = [];

    protected static function hasParam(array $params, string $key)
    {
        static::$usedParams[static::class][$key] = true;
        return array_key_exists($key, $params);
    }

    protected static function getSubparams(array $params, string $key)
    {
        static::$usedParams[static::class][$key] = true;
        if (array_key_exists($key, $params) && is_array($params[$key])) {
            return $params[$key];
        }
        return [];
    }

    protected static function getParam(array $params, string $key)
    {
        static::$usedParams[static::class][$key] = true;
        return $params[$key] ?? null;
    }

    protected static function getUnusedParams(array $params)
    {
        $usedKeys = array_keys(static::$usedParams[static::class] ?? []);
        $paramsKeys = array_keys($params);
        $diffKeys = array_diff($paramsKeys, $usedKeys);
        return $diffKeys;
    }

    protected static function crashUnusedParams(array $params)
    {
        $unusedParams = static::getUnusedParams($params);
        if (count($unusedParams) > 0) {
            throw new LogicException('Unused params: ' . join(', ', $unusedParams));
        }
    }
}
