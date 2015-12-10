<?php

abstract class Enum
{
    protected $_value;

    public static function all()
    {
        $reflection = new \ReflectionClass(static::class);
        $constants = $reflection->getConstants();
        unset($constants['__default']);
        return $constants;
    }

    public static function instance($value = null)
    {
        return new static($value);
    }

    function __construct($value = null)
    {
        $reflection = new \ReflectionClass(static::class);
        if (!empty($value)) {
            $this->set($value);
        } elseif($default = $reflection->getConstant('__default')) {
            $this->_value = $default;
        }

        if (empty($this->_value)) {
            throw new \Exception('Enum "' . get_class($this) . '" has not default value. Value argument is required');
        }
    }

    protected function set($value)
    {
        foreach (self::all() as $constantName => $constantValue) {
            if ($value === $constantValue) {
                $this->_value = $constantValue;
            }
        }
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->_value;
    }

    public function __toString()
    {
        return $this->get();
    }
}
