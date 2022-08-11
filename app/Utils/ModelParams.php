<?php

namespace App\Utils;

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
        if (!isset($this->offsetExists[$offset])) {
            throw new LogicException(
                "Trying to get param '{$offset}' without previous check using `isset(\$params['$offset'])`."
            );
        }
        $this->offsetGet[$offset] = true;
        return $this->params[$offset] ?? null;
    }

    public function offsetUnset($offset)
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

    /**
     * List all unused parameter keys.
     *
     * @return string[]
     */
    private function getUngetParams()
    {
        $usedKeys = array_keys($this->offsetGet ?? []);
        $paramsKeys = array_keys($this->params);
        return array_diff($paramsKeys, $usedKeys);
    }

    /**
     * Checks used params and throws and exception if some of received params
     * weren't used at any time.
     *
     * @throws LogicException
     */
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
