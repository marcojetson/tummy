<?php

namespace Tummy;

class Record implements \IteratorAggregate, \Countable
{
    /** @var array */
    private $properties;

    /**
     * @inheritdoc
     */
    public function __get($property)
    {
        return $this->properties[$property];
    }

    /**
     * @inheritdoc
     */
    public function __set($property, $value)
    {
        $this->properties[$property] = $value;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->properties);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return sizeof($this->properties);
    }
}
