<?php

namespace App\Models;

use LogicException;

abstract class AbstractModel
{
    private static $usedParams = [];

    /**
     * @deprecated Instead use `isset($params['key'])`.
     *
     * @param array $params
     * @param string $key
     * @return boolean
     */
    protected static function hasParam(array $params, string $key)
    {
        static::$usedParams[static::class][$key] = true;
        return array_key_exists($key, $params);
    }

    /**
     * @deprecated Instead use `$params->getSubparams('key')`.
     *
     * @param array $params
     * @param string $key
     * @return void
     */
    protected static function getSubparams(array $params, string $key)
    {
        static::$usedParams[static::class][$key] = true;
        if (array_key_exists($key, $params) && is_array($params[$key])) {
            return $params[$key];
        }
        return [];
    }

    /**
     * @deprecated Instead use `$params['key']`.
     *
     * @param array $params
     * @param string $key
     * @return void
     */
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

    /**
     * @deprecated Instead use `$params->check()`.
     *
     * @param array $params
     * @return void
     */
    protected static function crashUnusedParams(array $params)
    {
        $unusedParams = static::getUnusedParams($params);
        if (count($unusedParams) > 0) {
            throw new LogicException(
                'Unused params: ' . join(', ', $unusedParams) . ' on ' . static::class
            );
        }
    }
}
