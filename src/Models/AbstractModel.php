<?php

namespace Vendor\App\Models;

abstract class AbstractModel
{
    protected static function getParams(array $params, string $key)
    {
        if (array_key_exists($key, $params) && is_array($params[$key])) {
            return $params[$key];
        }
        return [];
    }
}
