<?php

namespace App\Models;

use ArrayAccess;
use LogicException;

class ModelParams implements ArrayAccess
{
    private $class;
    private $params;
    private $offsetGet = [];
    private $offsetExists = [];

    public function __construct(array $params, $class = null)
    {
        $this->params = $params;
        $this->class = $class;
    }

    public function offsetSet($offset, $value)
    {
        $this->params[$offset] = $value;
    }

    public function offsetExists($offset): bool
    {
        $this->offsetExists[$offset] = true;
        return array_key_exists($offset, $this->params);
    }

    public function offsetGet($offset)
    {
        $this->offsetGet[$offset] = true;
        return $this->params[$offset] ?? null;
    }

    public function offsetUnset($offset): void
    {
        unset($params[$offset]);
    }

    /**
     * @param string $key
     * @return array
     */
    public function getSubparams($key)
    {
        $value = $this[$key];
        return is_array($value) ? $value : [];
    }

    public function getUngetParams()
    {
        $usedKeys = array_keys($this->offsetGet ?? []);
        $paramsKeys = array_keys($this->params);
        return array_diff($paramsKeys, $usedKeys);
    }

    public function check()
    {
        $ungetParams = $this->getUngetParams();
        if (count($ungetParams) > 0) {
            $message = 'Unused params: ' . join(', ', $ungetParams);
            $message .= isset($this->class) ? " on {$this->class}" : '';
            throw new LogicException($message);
        }
    }
}
